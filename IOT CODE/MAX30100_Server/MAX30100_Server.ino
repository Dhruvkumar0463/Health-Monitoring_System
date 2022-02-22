#include <ESP8266WiFi.h>
#include <espnow.h>
#include <Wire.h>
#include <MAX30100_PulseOximeter.h>
 
#define REPORTING_PERIOD_MS     3000


// REPLACE WITH RECEIVER MAC Address
uint8_t broadcastAddress[] = {0xEC, 0xFA, 0xBC, 0xBC, 0x3C, 0xF6};

// Set your Board ID (ESP32 Sender #1 = BOARD_ID 1, ESP32 Sender #2 = BOARD_ID 2, etc)
#define BOARD_ID 1

// Structure example to send data
// Must match the receiver structure
typedef struct struct_message {
    int id;
    float x;
    float y;
} struct_message;

 PulseOximeter pox;
uint32_t tsLastReport = 0;
float hrate,spo2;
void onBeatDetected()
{
    Serial.print("Beat...!");
}

// Create a struct_message called test to store variables to be sent
struct_message myData;

unsigned long lastTime = 0;
unsigned long timerDelay = 1000;

// Callback when data is sent
void OnDataSent(uint8_t *mac_addr, uint8_t sendStatus) {
  Serial.print("\r\nLast Packet Send Status: ");
  if (sendStatus == 0){
    Serial.println("Delivery success");
  }
  else{
    Serial.println("Delivery fail");
  }
}
 
void setup() {
  // Init Serial Monitor
  Serial.begin(115200);
 
  // Set device as a Wi-Fi Station
  WiFi.mode(WIFI_STA);
  WiFi.disconnect();

  // Init ESP-NOW
  if (esp_now_init() != 0) {
    Serial.println("Error initializing ESP-NOW");
    return;
  } 
  // Set ESP-NOW role
  esp_now_set_self_role(ESP_NOW_ROLE_CONTROLLER);

  // Once ESPNow is successfully init, we will register for Send CB to
  // get the status of Trasnmitted packet
  esp_now_register_send_cb(OnDataSent);
  
  // Register peer
  esp_now_add_peer(broadcastAddress, ESP_NOW_ROLE_SLAVE, 1, NULL, 0);

   // Initialize the PulseOximeter instance
    // Failures are generally due to an improper I2C wiring, missing power supply
    // or wrong target chip
    if (!pox.begin()) {
        Serial.println("FAILED");
        for(;;);
    } else {
        Serial.println("SUCCESS");
        digitalWrite(1,HIGH);
    }
     pox.setIRLedCurrent(MAX30100_LED_CURR_24MA);
 
    // Register a callback for the beat detection
    pox.setOnBeatDetectedCallback(onBeatDetected);

}
 
void loop() {

  pox.update();
    if (millis() - tsLastReport > REPORTING_PERIOD_MS) {
 
  // to computer Serial Monitor
        Serial.print("BPM: ");
        hrate = pox.getHeartRate();
        Serial.print(hrate);
        Serial.println("\n");
        
        Serial.print("    SpO2: ");
        spo2 = pox.getSpO2();
        Serial.print(spo2);
        Serial.print("%");
        Serial.println("\n");

        // Set values to send
    myData.id = BOARD_ID;
    myData.x = spo2;
    myData.y = hrate;

        // Send message via ESP-NOW
    esp_now_send(0, (uint8_t *) &myData, sizeof(myData));
 
        tsLastReport = millis();
        
    }

}
