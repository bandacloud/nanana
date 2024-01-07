#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <ZMPT101B.h>
#include <HTTPClient.h>

//creating wifi user and password
char ssid[] = "Thandie";
char pass[] = "kjbvl202";

// char ssid[] = "BEATON";
// char pass[] = "bitse111";

const int led1 = 15;
const int led2 = 26;

int status = WL_IDLE_STATUS;

//ip address of the local_server
char server[] = "tms.skilltainment.org";

#include "EmonLib.h"                // Include Emon Library
EnergyMonitor emon1, emon2, emon3;  // Create an instance

LiquidCrystal_I2C lcd(0x27, 20, 4);  // I2C address 0x27, 20 columns, 4 rows

#define SENSITIVITY1 844.55f  //596.25
#define SENSITIVITY2 466.75f  //540.00
#define SENSITIVITY3 569.25f  //569.25

ZMPT101B voltageSensor1(33, 50.0);
ZMPT101B voltageSensor2(32, 50.0);
ZMPT101B voltageSensor3(13, 50.0);

float Voltage1;
float Voltage2;
float Voltage3;

float Current1;
float Current2;
float Current3;

void setup() {
  Serial.begin(115200);
  lcd.init();
  lcd.begin(20, 4);  // Initialize the LCD with the specified column and row values
  lcd.backlight();   // Turn on the backlight

  pinMode(led1, OUTPUT);
  pinMode(led2, OUTPUT);

  emon1.current(34, 6.0);
  emon2.current(35, 7.0);
  emon3.current(14, 24.5);

  voltageSensor1.setSensitivity(SENSITIVITY1);
  voltageSensor2.setSensitivity(SENSITIVITY2);
  voltageSensor3.setSensitivity(SENSITIVITY3);

  lcd.setCursor(5, 1);
  lcd.print("TRANSFORMER");
  lcd.setCursor(6, 2);
  lcd.print("MONITORING");
  lcd.setCursor(7, 3);
  lcd.print("SYSTEM");
  delay(1000);

  wifi_connect();
  lcd.clear();
}

void loop() {
  /****** Measure Voltage *****/

  Current1 = emon1.calcIrms(1480);  //extract Vrms into Variable

  Current2 = emon2.calcIrms(1480);  //extract Vrms into Variable

  Current3 = emon3.calcIrms(1480);  //extract Vrms into Variable

  Voltage1 = voltageSensor1.getRmsVoltage();
  Voltage2 = voltageSensor2.getRmsVoltage();
  Voltage3 = voltageSensor3.getRmsVoltage();

  //Serial Printing
  Serial.print("Phase 1: Voltage: ");
  Serial.print(Voltage1);
  Serial.print("V Phase 2: Voltage:");
  Serial.println(Voltage2);

  //LCD Printing
  lcd.setCursor(0, 0);
  lcd.print("R:");
  lcd.print("V=");
  lcd.print(Voltage1);
  lcd.print("V ");

  lcd.print("I=");
  lcd.print(Current1);
  lcd.print("A");

  lcd.setCursor(0, 1);
  lcd.print("Y:");
  lcd.print("V=");
  lcd.print(Voltage2);
  lcd.print("V ");

  lcd.print("I=");
  lcd.print(Current2);
  lcd.print("A");

  lcd.setCursor(0, 2);
  lcd.print("B:");
  lcd.print("V=");
  lcd.print(Voltage3);
  lcd.print("V ");

  lcd.print("I=");
  lcd.print(Current3);
  lcd.print("A");

  client_connect();
}

void wifi_connect() {
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.print(ssid);
  WiFi.mode(WIFI_STA);
  status = WiFi.begin(ssid, pass);

  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(1000);

    lcd.clear();
    lcd.setCursor(4, 1);
    lcd.print("Connecting to");
    lcd.setCursor(7, 2);
    lcd.print(ssid);
  }

  Serial.println();
  Serial.print(ssid);
  Serial.println(" is connected!");
  Serial.println(WiFi.localIP());

  digitalWrite(led1, HIGH);

  lcd.clear();
  lcd.setCursor(7, 1);
  lcd.print(ssid);
  lcd.setCursor(4, 2);
  lcd.print("is connected");
  delay(500);

  // digitalWrite(led1,HIGH);
}

void client_connect()
{
  WiFiClient client;
  const int httpPort = 80;
  if(!client.connect(server,httpPort)){
    Serial.println("Connection failed");
    digitalWrite(led2,LOW);
    return;
  }

  digitalWrite(led2,HIGH);

  String url = "/php/get.php?v1=" + String(Voltage1) + "&v2=" + String(Voltage2) + "&v3=" + String(Voltage3) + "&c1=" + String(Current1)+ "&c2=" + String(Current2) + "&c3=" + String(Current3);
  Serial.print("Requesting Url: ");
  Serial.println(url);

  client.print(String("GET ") + url + " HTTP/1.1\r\n" + "Host: " + server + "\r\n" + "Connection: close\r\n\r\n");
  delay(500);

  while(client.available()){
    String line = client.readStringUntil('\r');
    Serial.print(line);
  }

  Serial.println();
  Serial.println("Closing connection");
}

