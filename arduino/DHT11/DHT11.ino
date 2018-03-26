/* Author: Hoai Bac */
#include "DHT.h"            

const int DHTPIN = 2;       //Read data DHT from PIN 2
const int DHTTYPE = DHT11;  //Chose DHTTYPE
 
DHT dht(DHTPIN, DHTTYPE);

int sec = 30000; //Default sec value
 
void setup() {
  //Start Serial at baudrate 9600
  Serial.begin(9600);
  //Start the sensor
  dht.begin();         
}
 
void loop() {
  float h = dht.readHumidity();    //Read Humidity
  float t = dht.readTemperature(); //Read Temperature
  //If there is data come
  if (Serial.available() > 0) {
    //Read the data got
    String incomingByte = Serial.readString();
    //If it contain 'SEC' inside
    if(incomingByte.indexOf("SEC") != -1){
      //Get the index of str 'SEC' from incoming str
      int indexSec = incomingByte.indexOf("SEC");
      //Data receive will be like DV1 SEC 30
      //From indexSec we extract the device ID 
      String dvid = incomingByte.substring(0,(indexSec -1));
      //If it was this device
      if(dvid.equals("DV1")){
        //Change sec variable's value with the new value just receive
        sec = (incomingByte.substring((indexSec+4)).toInt())*1000;
      }
    }
  }
  Serial.println("DEVICE DV1");
  Serial.println("TYPE DHT11");
  Serial.print("TEMP ");
  Serial.println(t);               //Sent the Temparature via UART
  Serial.print("HUMI ");
  Serial.println(h);               //Sent the Humidity via UART
  Serial.print("SEC ");
  Serial.println(sec);             //Sent the current variable's value via UART
  Serial.println();                //New line
  delay(sec);                      //Wait for sec variable's value second
}


