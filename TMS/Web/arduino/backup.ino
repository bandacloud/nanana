void client_connect()
{
  
  String humidity = String(hum, 2);
  String temperature = String(temp, 2);
  String height=String(distanceCM, 2);
  //--------------------------------------------------------------------------------
  //HTTP POST request data
  String dht_data;
  dht_data = "api_key="+PROJECT_API_KEY;
  dht_data += "&temperature="+temperature;
  dht_data += "&humidity="+humidity;
  dht_data += "&height="+height;

  Serial.print("web_data: ");
  Serial.println(dht_data);
  //--------------------------------------------------------------------------------
  
  WiFiClient client;
  HTTPClient http;

  http.begin(client, server);
  // Specify content-type header
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  // Send HTTP POST request
  int httpResponseCode = http.POST(dht_data);
  //--------------------------------------------------------------------------------
  // If you need an HTTP request with a content type: 
  //application/json, use the following:
  //http.addHeader("Content-Type", "application/json");
  //temperature_data = "{\"api_key\":\""+PROJECT_API_KEY+"\",";
  //temperature_data += "\"temperature\":\""+temperature+"\",";
  //temperature_data += "\"humidity\":\""+humidity+"\"";
  //temperature_data += "}";
  //int httpResponseCode = http.POST(temperature_data);
  //--------------------------------------------------------------------------------
  // If you need an HTTP request with a content type: text/plain
  //http.addHeader("Content-Type", "text/plain");
  //int httpResponseCode = http.POST("Hello, World!");
  //--------------------------------------------------------------------------------
  Serial.print("HTTP Response code: ");
  Serial.println(httpResponseCode);
    
  // Free resources
  http.end();
}
