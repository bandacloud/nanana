#include <SD.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <ZMPT101B.h>  // Include ZMPT101B
#include <Keypad.h>    // Include Keypad
#include "EmonLib.h"   // Include Emon Library

#define SENSITIVITY 370.25f  //sensitivity of VT

EnergyMonitor emon1;               // Create an instance of CT
ZMPT101B voltageSensor(A1, 50.0);  // Create an instance of VT

LiquidCrystal_I2C lcd(0x27, 20, 4);  // I2C address 0x27, 20 columns, 4 rows

const int chipSelect = 53;  //SS of SPI Protocol

/******************* Variables and Arrays *******************/
String token[30];               // token array
String actualToken;             //Token in string
String meterNumber = "265001";  //systems ID
String decryptedToken;
int shift = 3;         //to shift tokens
int tokenAmount;       //Amount bought
float energyConsumed;  //The energy the system has consumed
float difference = 0;
int energyBought;
int tokenSize = 0;  //token index
int simulationCount = 0;
const int buzzer = 44;
const int relay = 6;
const int redLed = 34;
const int yellowLed = 35;

/******************* WIFI Credentials ********************/
String ssid = "BEATON";        //Your SSID
String password = "bitse111";  //your PASSWORD

String postData;
String server = "voltify.malawisounds.com";  // www.example.com or IP
String url = "/php/post.php";                // our example is /esppost.php

/**************** Sensor Parameters **********************/
float voltage;
float current;
double energy = 0.0;
const float samplesIntervalMs = 1000;  // Interval between energy calculations in milliseconds (1 second in this case
unsigned long currentMillis = 0;
unsigned long previousMillis = 1000;

/************ Used Token Validation  Parameters*************/
const int maxDataCount = 50;    // Maximum number of strings to store
String tokenArr[maxDataCount];  // Array to store the strings
int dataCount = 0;              // Number of strings stored in the array

int mode = 0;       //0 mode shows the
int powerMode = 0;  //mode of power

const byte ROWS = 4;  //four rows
const byte COLS = 3;  //four columns

char keys[ROWS][COLS] = {
  { '1', '2', '3' },
  { '4', '5', '6' },
  { '7', '8', '9' },
  { '*', '0', '#' }
};

byte rowPins[ROWS] = { 22, 23, 24, 25 };  //connect to the row pinouts of the keypad
byte colPins[COLS] = { 26, 27, 28 };      //connect to the column pinouts of the keypad

//Create an object of keypad
Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS);

void setup() {
  Serial.begin(115200);
  Serial3.begin(115200);

  pinMode(relay, OUTPUT);
  pinMode(buzzer, OUTPUT);
  pinMode(redLed, OUTPUT);
  pinMode(yellowLed, OUTPUT);

  lcd.init();
  lcd.backlight();  // Turn on the backlight

  digitalWrite(buzzer, HIGH);
  lcd.setCursor(6, 1);
  lcd.print("VOLTIFY");
  delay(1000);
  digitalWrite(buzzer, LOW);
  lcd.clear();

  //Check if SD is not initialized
  if (!SD.begin(chipSelect)) {
    Serial.println("Failed to initialize SD Card");
  }

  voltageSensor.setSensitivity(SENSITIVITY);  //set sensitivity of VT
  emon1.current(2, 205.1);                    // Current: input pin, calibration.

  // Open data file in write mode
  File boughtFile = SD.open("bought.txt", FILE_WRITE);
  //opening the consumed.txt
  if (boughtFile) {
    Serial.println("bought.txt opened.");

    lcd.setCursor(1, 1);
    lcd.print("Fie-1 File Opened");
    delay(30);

    // boughtFile.println(1);
    boughtFile.close();
  } else {
    Serial.println("failed to open bought.txt 1");
  }

  // readMeterNumber(); //load meter number
  readEnergyBought();  // load purchased value into energyBought;

  File consumedFile = SD.open("consumed.txt", FILE_WRITE);
  //opening the consumed.txt
  if (consumedFile) {
    Serial.println("consumed.txt opened.");

    lcd.setCursor(1, 1);
    lcd.print("File-2 File Opened");
    delay(30);
    lcd.clear();

    // consumedFile.println(0.0);
    consumedFile.close();
  } else {
    Serial.println("failed to open purchased.txt 1");
  }

  resetConn();
  connectWifi();
}

void loop() {
  char key = keypad.getKey();  // Read the key
  currentMillis = millis();    // calculate time in milliseconds

  /**************************** MODE 0 ~ Parameters Mode ******************************/
  if (mode == 0) {
    if (powerMode == 0) {                       //if we are in real time mode
      voltage = voltageSensor.getRmsVoltage();  //read voltage from VT
      current = emon1.calcIrms(1480);           //read current from CT
    }

    //filtering noise voltage
    if (voltage < 15) {
      voltage = 0.0;
    }

    readEnergy();
    //if energy reaches zero
    difference = float(energyBought) - energyConsumed;
    if (difference <= 0.0) {
      current = 0;
      resetBalances();
      digitalWrite(relay, LOW);
      if (currentMillis >= previousMillis) {
        showParameters();  //show energy, voltage and current
      }    } else {
      
      if (voltage > 300) {
        digitalWrite(relay, LOW);
      } else {
        digitalWrite(relay, HIGH);
      }

      if (currentMillis >= previousMillis) {
        updateEnergyConsumed();  //update the energyConsumed to SD Card
        showParameters();        //show energy, voltage and current
      }
    }

    if (key) {
      mode = 1;  // set mode to input
    }
    //creating an url for the local_server
    postData = "power=" + String(voltage * current) + "&meterNumber=" + String(meterNumber);  // data sent must be under this form //name1=value1&name2=value2.
    httpPost();

  }
  /***************************** MODE 1 ~ Token Input Mode ******************************/
  else if (mode == 1) {

    if (key && key == '*') {  //if * is pressed
      //making sure that index of token array be >= 0
      if (tokenSize >= 0) {
        removeNumber();  //remove the last number in actualToken String
        --tokenSize;

        //Printing on Serial Monitor
        Serial.print("Key:");
        Serial.print(key);
        Serial.print("\t");
        Serial.print("Index:");
        Serial.println(tokenSize);

        lcd.setCursor(4, 0);
        lcd.print("Enter Token");
        lcd.setCursor(0, 1);
        lcd.print(actualToken);
        lcd.setCursor(2, 3);
        lcd.print("Del[*]  Enter[#]");
        delay(90);
      } else {
        tokenSize = 0;
        mode = 0;  //goto showParameters
      }

    } else if (key && key == '#') {  //if # is pressed
      validateToken();
    } else if (key) {  // if you enter any value btwn 0 - 9
      token[tokenSize] = key;

      //Printing on Serial Monitor
      Serial.print("Key:");
      Serial.print(key);
      Serial.print("\t");
      Serial.print("Index:");
      Serial.println(tokenSize);

      mergeToken();
      lcd.setCursor(4, 0);
      lcd.print("Enter Token");
      lcd.setCursor(0, 1);
      lcd.print(actualToken);
      lcd.setCursor(2, 3);
      lcd.print("Del[*]  Enter[#]");
      ++tokenSize;
    }
    // delay(50);

  }

  /***************************** MODE 2 ~ Simulation Mode ******************************/
  else if (mode == 2) {
    if (simulationCount <= 0) {
      resetToken();
    } else {
      lcd.setCursor(0, 0);
      lcd.print("Voltage:");
      lcd.print(actualToken);

      if (key && key == '*') {  //if * is pressed
        //making sure that index of token array be >= 0
        if (tokenSize >= 0) {
          removeNumber();  //remove the last number in actualToken String
          --tokenSize;
          delay(50);
        } else {
          tokenSize = 0;
          mode = 0;  //goto showParameters
        }
      } else if (key && key == '#') {
        voltage = int(actualToken.toInt());
        resetToken();
        simulationCount = 0;
        mode = 3;
        lcd.clear();

      } else if (key) {
        token[tokenSize] = key;
        mergeToken();
        ++tokenSize;
      }
      delay(50);
    }
    ++simulationCount;

  }
  /***************************** MODE 3 ~ Current Mode ******************************/
  else if (mode == 3) {

    if (simulationCount <= 0) {
      resetToken();
    } else {
      lcd.setCursor(0, 0);
      lcd.print("Current:");
      lcd.print(actualToken);

      if (key && key == '*') {  //if * is pressed
        //making sure that index of token array be >= 0
        if (tokenSize >= 0) {
          removeNumber();  //remove the last number in actualToken String
          --tokenSize;
          delay(50);
        } else {
          tokenSize = 0;
          mode = 0;  //goto showParameters
        }
      } else if (key && key == '#') {
        current = int(actualToken.toInt());
        resetToken();
        mode = 0;
        powerMode = 1;
        lcd.clear();
      } else if (key) {
        token[tokenSize] = key;
        mergeToken();
        ++tokenSize;
      }
      delay(50);
    }
    ++simulationCount;
  }
  /********************************** End of MODE 3 ***********************************/
}

void mergeToken() {  //embeds all values in a string
  digitalWrite(buzzer, HIGH);
  lcd.clear();
  actualToken.concat(token[tokenSize]);
  delay(20);
  digitalWrite(buzzer, LOW);
}

void removeNumber() {  //removes the last digit in the string
  digitalWrite(buzzer, HIGH);
  lcd.clear();
  int startIndex = tokenSize - 1;
  int numCharsToRemove = 1;
  String removedSubstring = actualToken.substring(startIndex, startIndex + numCharsToRemove);
  actualToken.replace(removedSubstring, "");
  delay(20);
  digitalWrite(buzzer, LOW);
}

void validateToken() {                                //check if the token is valid
  decryptedToken = decryptToken(actualToken, shift);  //decode the token
  extractTokenData(decryptedToken, meterNumber);      //exctract the amount of energy bought

  lcd.clear();
  lcd.setCursor(4, 1);
  lcd.print("Please Wait...");
  delay(500);
  lcd.clear();

  if (actualToken.length() == 20) {                   //if number of digits are 20
    if (decryptedToken.indexOf(meterNumber) != -1) {  //if the meter number is present on the token

      loadUsedTokens();  //load all used tokens from tokens.txt
      if (!searchToken(actualToken)) {
        addUsedToken(actualToken);

        digitalWrite(buzzer, HIGH);
        lcd.setCursor(6, 1);
        lcd.print("Success !");
        lcd.setCursor(2, 2);
        lcd.print("Amount Bought:");
        lcd.print(tokenAmount);
        updateBoughtBalance(tokenAmount);  //update energyBought

        actualToken = "";  //empty actualToken variable
        resetToken();      //reset token array
        tokenSize = 0;     //set index to 0
        current = 10;
        mode = 0;
        delay(1500);
        digitalWrite(buzzer, LOW);
        lcd.clear();
      } else {
        lcd.setCursor(1, 1);
        lcd.print("Token Already Used");
        delay(700);

        lcd.clear();
        lcd.setCursor(4, 0);
        lcd.print("Enter Token");
        lcd.setCursor(0, 1);
        lcd.print(actualToken);
        lcd.setCursor(2, 3);
        lcd.print("Del[*]  Enter[#]");
      }

    } else {  //alert the user
      lcd.setCursor(5, 1);
      lcd.print("Invalid Token");
      delay(700);

      lcd.clear();
      lcd.setCursor(4, 0);
      lcd.print("Enter Token");
      lcd.setCursor(0, 1);
      lcd.print(actualToken);
      lcd.setCursor(2, 3);
      lcd.print("Del[*]  Enter[#]");
    }
  } else if (actualToken.length() == 3) {  //if we want to enter into simulation mode
    if (actualToken == "005") {
      lcd.setCursor(5, 1);
      lcd.print("Simulation");
      lcd.setCursor(8, 2);
      lcd.print("Mode");
      delay(500);
      lcd.clear();
      mode = 2;
    } else {
      lcd.setCursor(2, 1);
      lcd.print("Incorrect Code!");

      delay(700);

      lcd.clear();
      lcd.setCursor(4, 0);
      lcd.print("Enter Token");
      lcd.setCursor(0, 1);
      lcd.print(actualToken);
      lcd.setCursor(2, 3);
      lcd.print("Del[*]  Enter[#]");
    }
  } else {  //alert the user
    lcd.setCursor(1, 1);
    lcd.print("Digits Not Enough");

    delay(700);

    lcd.clear();
    lcd.setCursor(4, 0);
    lcd.print("Enter Token");
    lcd.setCursor(0, 1);
    lcd.print(actualToken);
    lcd.setCursor(2, 3);
    lcd.print("Del[*]  Enter[#]");
  }
}

String decryptToken(String encryptedToken, int shift) {  //decode the token by normalizing
  String decryptedToken = "";

  for (int i = 0; i < encryptedToken.length(); i++) {
    char c = encryptedToken.charAt(i);
    if (isdigit(c)) {
      // Shift the digit value back to its original position
      int shiftedDigit = (c - '0' - shift + 10) % 10;
      decryptedToken += (char)(shiftedDigit + '0');
    }
  }

  return decryptedToken;
}

void extractTokenData(String decryptedToken, String meterNo) {  //extract the meter number and energy amount
  int delimiterPos = decryptedToken.indexOf(meterNo);

  String tokenAmountStr = decryptedToken.substring(0, delimiterPos);
  tokenAmount = tokenAmountStr.toInt();
}

void updateBoughtBalance(float newValue) {  //about the bought balance
  int updatedValue;
  // Open the data file in read mode
  File boughtFile = SD.open("bought.txt", FILE_READ);
  if (boughtFile) {
    // Read the existing value from the file
    String line = boughtFile.readStringUntil('\n');
    int oldValue = line.toInt();
    boughtFile.close();

    // Perform any necessary updates on the value
    updatedValue = oldValue + newValue;

    SD.remove("bought.txt");
  } else {
    Serial.println("Error opening bought.txt file for reading.");
  }

  // Open the data file in write mode
  File newboughtFile = SD.open("bought.txt", FILE_WRITE);
  if (newboughtFile) {
    // Write the updated value to the file
    newboughtFile.println(updatedValue);
    newboughtFile.close();
  } else {
    Serial.println("Error opening bought.txt file for writing.");
  }
  current = 10;
  readEnergyBought();
}

void resetBalances() {
  // Open the data file in read mode
  File boughtFile = SD.open("bought.txt", FILE_READ);
  if (boughtFile) {
    boughtFile.close();  // Close the file before removing

    // Remove the existing "bought.txt" file
    if (SD.remove("bought.txt")) {
      // Open a new "bought.txt" file in write mode
      File newBoughtFile = SD.open("bought.txt", FILE_WRITE);
      if (newBoughtFile) {
        // Write the updated value to the new file
        newBoughtFile.println(0);
        energyBought = 0;  // Update energy bought
        newBoughtFile.close();
        Serial.println("Bought Balance Set to 0");
      } else {
        Serial.println("Error opening bought.txt for writing.");
      }
    } else {
      Serial.println("Error removing bought.txt.");
    }
  } else {
    Serial.println("Error opening bought.txt for reading.");
  }

  // Open the "consumed.txt" file in write mode
  File consumedFile = SD.open("consumed.txt", FILE_READ);
  if (consumedFile) {
    consumedFile.close();  // Close the file before removing

    // Remove the existing "consumed.txt" file
    if (SD.remove("consumed.txt")) {
      // Open a new "consumed.txt" file in write mode
      File newConsumedFile = SD.open("consumed.txt", FILE_WRITE);
      if (newConsumedFile) {
        // Write the updated value to the new file
        newConsumedFile.println(0.0);
        newConsumedFile.close();
        Serial.println("Consumed Balance Set to 0");
      } else {
        Serial.println("Error opening consumed.txt for writing.");
      }
    } else {
      Serial.println("Error removing consumed.txt.");
    }
  } else {
    Serial.println("Error opening consumed.txt for reading.");
  }
}

void readEnergy() {
  // Open the data file in read mode
  File consumedFile = SD.open("consumed.txt", FILE_READ);
  if (consumedFile) {
    while (consumedFile.available()) {
      String line = consumedFile.readStringUntil('\n');
      // Do something with the data
      // Serial.println(line);
      energyConsumed = line.toFloat();  // Store energy from consumed.txt into energyConsumed variable
    }
    consumedFile.close();
  } else {
    Serial.println("Error opening consumed.txt file for reading.");
  }
}

void readMeterNumber() {
  File meterFile = SD.open("meter.txt", FILE_READ);
  if (meterFile) {
    String line = meterFile.readStringUntil('\n');
    meterNumber = line;  // Remove leading/trailing whitespace
    meterNumber.replace("\r", "");
    meterFile.close();
    Serial.println("Meter number read from file: " + meterNumber);
  } else {
    Serial.println("Error opening meter.txt file for reading.");
  }
}

void readEnergyBought() {
  // Open the data file in read mode
  File boughtFile = SD.open("bought.txt", FILE_READ);
  if (boughtFile) {
    while (boughtFile.available()) {
      String line = boughtFile.readStringUntil('\n');
      // Do something with the data
      // Serial.println(line);
      energyBought = line.toInt();  // Store the value from bought.txt into energyBought variable
    }
    boughtFile.close();
  } else {
    Serial.println("Error opening bought.txt file for reading.");
  }
}

void updateEnergyConsumed() {
  // Calculate energy consumed in kilowatt-hours (Wh)
  energy = (voltage * current * 0.8) / (3600.0);  // Convert from watt-seconds to Wh
  previousMillis = currentMillis + samplesIntervalMs;

  Serial.print("Time:");
  Serial.print(currentMillis);
  Serial.print(" ");

  // Serial.print("T:");
  // Serial.print(previousMillis);
  // Serial.print(" ");

  Serial.print("Power:");
  Serial.print(current * voltage);
  Serial.print(" ");

  Serial.print("Voltage:");
  Serial.print(voltage);
  Serial.print(" ");

  Serial.print("Current:");
  Serial.print(current);
  Serial.print(" ");

  Serial.print("Increment:");
  Serial.print(energy, 5);
  Serial.print(" ");

  Serial.print("bought:");
  Serial.print(energyBought);
  Serial.print(" ");

  Serial.print("consumed:");
  Serial.println(energyConsumed, 6);

  // Open the data file in read mode
  File consumedFile = SD.open("consumed.txt", FILE_READ);
  if (consumedFile) {
    // Read the existing value from the file
    String line = consumedFile.readStringUntil('\n');
    float oldValue = line.toFloat();
    consumedFile.close();

    // Calculate the updated value
    float updatedValue = oldValue + energy;

    // Remove the old file
    SD.remove("consumed.txt");

    // Open the data file in write mode
    consumedFile = SD.open("consumed.txt", FILE_WRITE);
    if (consumedFile) {
      // Write the updated value to the file with precision of 10 decimal places
      consumedFile.println(updatedValue, 10);
      consumedFile.close();
    } else {
      Serial.println("Error opening consumed.txt file for writing.");
    }
  } else {
    Serial.println("Error opening consumed.txt file for reading.");
  }
}

void resetToken() {  //reset token input
  actualToken = "";  //empty actualToken variable
  for (int i = 0; i < tokenSize; i++) {
    token[i] = '\0';  // Set each element to null terminator
  }
  tokenSize = 0;  //set index to 0
}

void addUsedToken(String token) {
  File tokenFile = SD.open("tokens.txt", FILE_WRITE);
  //opening the consumed.txt
  if (tokenFile) {
    Serial.println("tokens.txt opened.");

    tokenFile.println(token);
    tokenFile.close();
  } else {
    Serial.println("failed to open tokens.txt");
  }
}

void loadUsedTokens() {
  File dataFile = SD.open("tokens.txt");
  if (dataFile) {
    while (dataFile.available()) {
      if (dataCount < maxDataCount) {
        tokenArr[dataCount] = dataFile.readStringUntil('\n');
        dataCount++;
      } else {
        Serial.println("Maximum data count reached.");
        break;
      }
    }
    dataFile.close();
  } else {
    Serial.println("Error opening tokens file.");
  }
}

bool searchToken(String target) {  //search data in an array
  for (int i = 0; i < dataCount; i++) {
    tokenArr[i].replace("\r", "");
    if (tokenArr[i] == target) {
      return true;  // String found in the array
    }
  }
  return false;  // String not found in the array
}

void showParameters() {  // show all important parameters
  // lcd.clear();
  lcd.setCursor(1, 0);
  lcd.print("Units (Whr): ");
  lcd.print(float(energyBought) - energyConsumed);

  lcd.setCursor(1, 1);
  lcd.print("Voltage (V): ");
  lcd.print(voltage);

  lcd.setCursor(1, 2);
  lcd.print("Current (A): ");
  lcd.print(current, 2);

  lcd.setCursor(1, 3);
  lcd.print("**** voltify ****");
}