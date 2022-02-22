// include the library code:
#include "LiquidCrystal.h"
#include <Wire.h>
#include <SparkFunMLX90614.h>
#include <ESP8266WiFi.h>
#include <PubSubClient.h>

#define VARIABLE_LABEL "myecg" // Assing the variable label
#define DEVICE_LABEL "esp8266" // Assig the device label

#define SENSOR A0 // Set the A0 as SENSOR


String tempp;
float myecg ;
const char* ssid     = "warrior1232";
const char* password = "123456789@";
const char* host = "healthmonitoring.tech";

IRTherm therm;

// initialize the library by associating any needed LCD interface pin
// with the arduino pin number it is connected to
const int RS = D0, EN = D3, d4 = D5, d5 = D6, d6 = D7, d7 = D8;

// if you use the NodeMCU 12E the suggested pins are
// const int RS = 4, EN = 0, d4 = 12 , d5 = 13, d6 = 15, d7 = 3;

LiquidCrystal lcd(RS, EN, d4, d5, d6, d7);
char mqttBroker[]  = "industrial.api.ubidots.com";
char payload[100];
char topic[150];
// Space to store values to send
char str_sensor[10];
 
/****************************************
 * Auxiliar Functions
 ****************************************/

 
void callback(char* topic, byte* payload, unsigned int length) {
  char p[length + 1];
  memcpy(p, payload, length);
  p[length] = NULL;
  Serial.write(payload, length);
  Serial.println(topic);
}



void setup() {

  // set up the LCD's number of columns and rows:
lcd.begin(16, 2);

Serial.begin(115200);
  Wire.begin();

   Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
 
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

   // Assign the pin as INPUT 
  pinMode(SENSOR, INPUT);
 
 
  if (therm.begin() == false){
    Serial.println("IR thermometer did not acknowledge! Freezing!");
    //while(1);
  }
  Serial.println("IR Thermometer did acknowledge.");
 
  therm.setUnit(TEMP_F);

 
  pinMode(LED_BUILTIN, OUTPUT); // LED pin as output

}

void loop() {

  temp123();
  //delay(1000);
  getecg();
  
  temp_api();
  ecg_api();

}

void getecg(){

    sprintf(topic, "%s%s", "/v1.6/devices/", DEVICE_LABEL);
  sprintf(payload, "%s", ""); // Cleans the payload
  sprintf(payload, "{\"%s\":", VARIABLE_LABEL); // Adds the variable label
  
  myecg = analogRead(SENSOR); 
  
  /* 4 is mininum width, 2 is precision; float value is copied onto str_sensor*/
  dtostrf(myecg, 4, 2, str_sensor);
  
  sprintf(payload, "%s {\"value\": %s}}", payload, str_sensor); // Adds the value
  Serial.println(myecg);

}
void ecg_api( ){
  Serial.print("connecting to ");
  Serial.println(host);

  WiFiClient client;
  const int httpPort = 80;
  if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }
  
  String url_ecg = "/authentication/ecgapi.php?ecg=" + String(myecg) ;
  Serial.print("Requesting URL: ");
  Serial.println(url_ecg);
 
  client.print(String("GET ") + url_ecg + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" +
               "Connection: close\r\n\r\n");
  
 
  while(client.available()){
    String line = client.readStringUntil('\r');
    Serial.print(line);
  }
 
  Serial.println();
  Serial.println("closing connection");
  delay(2000);

}

void temp_api(){
  Serial.print("connecting to ");
  Serial.println(host);

  WiFiClient client;
  const int httpPort = 80;
  if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }
  
  String url_temp = "/authentication/tempapi.php?temp=" + String(tempp) ;
  Serial.print("Requesting URL: ");
  Serial.println(url_temp);
 
  client.print(String("GET ") + url_temp + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" +
               "Connection: close\r\n\r\n");
  
 
  while(client.available()){
    String line = client.readStringUntil('\r');
    Serial.print(line);
  }
 
  Serial.println();
  Serial.println("closing connection");
  delay(2000);

}

void temp123(){
  
  digitalWrite(LED_BUILTIN, HIGH);
   
 
  if (therm.read()) // On success, read() will return 1, on fail 0.
  {

    tempp = String(therm.object(),2);
    Serial.print("Object: " + String(therm.object(), 2));
    Serial.println("F");
    Serial.print("Ambient: " + String(therm.ambient(), 2));
    Serial.println("F");
    Serial.println();

   
    lcd.setCursor(0, 1);
    // print the number of seconds since reset:
    lcd.print(String(therm.object(),2));
  }
  else
  {
     Serial.print("not able to read data");
  }
  digitalWrite(LED_BUILTIN, LOW);  
}
