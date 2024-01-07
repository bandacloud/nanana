
void httpPost() {
  Serial3.println("AT+CIPSTART=\"TCP\",\"" + server + "\",80");  //start a TCP connection.
  if (Serial3.find("OK")) {
    Serial.println("TCP connection ready");
    digitalWrite(yellowLed, HIGH);
  } else {
    digitalWrite(yellowLed, LOW);
  }
  delay(30);
  String postRequest =

    "POST " + url + " HTTP/1.0\r\n" +

    "Host: " + server + "\r\n" +

    "Accept: *" + "/" + "*\r\n" +

    "Content-Length: " + postData.length() + "\r\n" +

    "Content-Type: application/x-www-form-urlencoded\r\n" +

    "\r\n" + postData;

  String sendCmd = "AT+CIPSEND=";  //determine the number of caracters to be sent.

  Serial3.print(sendCmd);

  Serial3.println(postRequest.length());

  delay(30);

  if (Serial3.find(">")) {
    Serial.println("Sending..");
    Serial3.print(postRequest);
    if (Serial3.find("SEND OK")) {
      Serial.println("Packet sent");
      while (Serial3.available()) {
        String tmpResp = Serial3.readString();
        Serial.println(tmpResp);
      }
      // close the connection
      Serial3.println("AT+CIPCLOSE");
    }
  }
}