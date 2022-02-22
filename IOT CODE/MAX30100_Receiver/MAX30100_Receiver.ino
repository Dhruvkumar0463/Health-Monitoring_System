#include <ESP8266WiFi.h>
#include <espnow.h>
#include <Wire.h>
// Structure example to receive data
// Must match the sender structure
typedef struct struct_message {
    int id;
    float x;
    float y;
} struct_message;

float spo2,hrate;
// Create a struct_message called myData
struct_message myData;
WiFiClient client;
// Create a structure to hold the readings from each board
struct_message board1;
//struct_message board2;

const int httpPort = 80; 
const char* ssid     = "warrior1232";
const char* password = "123456789@";
const char* host = "healthmonitoring.tech";


// Create an array with all the structures
struct_message boardsStruct[1] = {board1};

// Callback function that will be executed when data is received
void OnDataRecv(uint8_t * mac_addr, uint8_t *incomingData, uint8_t len) {
  char macStr[18];
  Serial.print("Packet received from: ");
  snprintf(macStr, sizeof(macStr), "%02x:%02x:%02x:%02x:%02x:%02x",
           mac_addr[0], mac_addr[1], mac_addr[2], mac_addr[3], mac_addr[4], mac_addr[5]);
  Serial.println(macStr);
  memcpy(&myData, incomingData, sizeof(myData));
  Serial.printf("Board ID %u: %u bytes\n", myData.id, len);
  // Update the structures with the new incoming data
  boardsStruct[myData.id-1].x = myData.x;
  boardsStruct[myData.id-1].y = myData.y;
  //Serial.printf("x value: %d \n", boardsStruct[myData.id-1].x);
  //Serial.printf("y value: %d \n", boardsStruct[myData.id-1].y);
  Serial.println();
}
 void cwifi(){
    // Set device as a Wi-Fi Station
  WiFi.mode(WIFI_STA);
  WiFi.disconnect();

  // Init ESP-NOW
  if (esp_now_init() != 0) {
    Serial.println("Error initializing ESP-NOW");
    return;
  }
  
  // Once ESPNow is successfully Init, we will register for recv CB to
  // get recv packer info
  esp_now_set_self_role(ESP_NOW_ROLE_SLAVE);
  esp_now_register_recv_cb(OnDataRecv);
  }

  void wifi(){
      WiFi.begin(ssid, password);

    while (WiFi.status() != WL_CONNECTED) {
      delay(500);
      Serial.print(".");
    }
   
    Serial.println("");
    Serial.println("WiFi connected");  
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());
    Serial.print("Netmask: ");
    Serial.println(WiFi.subnetMask());
    Serial.print("Gateway: ");
    Serial.println(WiFi.gatewayIP());

    if (!client.connect(host, httpPort)) {
      Serial.println("connection failed");
      return;
    }
    String url_oxygen = "/authentication/oxygen.php?oxygen="+String(spo2);
    
    Serial.print("Requesting URL: ");
    Serial.println(url_oxygen);
   
    client.print(String("GET ") + url_oxygen + " HTTP/1.1\r\n" +
                 "Host: " + host + "\r\n" +
                 "Connection: close\r\n\r\n");

    while(client.available()){
      String line = client.readStringUntil('\r');
      Serial.print(line);
    }

     if (!client.connect(host, httpPort)) {
      Serial.println("connection failed");
      return;
    }
    
    String url_pulse = "/authentication/pulse.php?pulse="+String(hrate);
    
    Serial.print("Requesting URL: ");
    Serial.println(url_pulse);
   
    client.print(String("GET ") + url_pulse + " HTTP/1.1\r\n" +
                 "Host: " + host + "\r\n" +
                 "Connection: close\r\n\r\n");

    while(client.available()){
      String line = client.readStringUntil('\r');
      Serial.print(line);
    }
   
    Serial.println();
    Serial.println("closing connection");
  
    }
void setup() {
  // Initialize Serial Monitor
  Serial.begin(115200);
  
 cwifi();

}

void loop(){
  
  // Access the variables for each board
  float board1X = boardsStruct[0].x;
  float board1Y = boardsStruct[0].y;
  Serial.print("spo2:");
  spo2 = board1X;
  Serial.println(spo2);
  Serial.print("hrate:");
  hrate = board1Y;
  Serial.println(hrate);
  wifi();
  delay(1000);
  cwifi();
  delay(1000);
  
}
