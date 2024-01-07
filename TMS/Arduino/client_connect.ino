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

