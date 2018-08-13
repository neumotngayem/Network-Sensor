/* Author: Hoai Bac */
#include "DHT.h"
#include "MQ135.h"//Air sensor library

const int DHTPIN = 2;       //Read data DHT from PIN 2
const int DHTTYPE = DHT11;  //Chose DHTTYPE
const int MC52PIN = 3;       //Read data DHT from PIN 2
DHT dht(DHTPIN, DHTTYPE);
MQ135 mqSensor(A0);//mqsensor

const String DVID = "DV2";
String HOSTNM;
String DVTYPE;

int ACK_FLG = 0;
int SEND_FLG = 0;
int GUARANTEE = 0;
int SEC_WAITACKNO = 2000;
int SEC_NONMC52 = 13000; //Default sec value
int SEC_MC52 =  1000;
int SEC_ACKONO = 10000;


void setup() {
  //Start Serial at baudrate 9600
  Serial.begin(9600);
  //Start the sensor
  dht.begin();
  pinMode(MC52PIN, INPUT_PULLUP);
}

void loop() {
  float h = dht.readHumidity();    //Read Humidity
  float t = dht.readTemperature(); //Read Temperature
  if (!isnan(h) && !isnan(t) && analogRead(A0) == 0) {
    DVTYPE = "DHT11";
  }
  if (!isnan(h) && !isnan(t) && analogRead(A0) != 0) {
    DVTYPE = "MQ135";
  }
  if (isnan(h) && isnan(t)) {
    DVTYPE = "MC52";
  }
  if (Serial.available() > 0) {
    String inString = Serial.readString();

    if (inString.indexOf("ACKYES") != -1 && inString.indexOf("HS:") != -1) {
      //Get the index of str 'ACK' from incoming str
      int indexAck = inString.indexOf("ACKYES");
      //Data receive will be like DV1 ACK SEC 30
      //From indexSec we extract the device ID
      String dvid = inString.substring(0, indexAck);
      //If it was this device
      if (dvid.equals(DVID)) {
        ACK_FLG = 1;
        int indexHS = inString.indexOf("HS:");
        int indexEND = inString.indexOf("\n");
        HOSTNM = inString.substring((indexHS + 3), indexEND);
      }
    }
    if (inString.indexOf("ACKNO") != -1) {
      //Get the index of str 'ACK' from incoming str
      int indexAck = inString.indexOf("ACKNO");
      //Data receive will be like DV1 ACK SEC 30
      //From indexSec we extract the device ID
      String dvid = inString.substring(0, (indexAck));
      if (dvid.equals(DVID)) {
        ACK_FLG = 0;
      }
    }
    if ((DVTYPE != "MC52") && (inString.indexOf("WXSENDSTART") != -1)) {
      SEND_FLG = 1;
    }
  }

  if (ACK_FLG == 1) {
    if (SEND_FLG == 1) {
      delay(2000);
      SEND_FLG = 0;
      return;
    }
    if (DVTYPE == "MC52" || (SEND_FLG == 0 && GUARANTEE == 1)) {
      if (DVTYPE == "DHT11") {
        Serial.println("WXSENDSTART");
        Serial.print(HOSTNM + "TMP" + DVID + "DT:");
        Serial.println(t);              //Sent the Temparature via UART
        Serial.print("HUMDT:");
        Serial.println(h);               //Sent the Humidity via UART
        delay(SEC_WAITACKNO);
        if (Serial.available() > 0) {
          String inString = Serial.readString();
          if (inString.indexOf("ACKNO") != -1) {
            //Get the index of str 'ACK' from incoming str
            int indexAck = inString.indexOf("ACKNO");
            //Data receive will be like DV1 ACK SEC 30
            //From indexSec we extract the device ID
            String dvid = inString.substring(0, (indexAck));
            if (dvid.equals(DVID)) {
              ACK_FLG = 0;
              return;
            }
          }
        }
        delay(SEC_NONMC52);                    //Wait for sec variable's value second
      }
      if (DVTYPE == "MQ135") {
        Serial.println("WXSENDSTART");
        Serial.print(HOSTNM + "CO2" + DVID + "DT:");
        Serial.println(mqSensor.getCalibratedCO2(t, h));
        Serial.print("COODT:");
        Serial.println(mqSensor.getCalibratedCO(t, h));
        Serial.print("ETHDT:");
        Serial.println(mqSensor.getCalibratedEthanol(t, h));
        Serial.print("TOLDT:");
        Serial.println(mqSensor.getCalibratedToluene(t, h));
        Serial.print("ACEDT:");
        Serial.println(mqSensor.getCalibratedAcetone(t, h));
        Serial.print("ANADT:");
        Serial.println(analogRead(A0));
        GUARANTEE = 0;
        delay(SEC_WAITACKNO);
        if (Serial.available() > 0) {
          String inString = Serial.readString();
          if (inString.indexOf("ACKNO") != -1) {
            //Get the index of str 'ACK' from incoming str
            int indexAck = inString.indexOf("ACKNO");
            //Data receive will be like DV1 ACK SEC 30
            //From indexSec we extract the device ID
            String dvid = inString.substring(0, (indexAck));
            if (dvid.equals(DVID)) {
              ACK_FLG = 0;
              return;
            }
          }
        }
        delay(SEC_NONMC52);                    //Wait for sec variable's value second
      }
      if (DVTYPE == "MC52") {
        Serial.print(HOSTNM + "OPN" + DVID + "DT:");
        Serial.println(digitalRead(MC52PIN));
        delay(SEC_MC52);                    //Wait for sec variable's value second
      }
    } else {
      delay(2000);
      GUARANTEE = 1;
      return;
    }
  } else {
    Serial.print(DVID);
    Serial.print("ACKNO");
    Serial.print("TYP:");
    Serial.print(DVTYPE);
    Serial.println();
    delay(SEC_ACKONO);
  }
}


