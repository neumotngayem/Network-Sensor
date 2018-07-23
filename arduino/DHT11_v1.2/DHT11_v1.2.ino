/* Author: Hoai Bac */
#include "DHT.h"            

const int DHTPIN = 2;       //Read data DHT from PIN 2
const int DHTTYPE = DHT11;  //Chose DHTTYPE
int ACK_FLG = 0;
 
DHT dht(DHTPIN, DHTTYPE);

int sec = 30000; //Default sec value
String hostnm;
void setup() {
  //Start Serial at baudrate 9600
  Serial.begin(9600);
  
  //Start the sensor
  dht.begin();         
}
 
void loop() {
  if(Serial.available() > 0){
    String inString = Serial.readString();
    
    if(inString.indexOf("ACKYES") != -1){
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
        hostnm = inString.substring(inString.indexOf("HOST")+5);
      }
    }

    if(inString.indexOf("ACKNO") != -1){
      //Get the index of str 'ACK' from incoming str
      int indexAck = inString.indexOf("ACKYES");
      //Data receive will be like DV1 ACK SEC 30
      //From indexSec we extract the device ID 
      String dvid = inString.substring(0,(indexAck -1));
      if(dvid.equals("DV1")){
        ACK_FLG = 0;
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
      Serial.print("ACK YES");
      Serial.print(" HOST ");
      Serial.print(hostnm);
      Serial.print(" DEVICE DV1");
      Serial.print(" TYPE DHT11");
      Serial.print(" TEMP ");
      Serial.print(t);              //Sent the Temparature via UART
      Serial.print(" HUMI ");
      Serial.print(h);               //Sent the Humidity via UART
      Serial.print(" SEC ");
      Serial.print(sec/1000);       //Sent the current variable's value via UART
      delay(sec);                    //Wait for sec variable's value second  
  }else{
     Serial.print("ACK NO");
     Serial.print(" DEVICE DV1");
     Serial.print(" TYPE DHT11");
     delay(5000);
  }
  
}


