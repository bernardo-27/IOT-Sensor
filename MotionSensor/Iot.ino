#include <DHT.h>
#include <Wire.h>
#include <BH1750.h>
#include <WiFi.h>
#include <HTTPClient.h>

// WiFi credentials
const char* ssid = "SmartBro_8150";
const char* password = "Smartbro*2022";

// Laravel API endpoint (replace IP if needed)
const char* serverName = "https://iot-sensor-main-rx3s1n.laravel.cloud/api/sensor";

// Pin Definitions
#define DHTPIN 27
#define DHTTYPE DHT22
#define MQPIN 34
#define SOUND_PIN 35 // Sound sensor AO pin
#define BUZZER_PIN 26
#define BUTTON_PIN 25
#define LED_PIN 33

// Sensor Objects
DHT dht(DHTPIN, DHTTYPE);
BH1750 lightMeter;

bool systemOn = true;
bool light_ok = false;

// Variables to track previous sensor values
float prev_temp = 0;
int prev_mq_value = 0;
float prev_lux = 0;
int prev_sound_value = 0;
bool prev_fault = false;

// Timer for API reporting
unsigned long lastReportTime = 0;
const unsigned long reportInterval = 3000; // Report every 3 seconds

void setup() {
  Serial.begin(115200);

  // Initialize Sensors
  dht.begin();
  Wire.begin();

  if (lightMeter.begin(BH1750::CONTINUOUS_HIGH_RES_MODE)) {
    light_ok = true;
    Serial.println("Light sensor initialized.");
  } else {
    Serial.println("Light sensor NOT detected!");
  }

  // Pin Modes
  pinMode(BUZZER_PIN, OUTPUT);
  pinMode(BUTTON_PIN, INPUT_PULLUP);
  pinMode(LED_PIN, OUTPUT);

  digitalWrite(LED_PIN, HIGH);
  digitalWrite(BUZZER_PIN, LOW);
  
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
  // Button toggle
  if (digitalRead(BUTTON_PIN) == LOW) {
    delay(200);
    systemOn = !systemOn;
    Serial.println(systemOn ? "System ON" : "System OFF");
    digitalWrite(LED_PIN, systemOn ? HIGH : LOW);
    digitalWrite(BUZZER_PIN, LOW);
    delay(500);
    
    // Report status change to server
    if (WiFi.status() == WL_CONNECTED) {
      sendDataToServer(0, 0, 0, 0, !systemOn); // Send system status change
    }
  }

  if (systemOn) {
    bool fault = false;
    bool changed = false;

    // DHT Sensor
    float temp = dht.readTemperature();
    if (isnan(temp)) {
      Serial.println("Fault: DHT22 not responding!");
      fault = true;
    } else if (abs(temp - prev_temp) >= 0.5) { // Detect significant change
      changed = true;
    }

    // MQ135 Sensor
    int mq_value = analogRead(MQPIN);
    if (mq_value < 50) {
      Serial.println("Fault: MQ135 not detecting!");
      fault = true;
    } else if (abs(mq_value - prev_mq_value) >= 50) { // Detect significant change
      changed = true;
    }

    // Light Sensor
    float lux = 0;
    if (light_ok) {
      lux = lightMeter.readLightLevel();
      if (lux < 0) {
        Serial.println("Fault: Light sensor read failed!");
        fault = true;
      } else if (abs(lux - prev_lux) >= 50) { // Detect significant change
        changed = true;
      }
    } else {
      Serial.println("Fault: Light sensor not initialized!");
      fault = true;
    }

    // Sound Sensor
    int soundValue = analogRead(SOUND_PIN);
    if (soundValue < 1 || soundValue > 4095) {
      Serial.println("Fault: Sound sensor not responding or disconnected!");
      fault = true;
    } else if (abs(soundValue - prev_sound_value) >= 10) { // Detect significant change
      changed = true;
    }

    // Print Real-Time Data
    Serial.print("Temperature: ");
    Serial.print(isnan(temp) ? 0 : temp);
    Serial.println(" °C");

    Serial.print("MQ135 Value: ");
    Serial.println(mq_value);

    Serial.print("Light Intensity: ");
    Serial.print(lux);
    Serial.println(" lux");

    Serial.print("Sound Value: ");
    Serial.println(soundValue);
    Serial.println("=================================");

    // If sensor values changed or it's time to report
    unsigned long currentTime = millis();
    if ((changed || fault != prev_fault) || (currentTime - lastReportTime >= reportInterval)) {
      // Send data to server
      if (WiFi.status() == WL_CONNECTED) {
        sendDataToServer(temp, mq_value, lux, soundValue, fault);
        lastReportTime = currentTime;
      }
      
      // Update previous values
      prev_temp = temp;
      prev_mq_value = mq_value;
      prev_lux = lux;
      prev_sound_value = soundValue;
      prev_fault = fault;
    }

    // Buzzer on fault
    if (fault) {
      tone(BUZZER_PIN, 2000);
      delay(300);
      noTone(BUZZER_PIN);
      delay(300);
    } else {
      noTone(BUZZER_PIN);
    }

    delay(1000);
  } else {
    noTone(BUZZER_PIN);
    delay(100);
  }
}

void sendDataToServer(float temperature, int airQuality, float light, int sound, bool fault) {
  HTTPClient http;
  http.begin(serverName);
  http.addHeader("Content-Type", "application/json");
  
  // Create JSON data
  String jsonData = "{";
  jsonData += "\"temperature\":" + String(temperature) + ",";
  jsonData += "\"air_quality\":" + String(airQuality) + ",";
  jsonData += "\"light\":" + String(light) + ",";
  jsonData += "\"sound\":" + String(sound) + ",";
  jsonData += "\"system_on\":" + String(systemOn ? 1 : 0) + ",";
  jsonData += "\"fault\":" + String(fault ? 1 : 0);
  jsonData += "}";
  
  // Send POST request
  int response = http.POST(jsonData);
  
  // Display response
  Serial.print("Server Response Code: ");
  Serial.println(response);
  Serial.println(http.getString());
  
  http.end();
}