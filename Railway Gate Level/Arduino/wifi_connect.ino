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
  }

  for (int i = 0; i <= 6; i++) {
    digitalWrite(whiteLed, LOW);
    delay(100);
    digitalWrite(whiteLed, HIGH);
    delay(100);
  }
  Serial.println();
  Serial.print(ssid);
  Serial.println(" is connected!");
  Serial.println(WiFi.localIP());

  // digitalWrite(led1,HIGH);
}