/* Author: Hoai Bac */

const int th50kPin = 2; //Read data TH50K from PIN 2
int sec = 30000; //Default sec value
 
void setup() {
  //Start Serial at baudrate 9600
  Serial.begin(9600);
  //Declare as the INPUT DATA
  pinMode(th50kPin,INPUT);
}
 
void loop() {
  int val = digitalRead(th50kPin); //Value get from TH50K sensor
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
      if(dvid.equals("DV2")){
        //Change sec variable's value with the new value just receive
        sec = (incomingByte.substring((indexSec+4)).toInt())*1000;
      }
    }
  }
  Serial.println("DEVICE DV2");
  Serial.println("TYPE TH50K");
  Serial.print("WATER ");
  Serial.println(val);             //Sent the water status via UART
  Serial.print("SEC ");
  Serial.println(sec);
  Serial.println();                //Sent the current variable's value via UART
  delay(sec);                      //Wait for sec variable's value second
}


