void client_connect() {
  WiFiClient client;
  const int httpPort = 80;
  if (!client.connect(server, httpPort)) {
    Serial.println("Connection failed");
    digitalWrite(blueLed, LOW);
    return;
  }

  digitalWrite(blueLed, HIGH);


  String url = "/php/get.php?gateStatus=" + String(gateStatus);
  Serial.print("Requesting Url: ");
  Serial.println(url);

  client.print(String("GET ") + url + " HTTP/1.1\r\n" + "Host: " + server + "\r\n" + "Connection: close\r\n\r\n");
  delay(500);

  while (client.available()) {
    String line = client.readStringUntil('\r');
    Serial.print(line);
  }

  Serial.println();
  Serial.println("Closing connection");
  delay(500);
}