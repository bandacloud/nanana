//connect to your wifi network
void connectWifi() {
  String cmd = "AT+CWJAP=\"" + ssid + "\",\"" + password + "\"";
  Serial3.println(cmd);
  // delay(2000);

  long waiting;

  while (!Serial3.find("OK")) {
    waiting = millis();
    if (waiting > 20000) {
      lcd.setCursor(4, 1);
      lcd.print("Conn Time Out");
      delay(500);
      break;
    } else {
      lcd.clear();
      lcd.setCursor(4, 1);
      lcd.print("Connecting to");
      lcd.setCursor(7, 2);
      lcd.print(ssid);
    }
  }

  if (!(waiting > 20000)) {
    Serial.print(ssid);
    Serial.println(" is Connected!");

  for(int i=0; i<5; i++){
    digitalWrite(redLed, LOW);
    delay(50);
    digitalWrite(redLed, HIGH);
    delay(50);
  }

    lcd.clear();
    lcd.setCursor(7, 1);
    lcd.print(ssid);
    lcd.setCursor(4, 2);
    lcd.print("is connected");
    delay(500);
  }
}

//reset the Serial38266 module
void resetConn() {
  Serial3.println("AT+RST");
  delay(500);
  if (Serial3.find("OK")) Serial.println("Module Reset");
}