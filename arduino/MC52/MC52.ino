const int MC52PIN = 2;       //Read data DHT from PIN 2

void setup() {
  // put your setup code here, to run once:
  pinMode(MC52PIN, INPUT);
  Serial.begin(9600);
}

void loop() {
  // put your main code here, to run repeatedly:
  Serial.println(digitalRead(MC52PIN));
  delay(1);
}
