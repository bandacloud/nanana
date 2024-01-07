#include <ETH.h>
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
#include <Wire.h> 
#include <Adafruit_Sensor.h>
#include <DHT.h>
#include <DHT_U.h>

//declaring dht type and pin
#define DHTPIN 26
#define DHTTYPE DHT22

//creating wifi user and password
char ssid[]="BEATON";
char pass[]="bitse111";

int status=WL_IDLE_STATUS;

//ip address of the local_server
char server[]="192.168.234.95";

//variables of hum and temp
float hum;
float temp;

//declaring DHT pin
DHT_Unified dht(DHTPIN, DHTTYPE);

uint32_t delayMS;

WiFiClient client;
void setup()
{
  Serial.begin(115200);

  dht.begin();
  
  // Print temperature sensor details.
  sensor_t sensor;
      
  //connecting to wifi
  wifi_connect();
  
  Serial.print("TEMPERATURE");
  Serial.print("\t");
  Serial.print("HUMIDITY");
  Serial.print("\t");
  
  // Set delay between sensor readings based on sensor details.
  delayMS = sensor.min_delay / 1000;
}

void loop()
{

  // Delay between measurements.
  delay(delayMS);
  // Get temperature event and print its value.
  sensors_event_t event;
  
  dht.temperature().getEvent(&event);

  temp=event.temperature;

  if (isnan(temp)) {
    Serial.println(F("Error reading temperature!"));
  }
  else {
    Serial.print(F("Temperature: "));
    Serial.print(temp);
    Serial.println(F("°C"));
  }
  // Get humidity event and print its value.
  dht.humidity().getEvent(&event);

  hum=event.relative_humidity;
  if (isnan(hum)) {
    Serial.println(F("Error reading humidity!"));
  }
  else {
    Serial.print(F("Humidity: "));
    Serial.print(hum);
    Serial.println(F("%"));
  }  
    
  //sending data to the client
  client_connect();
  delay(3000);
}
