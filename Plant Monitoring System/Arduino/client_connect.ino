void client_connect()
{
  WiFiClient client;
  const int httpPort = 80;
  if(!client.connect(server,httpPort)){
    Serial.println("Connection failed");
    // digitalWrite(led2,LOW);
    return;
  }

  // digitalWrite(led2,HIGH);

  String url = "/plant-monitoring/php/get.php?moisture=" + String(moisture) + "&n=" + String(val1) + "&p=" + String(val2) + "&k=" + String(val3)+ "&temp=" + String(temperature) + "&hum=" + String(humidity);
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

