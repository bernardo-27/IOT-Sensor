#include <WiFi.h>
#include <HTTPClient.h>

// WiFi credentials
const char* ssid = "SmartBro_8150";
const char* password = "Smartbro*2022";

// Laravel API endpoint (replace IP if needed)
const char* serverName = "http://192.168.1.142:8000/api/sensor";

// PIR sensor pin
const int pirPin = 14;
int motionDetected = LOW;

void setup() {
  Serial.begin(115200);
  pinMode(pirPin, INPUT);

  // Connect to WiFi
  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(300);
    Serial.print(".");
  }
  Serial.println("\nConnected to WiFi");
}

void loop() {
  int sensorValue = digitalRead(pirPin);

  // If motion just started
  if (sensorValue == HIGH && motionDetected == LOW) {
    Serial.println("🚨 Motion Detected!");

    // Send to API
    if (WiFi.status() == WL_CONNECTED) {
      HTTPClient http;
      http.begin(serverName);
      http.addHeader("Content-Type", "application/json");

      String jsonData = "{\"motion\":1}";
      int response = http.POST(jsonData);

      Serial.print("Server Response Code: ");
      Serial.println(response);
      Serial.println(http.getString());

      http.end();
    }

    motionDetected = HIGH;
  }

  // If motion stopped
  else if (sensorValue == LOW && motionDetected == HIGH) {
    Serial.println("🛑 Motion Stopped.");
    motionDetected = LOW;
  }

  delay(1000);  // Wait a bit before checking again
}
