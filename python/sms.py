import serial
import sys
import time

port = serial.Serial("/dev/ttyAMA0",baudrate=9600,timeout=1)
smsnum = "AT+CMGS=\""+sys.argv[1]+"\""
print smsnum
port.write('AT+CMGF=1'+'\r\n')
time.sleep(2)
port.write(smsnum+'\r\n')
time.sleep(2)
port.write("Warning From Hoai Bac")
time.sleep(0.5)
port.write(chr(26))
print("SMS sending")
