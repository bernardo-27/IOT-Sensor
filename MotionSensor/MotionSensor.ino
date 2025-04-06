#include <WiFi.h>
#include <HTTPClient.h> 

const char* ssid = "SmartBro_8150";
const char* password = "Smartbro*2022";
const char* serverUrl = "http://127.0.0.1:8000/api/sensor";


const int Pin = 14;

void setup() {
  Serial.begin(115200);
  pinMode(Pin, INPUT);

  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("\nConnected to WiFi");
}

void loop() {
  int motionDetected = digitalRead(Pin);

  if (motionDetected == HIGH) {
    Serial.println("Motion detected!");

    if (WiFi.status() == WL_CONNECTED) {
      HTTPClient http;

      http.begin(serverUrl);
      http.addHeader("Content-Type", "application/json");

      String payload = "{\"motion\": true}";
      int httpResponseCode = http.POST(payload);

      Serial.print("Response code: ");
      Serial.println(httpResponseCode);
      http.end();
    }

    delay(5000);
  } else {
    Serial.println("No motion");
  }

  delay(1000);
}
