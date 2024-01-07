#include <HTTPClient.h>
#include <WiFiClientSecure.h>
#include <ssl_client.h>
#include <ETH.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include <WiFi.h>
#include <WiFiAP.h>
#include <WiFiClient.h>
#include <WiFiGeneric.h>
#include <WiFiMulti.h>
#include <WiFiSTA.h>
#include <WiFiScan.h>
#include <WiFiServer.h>
#include <WiFiType.h>
#include <WiFiUdp.h>
#include <ESP32Servo.h>
#include <analogWrite.h>
#include <ESP32Tone.h>
#include <ESP32PWM.h>

//creating wifi user and password
char ssid[] = "Wama";
char pass[] = "massy@6789";

String PROJECT_API_KEY = "wt9mhker";

int status = WL_IDLE_STATUS;

//ip address of the local_server
char server[] = "level-crossing.malawisounds.com";
const char* jsonUrl = "https://level-crossing.malawisounds.com/php/read-gate-data.php";  // Replace with the URL of the JSON data.

Servo servo1;
Servo servo2;

const int irSensorPin1 = 22;  // Connect IR sensor 1 to digital pin 2
const int irSensorPin2 = 18;  // Connect IR sensor 2 to digital pin 3

const char* mode;
const char* statusJson;
const char* direction;

const int redLed = 16;
const int greenLed = 5;
const int blueLed = 27;
const int whiteLed = 26;

int position = 0;

bool irSensor1Triggered = false;
bool irSensor2Triggered = false;

String gateStatus = "closed";

void setup() {
  Serial.begin(115200);
  servo1.attach(17);  // Connect servo 1 to PWM pin 9
  servo2.attach(21);  // Connect servo 2 to PWM pin 10

  pinMode(irSensorPin1, INPUT);
  pinMode(irSensorPin2, INPUT);
  pinMode(redLed, OUTPUT);
  pinMode(greenLed, OUTPUT);
  pinMode(whiteLed, OUTPUT);
  pinMode(blueLed, OUTPUT);

  //connecting to wifi
  wifi_connect();

  rotateServosTo0();

  digitalWrite(greenLed, LOW);
  digitalWrite(redLed, HIGH);
}

void loop() {

  int irSensor1Value = digitalRead(irSensorPin1);
  int irSensor2Value = digitalRead(irSensorPin2);

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
      mode = doc["gate"][0]["mode"];            //extracting the mode
      statusJson = doc["gate"][0]["status"];    //extracting the gate status
      direction = doc["gate"][0]["direction"];  //extracting the gate direction

      Serial.println("\n");
      Serial.print("Value from JSON-> mode:");
      Serial.print(mode);
      Serial.print(" Status:");
      Serial.print(statusJson);
      Serial.print(" Direction:");
      Serial.println(direction);
      Serial.println("\n");
    }

    // Create a string with the sensor values
    String sensorValues = "IRSensor1: " + String(irSensor1Value) + " - IRSensor2: " + String(irSensor2Value) + " - Position: " + String(position);

    // Print the sensor values on the same line
    Serial.println(sensorValues);

    if (strcmp(mode, "auto") == 0) {  //if we are in auto mode

      if (irSensor1Value == LOW) {
        // IR sensor 1 is triggered first, rotate both servos from 0 to 90 degrees
        if (strcmp(direction, "ltr") == 0) {
          position = 1;
          rotateServosTo90();

          gateStatus = "opened";
          digitalWrite(greenLed, HIGH);
          digitalWrite(redLed, LOW);
        } else {
          if (position == 1) {
            rotateServosTo0();
            position = 0;

            gateStatus = "closed";
            digitalWrite(greenLed, LOW);
            digitalWrite(redLed, HIGH);
          }
        }
      }

      if (irSensor2Value == LOW) {
        // IR sensor 2 is triggered first, rotate both servos from 90 to 0 degrees
        if (strcmp(direction, "rtl") == 0) {
          position = 1;
          rotateServosTo90();

          gateStatus = "opened";
          digitalWrite(greenLed, HIGH);
          digitalWrite(redLed, LOW);

        } else {
          if (position == 1) {
            rotateServosTo0();
            position = 0;

            gateStatus = "closed";
            digitalWrite(greenLed, LOW);
            digitalWrite(redLed, HIGH);
          }
        }
      }

    } else if (strcmp(mode, "manual") == 0) {  // if we are in manual mode
      if (strcmp(statusJson, "opened") == 0) {
        rotateServosTo90();
        gateStatus = "opened";
        digitalWrite(greenLed, HIGH);
        digitalWrite(redLed, LOW);
      } else {
        rotateServosTo0();
        gateStatus = "closed";
        digitalWrite(greenLed, LOW);
        digitalWrite(redLed, HIGH);
      }
    }

    client_connect();  //send data to web

  } else {
    Serial.print("HTTP GET request failed, error code: ");
    Serial.println(httpResponseCode);
  }
  http.end();
}

void resetTriggeredFlags() {
  irSensor1Triggered = false;
  irSensor2Triggered = false;
}

void rotateServosTo90() {
  // Rotate both servos from 0 to 90 degree
  servo1.write(90);
  servo2.write(90);
}

void rotateServosTo0() {
  // Rotate both servos from 90 to 0 degrees
  servo1.write(180);
  servo2.write(0);
}