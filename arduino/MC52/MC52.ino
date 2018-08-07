const int MC52PIN = 2;       //Read data DHT from PIN 2
int ACK_FLG = 0;
int count = 1;
int dopen = 0;
int check1 = 0;
int check2 = 0;
int check3 = 0;
int check4 = 0;
int check5 = 0;
int sec = 30000; //Default sec value
String hostnm;

void setup() {
  // put your setup code here, to run once:
  pinMode(MC52PIN, INPUT);
  Serial.begin(9600);
}

void loop() {
  // put your main code here, to run repeatedly:

    if(Serial.available() > 0){
    String inString = Serial.readString();
    
    if(inString.indexOf("ACKYES") != -1){
      //Get the index of str 'ACK' from incoming str
      int indexAck = inString.indexOf("ACKYES");
      //Data receive will be like DV1 ACK SEC 30
      //From indexSec we extract the device ID 
      String dvid = inString.substring(0,(indexAck -1));
      //If it was this device
      if(dvid.equals("DV2")){
        ACK_FLG = 1;
        int indexSec = inString.indexOf("SEC");
        sec = (inString.substring((indexSec+4)).toInt())*1000;
        hostnm = inString.substring(inString.indexOf("HOST")+5);
      }
    }

    if(inString.indexOf("ACKNO") != -1){
      //Get the index of str 'ACK' from incoming str
      int indexAck = inString.indexOf("ACKNO");
      //Data receive will be like DV1 ACK SEC 30
      //From indexSec we extract the device ID 
      String dvid = inString.substring(0,(indexAck -1));
      if(dvid.equals("DV2")){
        ACK_FLG = 0;
      }   
    }
    
     //If it contain 'SEC' inside
     if(inString.indexOf("SEC") != -1){
        //Get the index of str 'SEC' from incoming str
        int indexSec = inString.indexOf("SEC");
        //Data receive will be like DV2 SEC 30
        //From indexSec we extract the device ID 
        String dvid = inString.substring(0,(indexSec -1));
        //If it was this device
        if(dvid.equals("DV2")){
          //Change sec variable's value with the new value just receive
          sec = (inString.substring((indexSec+4)).toInt())*1000;
     }
    }
  }

  
  if(ACK_FLG == 1){
      check1 = digitalRead(MC52PIN);
      delay(250);
      check2 = digitalRead(MC52PIN);
      delay(250);
      check3 = digitalRead(MC52PIN);
      delay(250);
      check4 = digitalRead(MC52PIN);
      delay(250);
      check5 = digitalRead(MC52PIN);
      if(check1 == 1 || check2 == 1 || check3 == 1 
      || check4 == 1 || check5 == 1){
       dopen = 1; 
      }else{
       dopen = 0;
      }
      Serial.print("ACK YES");
      Serial.print(" HOST ");
      Serial.print(hostnm);
      Serial.print(" DEVICE DV2");
      Serial.print(" TYPE MC52");
      Serial.print(" OPEN ");
      Serial.print(dopen);
      Serial.println();
      delay(1000);
  }else{
     Serial.print("ACK NO");
     Serial.print(" DEVICE DV2");
     Serial.print(" TYPE MC52");
     delay(5000);
  }
}
