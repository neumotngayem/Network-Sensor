#include "MQ135.h"//Air sensor library
#include "DHT.h"
MQ135 mqSensor(A0);//mqsensor
const int DHTPIN = 2;       //Read data DHT from PIN 2
const int DHTTYPE = DHT11;  //Chose DHTTYPE
DHT dht(DHTPIN, DHTTYPE);
void setup() {
  // put your setup code here, to run once:
  Serial.begin(9600); // Initialize serial port to send and receive at 9600 baud
  dht.begin();   
}

void loop() {
  // put your main code here, to run repeatedly:
  float resistance = mqSensor.getResistance();//resistance
  float t = dht.readTemperature(); //Read Temperature    
  float h = dht.readHumidity();    //Read Humidity
  Serial.println(t);
  Serial.println(h);
  Serial.println(mqSensor.getCalibratedCO2(t,h));
  Serial.println(mqSensor.getCalibratedCO(t,h));
  Serial.println(mqSensor.getCalibratedEthanol(t,h));
  Serial.println(mqSensor.getCalibratedToluene(t,h));
  Serial.println(mqSensor.getCalibratedAcetone(t,h)); 
  Serial.println();
  delay(10000);
}
