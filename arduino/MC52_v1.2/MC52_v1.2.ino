/* Author: Hoai Bac */
#include "DHT.h"            
#include "MQ135.h"//Air sensor library

const int DHTPIN = 2;       //Read data DHT from PIN 2
const int DHTTYPE = DHT11;  //Chose DHTTYPE
const int MC52PIN = 3;       //Read data DHT from PIN 2
DHT dht(DHTPIN, DHTTYPE);
MQ135 mqSensor(A0);//mqsensor

const String DVID = "DV2";
const String DVTYPE = "MC52";

int ACK_FLG = 0;
int sec = 30000; //Default sec value 
String hostnm;

void setup() {
  //Start Serial at baudrate 9600
  Serial.begin(9600);
  
  //Start the sensor
  dht.begin();
  pinMode(MC52PIN,INPUT_PULLUP);         
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
      if(dvid.equals(DVID)){
        ACK_FLG = 1;
        int indexSec = inString.indexOf("SEC");
        sec = (inString.substring((indexSec+4)).toInt())*1000;
        hostnm = inString.substring(inString.indexOf("HOST")+5);
      }
    }

    if(inString.indexOf("ACKNO") != -1){
      //Get the index of str 'ACK' from incoming str
      int indexAck = inString.indexOf("ACK");
      //Data receive will be like DV1 ACK SEC 30
      //From indexSec we extract the device ID 
      String dvid = inString.substring(0,(indexAck -1));
      if(dvid.equals(DVID)){
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
        if(dvid.equals(DVID)){
          //Change sec variable's value with the new value just receive
          sec = (inString.substring((indexSec+4)).toInt())*1000;
     }
    }
  }
  if(ACK_FLG == 1){
      float h = dht.readHumidity();    //Read Humidity
      float t = dht.readTemperature(); //Read Temperature
      Serial.print("ACKYES");
      Serial.print(" HOST ");
      Serial.print(hostnm);
      Serial.print(" DEVICE ");
      Serial.print(DVID);
      Serial.print(" TYPE ");
      Serial.print(DVTYPE);
      if(!isnan(h) && !isnan(t) && analogRead(A0) == 0){
        Serial.print(" TEMP ");
        Serial.print(t);              //Sent the Temparature via UART
        Serial.print(" HUMI ");
        Serial.print(h);               //Sent the Humidity via UART  
        Serial.println();
        delay(sec);                    //Wait for sec variable's value second            
      }
      if(!isnan(h) && !isnan(t) && analogRead(A0) != 0){
        Serial.print(" CO2 ");
        Serial.print(mqSensor.getCalibratedCO2(t,h));
        Serial.print(" CO0 ");
        Serial.print(mqSensor.getCalibratedCO(t,h));
        Serial.print(" ETHANOL ");
        Serial.print(mqSensor.getCalibratedEthanol(t,h));
        Serial.print(" TOLUENE ");
        Serial.print(mqSensor.getCalibratedToluene(t,h));
        Serial.print(" ACETONE ");
        Serial.print(mqSensor.getCalibratedAcetone(t,h)); 
        Serial.print(" ANALOG ");
        Serial.print(analogRead(A0));
        Serial.println();
        delay(sec);                    //Wait for sec variable's value second         
      }
      if(isnan(h) && isnan(t)){
        Serial.print(" OPEN ");
        Serial.print(digitalRead(MC52PIN));
        Serial.println();
        delay(1000);                    //Wait for sec variable's value second 
      }
 
  }else{
     Serial.print("ACKNO");
     Serial.print(" DEVICE ");
     Serial.print(DVID);
     Serial.print(" TYPE ");
     Serial.print(DVTYPE);
     Serial.println();     
     delay(10000);
  }
  
}


