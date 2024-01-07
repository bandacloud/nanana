#include <Adafruit_MPU6050.h>
#include <Adafruit_Sensor.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include <ETH.h>
#include <HTTPClient.h>

// creating wifi user and password
char ssid[] = "Redmi Note 9 Pro";
char pass[] = "mike99999";

int status = WL_IDLE_STATUS;

// ip address of the local_server
char server[] = "esds.skilltainment.org";

#define SCREEN_WIDTH 128
#define SCREEN_HEIGHT 32
#define OLED_RESET -1
#define SCREEN_ADDRESS 0x3C

#define buzzer 19
#define btn 18

const int threshold = 5;
const int graphWidth = SCREEN_WIDTH - 20;
const int graphHeight = 40;
const int graphX = 10;
const int graphY = SCREEN_HEIGHT - graphHeight - 10;

const int lm35dh = 34;

Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);
Adafruit_MPU6050 mpu;

const int yellowLed = 14;
const int whiteLed = 26;
float linearMag = 0;
float angularMag = 0;

float xValue;
float yValue;
float zValue;

int temperature;

void setup(void)
{
  pinMode(buzzer, OUTPUT);
  pinMode(whiteLed, OUTPUT);
  pinMode(yellowLed, OUTPUT);
  pinMode(btn, INPUT_PULLUP);
  pinMode(lm35dh, INPUT);

  Serial.begin(115200);
  while (!Serial)
    delay(10); // will pause Zero, Leonardo, etc until serial console opens

  Serial.println("Adafruit MPU6050 test!");

  // Try to initialize!
  if (!mpu.begin())
  {
    Serial.println("Failed to find MPU6050 chip");
    while (1)
    {
      delay(10);
    }
  }

  if (!display.begin(SSD1306_SWITCHCAPVCC, SCREEN_ADDRESS))
  {
    Serial.println(F("SSD1306 allocation failed"));
    for (;;)
      ; // Don't proceed, loop forever
  }
  Serial.println("MPU6050 Found!");

  // setupt motion detection
  mpu.setHighPassFilter(MPU6050_HIGHPASS_0_63_HZ);
  mpu.setMotionDetectionThreshold(1);
  mpu.setMotionDetectionDuration(20);
  mpu.setInterruptPinLatch(true); // Keep it latched.  Will turn off when reinitialized.
  mpu.setInterruptPinPolarity(true);
  mpu.setMotionInterrupt(true);

  Serial.println("");
  delay(100);

  display.display();
  delay(2000); // Pause for 2 seconds

  // Clear the buffer
  display.clearDisplay();

  wifi_connect();
}

void loop()
{
  float resolution = 5.0 / 4095.0;
  int reading = analogRead(lm35dh);

  float voltage = reading * resolution; // getting the actual voltage corresponding temp

  temperature = (voltage * 100) - 50; // actual temperature

  if (mpu.getMotionInterruptStatus())
  {

    /* Get new sensor events with the readings */
    sensors_event_t a, g, temp;
    mpu.getEvent(&a, &g, &temp);

    xValue = a.acceleration.x;
    yValue = a.acceleration.y;
    zValue = a.acceleration.z;

    linearMag = sqrt(a.acceleration.x * a.acceleration.x + a.acceleration.y * a.acceleration.y + a.acceleration.z * a.acceleration.z);

    angularMag = sqrt(g.gyro.x * g.gyro.x + g.gyro.y * g.gyro.y + g.gyro.z * g.gyro.z);

    display.clearDisplay();

    // Draw border margin
    display.drawRect(0, 0, SCREEN_WIDTH - 1, SCREEN_HEIGHT - 1, SSD1306_WHITE);

    while (angularMag >= 4.5 && temperature >= 39)
    { // continuously alert the users when epilepsy seizures starts
      digitalWrite(buzzer, HIGH);
      display.clearDisplay();
      display.setTextSize(1);
      display.drawRect(0, 0, SCREEN_WIDTH - 1, SCREEN_HEIGHT - 1, SSD1306_WHITE);
      display.setTextColor(SSD1306_WHITE);
      display.setCursor(12, 10);
      display.println("Seizure detected!");
      display.display();

      if (digitalRead(btn) == LOW)
      { // break operation if the button has been pressed
        break;
      }
    }

    digitalWrite(buzzer, LOW);
    display.setTextColor(SSD1306_WHITE);
    display.setCursor(26, 10);
    display.drawRect(0, 0, SCREEN_WIDTH - 1, SCREEN_HEIGHT - 1, SSD1306_WHITE);

    display.setTextSize(1);
    display.setCursor(26, 5);
    display.print("Temp: ");
    display.print(temperature);
    display.print(" C");

    display.setTextSize(1);
    display.setCursor(22, 15);
    display.print("Normal State");

    /* Print out the values */
    Serial.print("AccelX:");
    Serial.print(a.acceleration.x);
    Serial.print(" ");
    Serial.print("AccelY:");
    Serial.print(a.acceleration.y);
    Serial.print(" ");
    Serial.print("AccelZ:");
    Serial.print(a.acceleration.z);
    Serial.print(" ");
    Serial.print("GyroX:");
    Serial.print(g.gyro.x);
    Serial.print(" ");
    Serial.print("GyroY:");
    Serial.print(g.gyro.y);
    Serial.print(" ");

    Serial.print("GyroZ:");
    Serial.print(g.gyro.z);
    Serial.print(" Linear:");
    Serial.print(linearMag);
    Serial.print(" Angular:");
    Serial.print(angularMag);
    Serial.print(" Button:");
    Serial.print(digitalRead(btn));
    Serial.print(" Temp: ");
    Serial.print(temperature);
    Serial.println("");

    display.display();
  }
  client_connect();
}

void wifi_connect()
{
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.print(ssid);
  WiFi.mode(WIFI_STA);
  status = WiFi.begin(ssid, pass);

  while (WiFi.status() != WL_CONNECTED)
  {
    Serial.print(".");
    delay(1000);

    display.setTextColor(SSD1306_WHITE);
    display.setCursor(26, 10);
    display.drawRect(0, 0, SCREEN_WIDTH - 1, SCREEN_HEIGHT - 1, SSD1306_WHITE);

    display.println("Connecting...");
    display.display();
  }

  display.setTextColor(SSD1306_WHITE);
  display.setCursor(26, 10);
  display.drawRect(0, 0, SCREEN_WIDTH - 1, SCREEN_HEIGHT - 1, SSD1306_WHITE);
  display.setTextColor(SSD1306_WHITE);

  Serial.println();
  Serial.print(ssid);
  Serial.println(" is connected!");
  Serial.println(WiFi.localIP());

  display.clearDisplay();
  display.setCursor(26, 10);
  display.println("Connected!");
  display.display();

  for (int i = 0; i <= 6; i++)
  {
    digitalWrite(yellowLed, LOW);
    delay(100);
    digitalWrite(yellowLed, HIGH);
    delay(100);
  }
}

void client_connect()
{
  WiFiClient client;
  const int httpPort = 80;

  if (!client.connect(server, httpPort))
  {
    Serial.println("Connection failed");
    digitalWrite(whiteLed, LOW);
    return;
  }

  digitalWrite(whiteLed, HIGH);

  String url = "/php/get.php?x=" + String(xValue) + "&y=" + String(yValue) + "&z=" + String(zValue) + "&temperature=" + String(temperature) + "&angular=" + String(angularMag);
  Serial.print("Requesting Url: ");
  Serial.println(url);

  client.print(String("GET ") + url + " HTTP/1.1\r\n" + "Host: " + server + "\r\n" + "Connection: close\r\n\r\n");
  delay(1000);

  while (client.available())
  {
    String line = client.readStringUntil('\r');
    Serial.print(line);
  }

  Serial.println();
  Serial.println("Closing connection");
}