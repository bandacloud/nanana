void client_connect()
{
   if(client.connect(server, 80))
  {
    client.print("GET /smart-silos/php/get.php?temp="); //your url
    client.print(temp);
    client.print("&hum=");
    client.print(hum);
    client.println(" "); //space b4 HTTP/1.1
    client.print("HTTP/1.1");
    client.println();
    client.println("Host: 192.168.43.50");
    client.println("Content-Type: application/x-www-form-urlencoded");
    client.println();      
  }
  else
  {
    Serial.println("Failed To Connect To 192.168.43.50 (Contact +265885825008...)");
  }
  if(client.connected())
  {
    client.stop();
  }
}
