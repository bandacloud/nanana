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