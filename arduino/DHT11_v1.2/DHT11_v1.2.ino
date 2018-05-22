/* Author: Hoai Bac */
#include "DHT.h"            

const int DHTPIN = 2;       //Read data DHT from PIN 2
const int DHTTYPE = DHT11;  //Chose DHTTYPE
int ACK_FLG = 0;
 
DHT dht(DHTPIN, DHTTYPE);

int sec = 30000; //Default sec value
 
void setup() {
  //Start Serial at baudrate 9600
  Serial.begin(9600);
  
  //Start the sensor
  dht.begin();         
}
 
void loop() {
  if(Serial.available() > 0){
    String inString = Serial.readString();
    
    if(inString.indexOf("ACK") != -1){
      //Get the index of str 'ACK' from incoming str
      int indexAck = inString.indexOf("ACK");
      //Data receive will be like DV1 ACK SEC 30
      //From indexSec we extract the device ID 
      String dvid = inString.substring(0,(indexAck -1));
      //If it was this device
      if(dvid.equals("DV1")){
        ACK_FLG = 1;
        int indexSec = inString.indexOf("SEC");
        sec = (inString.substring((indexSec+4)).toInt())*1000;
      }
    }
    
     //If it contain 'SEC' inside
     if(inString.indexOf("SEC") != -1){
        //Get the index of str 'SEC' from incoming str
        int indexSec = inString.indexOf("SEC");
        //Data receive will be like DV1 SEC 30
        //From indexSec we extract the device ID 
        String dvid = inString.substring(0,(indexSec -1));
        //If it was this device
        if(dvid.equals("DV1")){
          //Change sec variable's value with the new value just receive
          sec = (inString.substring((indexSec+4)).toInt())*1000;
     }
    }
    
  }
  if(ACK_FLG == 1){
      float h = dht.readHumidity();    //Read Humidity
      float t = dht.readTemperature(); //Read Temperature
      Serial.println("ACK YES");
      Serial.println("DEVICE DV1");
      Serial.println("TYPE DHT11");
      Serial.print("TEMP ");
      Serial.println(t);               //Sent the Temparature via UART
      Serial.print("HUMI ");
      Serial.println(h);               //Sent the Humidity via UART
      Serial.print("SEC ");
      Serial.println(sec/1000);             //Sent the current variable's value via UART
      Serial.println();                //New line
      delay(sec);                      //Wait for sec variable's value second  
  }else{
     Serial.println("ACK NO");
     Serial.println("DEVICE DV1");
     Serial.println("TYPE DHT11");
     delay(5000);
  }
  
}


