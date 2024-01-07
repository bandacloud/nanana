#include <SoftwareSerial.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include <DHT.h>
#include <DHT_U.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

//creating wifi user and password
char ssid[] = "Obtaining IP address..";
char pass[] = "qwerty12341234";

// const int led1 = 15;
// const int led2 = 26;

int status = WL_IDLE_STATUS;

//ip address of the local_server
char server[] = "pm.skilltainment.org";
const char* jsonUrl = "http://pm.skilltainment.org/php/read-pump-data.php";  // Replace with the URL of the JSON data.

#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 64
#define OLED_RESET -1  // Reset pin # (or -1 if sharing Arduino reset pin)

Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);

#define RE 33
#define DE 32

#define DHTPIN 18  // Digital pin connected to the DHT sensor
#define moistPin 34
#define relay 19  // Digital pin connected to the Relay sensor

byte moisture = 0;
byte val1, val2, val3;
float temperature;
byte humidity;
const char* pumpStatus;

// Uncomment the type of sensor in use:
#define DHTTYPE DHT11  // DHT 11

DHT_Unified dht(DHTPIN, DHTTYPE);

uint32_t delayMS;

const byte nitro[] = { 0x01, 0x03, 0x00, 0x1e, 0x00, 0x01, 0xe4, 0x0c };
const byte phos[] = { 0x01, 0x03, 0x00, 0x1f, 0x00, 0x01, 0xb5, 0xcc };
const byte pota[] = { 0x01, 0x03, 0x00, 0x20, 0x00, 0x01, 0x85, 0xc0 };

byte values[11];
SoftwareSerial mod(17, 16);

void setup() {
  Serial.begin(115200);

  mod.begin(4800);

  pinMode(RE, OUTPUT);
  pinMode(DE, OUTPUT);
  pinMode(relay, OUTPUT);

  pinMode(moistPin, INPUT);

  // Initialize with the I2C addr 0x3D (for the 128x64)
  display.begin(SSD1306_SWITCHCAPVCC, 0x3C);  //initialize with the I2C addr 0x3C (128x64)

  // Initialize device.
  dht.begin();
  Serial.println(F("DHTxx Unified Sensor Example"));
  // Print temperature sensor details.
  sensor_t sensor;
  dht.temperature().getSensor(&sensor);
  Serial.println(F("------------------------------------"));
  Serial.println(F("Temperature Sensor"));
  Serial.print(F("Sensor Type: "));
  Serial.println(sensor.name);
  Serial.print(F("Driver Ver:  "));
  Serial.println(sensor.version);
  Serial.print(F("Unique ID:   "));
  Serial.println(sensor.sensor_id);
  Serial.print(F("Max Value:   "));
  Serial.print(sensor.max_value);
  Serial.println(F("°C"));
  Serial.print(F("Min Value:   "));
  Serial.print(sensor.min_value);
  Serial.println(F("°C"));
  Serial.print(F("Resolution:  "));
  Serial.print(sensor.resolution);
  Serial.println(F("°C"));
  Serial.println(F("------------------------------------"));
  // Print humidity sensor details.
  dht.humidity().getSensor(&sensor);
  Serial.println(F("Humidity Sensor"));
  Serial.print(F("Sensor Type: "));
  Serial.println(sensor.name);
  Serial.print(F("Driver Ver:  "));
  Serial.println(sensor.version);
  Serial.print(F("Unique ID:   "));
  Serial.println(sensor.sensor_id);
  Serial.print(F("Max Value:   "));
  Serial.print(sensor.max_value);
  Serial.println(F("%"));
  Serial.print(F("Min Value:   "));
  Serial.print(sensor.min_value);
  Serial.println(F("%"));
  Serial.print(F("Resolution:  "));
  Serial.print(sensor.resolution);
  Serial.println(F("%"));
  Serial.println(F("------------------------------------"));
  // Set delay between sensor readings based on sensor details.
  delayMS = sensor.min_delay / 1000;

  delay(500);
  display.clearDisplay();
  display.setCursor(20, 15);
  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.print("Plant Monitoring");
  display.setCursor(50, 30);
  display.print("System");
  display.display();

  display.clearDisplay();
  delay(500);
  display.setCursor(25, 35);
  display.setTextSize(1);
  display.print("Initializing");
  delay(1000);

  // Clear the display
  display.clearDisplay();

  // Set text size and color
  display.setTextSize(1);
  display.setTextColor(SSD1306_WHITE);

  wifi_connect();
}

void loop() {
  // Initialize JSON document
  StaticJsonDocument<512> doc;  // Adjust the size based on your JSON data size

  // Make an HTTP GET request
  HTTPClient http;
  http.begin(jsonUrl);

  int httpResponseCode = http.GET();

  // Check for a successful request
  if (httpResponseCode == 200) {
    Serial.println("HTTP GET request successful");

    // Parse JSON
    DeserializationError error = deserializeJson(doc, http.getString());

    // Check for JSON parsing errors
    if (error) {
      Serial.print("JSON parsing failed: ");
      Serial.println(error.c_str());
    } else {
      // Access JSON data
      pumpStatus = doc["pump"][0]["status"];  //extracting the gate status

      Serial.println("\n");
      Serial.print("Value from JSON-> status:");
      Serial.print(pumpStatus);
      Serial.println("\n");
    }

    val1 = nitrogen();
    delay(250);
    val2 = phosphorous();
    delay(250);
    val3 = potassium();
    delay(250);

    int anaRead = analogRead(moistPin);
    moisture = map(anaRead, 0, 4095, 100, 0);

    // Delay between measurements.
    delay(delayMS);
    // Get temperature event and print its value.
    sensors_event_t event;

    // Get humidity event and print its value.
    dht.humidity().getEvent(&event);
    if (isnan(event.relative_humidity)) {
      Serial.println(F("Error reading humidity!"));
    } else {
      Serial.print(F("Humidity: "));
      Serial.print(event.relative_humidity);
      Serial.println(F("%"));

      display.setCursor(5, 18);
      display.print("Hum:");
      display.print(event.relative_humidity);
      display.print(" %");
      humidity = event.relative_humidity;
    }

    Serial.print("Nitrogen: ");
    Serial.print(val1);
    Serial.println(" mg/kg");
    Serial.print("Phosphorous: ");
    Serial.print(val2);
    Serial.println(" mg/kg");
    Serial.print("Potassium: ");
    Serial.print(val3);
    Serial.println(" mg/kg");

    display.clearDisplay();

    // Draw vertical line to separate columns
    display.drawLine(SCREEN_WIDTH / 2.5, 0, SCREEN_WIDTH / 2.5, SCREEN_HEIGHT, SSD1306_WHITE);
    display.drawLine(SCREEN_WIDTH / 1.01, 0, SCREEN_WIDTH / 1.01, SCREEN_HEIGHT, SSD1306_WHITE);
    display.drawLine(SCREEN_WIDTH / 128, 0, SCREEN_WIDTH / 128, SCREEN_HEIGHT, SSD1306_WHITE);

    // Draw horizontal line to separate headers from data
    display.drawLine(0, 10, SCREEN_WIDTH, 10, SSD1306_WHITE);

    dht.temperature().getEvent(&event);
    if (isnan(event.temperature)) {
      Serial.println(F("Error reading temperature!"));
    } else {
      Serial.print(F("Temperature: "));
      Serial.print(event.temperature);
      Serial.println(F("°C"));

      // Print column headers
      display.setCursor(60, 0);
      display.print(event.temperature);
      display.print(" C");
      display.setCursor(5, 0);
      display.print("Temp");
      temperature = event.temperature;
    }

    display.drawLine(0, 20, SCREEN_WIDTH, 20, SSD1306_WHITE);

    // Print column headers
    display.setCursor(5, 12);
    display.print("Moist");
    display.setCursor(60, 12);
    display.print(moisture);
    display.print(" %");

    display.drawLine(0, 35, SCREEN_WIDTH, 35, SSD1306_WHITE);

    // Print column headers
    display.setCursor(5, 24);
    display.print("N");
    display.setCursor(60, 24);
    display.print(val1);
    display.print(" mg/kg");

    display.drawLine(0, 50, SCREEN_WIDTH, 50, SSD1306_WHITE);

    // Print column headers
    display.setCursor(5, 38);
    display.print("P");
    display.setCursor(60, 38);
    display.print(val2);
    display.print(" mg/kg");

    display.drawLine(0, 75, SCREEN_WIDTH, 75, SSD1306_WHITE);
    // Print column headers
    display.setCursor(5, 54);
    display.print("K");
    display.setCursor(60, 54);
    display.print(val3);
    display.print(" mg/kg");
    display.display();

    if (strcmp(pumpStatus, "on") == 0) {
      digitalWrite(relay, HIGH);
    } else {
      digitalWrite(relay, LOW);
    }

    client_connect();  //sending data to the cloud

  } else {
    Serial.print("HTTP GET request failed, error code: ");
    Serial.println(httpResponseCode);
  }
  http.end();
}

byte nitrogen() {
  digitalWrite(DE, HIGH);
  digitalWrite(RE, HIGH);
  delay(50);
  if (mod.write(nitro, sizeof(nitro)) == 8) {
    digitalWrite(DE, LOW);
    digitalWrite(RE, LOW);
    for (byte i = 0; i < 7; i++) {
      //Serial.print(mod.read(),HEX);
      values[i] = mod.read();
      //Serial.print(values[i],HEX);
    }
    Serial.println();
  }
  return values[4];
}

byte phosphorous() {
  digitalWrite(DE, HIGH);
  digitalWrite(RE, HIGH);
  delay(50);
  if (mod.write(phos, sizeof(phos)) == 8) {
    digitalWrite(DE, LOW);
    digitalWrite(RE, LOW);
    for (byte i = 0; i < 7; i++) {
      //Serial.print(mod.read(),HEX);
      values[i] = mod.read();
      //Serial.print(values[i],HEX);
    }
    Serial.println();
  }
  return values[4];
}

byte potassium() {
  digitalWrite(DE, HIGH);
  digitalWrite(RE, HIGH);
  delay(50);
  if (mod.write(pota, sizeof(pota)) == 8) {
    digitalWrite(DE, LOW);
    digitalWrite(RE, LOW);
    for (byte i = 0; i < 7; i++) {
      //Serial.print(mod.read(),HEX);
      values[i] = mod.read();
      //Serial.print(values[i],HEX);
    }
    Serial.println();
  }
  return values[4];
}