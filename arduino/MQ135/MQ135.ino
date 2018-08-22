#include "MQ135.h"//Air sensor library
#include "DHT.h"
MQ135 mqSensor(A0);//mqsensor
const int DHTPIN = 2;       //Read data DHT from PIN 2
const int DHTTYPE = DHT11;  //Chose DHTTYPE
int ACK_FLG = 1;
int sec = 30000; //Default sec value
String hostnm;

DHT dht(DHTPIN, DHTTYPE);
void setup() {
  // put your setup code here, to run once:
  Serial.begin(9600); // Initialize serial port to send and receive at 9600 baud
  dht.begin();   
}

void loop() {
    if(Serial.available() > 0){
    String inString = Serial.readString();
    
    if(inString.indexOf("ACKYES") != -1){
      //Get the index of str 'ACK' from incoming str
      int indexAck = inString.indexOf("ACKYES");
      //Data receive will be like DV1 ACK SEC 30
      //From indexSec we extract the device ID 
      String dvid = inString.substring(0,(indexAck -1));
      //If it was this device
      if(dvid.equals("DV3")){
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
      if(dvid.equals("DV3")){
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
        if(dvid.equals("DV3")){
          //Change sec variable's value with the new value just receive
          sec = (inString.substring((indexSec+4)).toInt())*1000;
     }
    }
  }
 
  if(ACK_FLG == 1){
      float t = dht.readTemperature(); //Read Temperature    
      float h = dht.readHumidity();    //Read Humidity
      Serial.print("ACK YES");
      Serial.print(" HOST ");
      Serial.print("RS1");
      Serial.print(" DEVICE DV3");
      Serial.print(" TYPE MQ135");
      Serial.print(" CO2 ");
      Serial.print(mqSensor.getCalibratedCO2(t,h));
      Serial.print(" COO ");
      Serial.print(mqSensor.getCalibratedCO(t,h));
      Serial.print(" ETHANOL ");
      Serial.print(mqSensor.getCalibratedEthanol(t,h));
      Serial.print(" TOLUENE ");
      Serial.print(mqSensor.getCalibratedToluene(t,h));
      Serial.print(" ACETONE ");
      Serial.print(mqSensor.getCalibratedAcetone(t,h)); 
      Serial.print(" ANALOG ");
      Serial.print(analogRead(A0));
      Serial.print(" SEC ");
      Serial.print(sec/1000);       //Sent the current variable's value via UART
      Serial.println();
      delay(sec);
  }else{
     Serial.print("ACK NO");
     Serial.print(" DEVICE DV3");
     Serial.print(" TYPE MQ135");
     delay(5000);
  }
}
