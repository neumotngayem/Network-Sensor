import serial
import sys
import time
import logging

port = serial.Serial("/dev/ttyAMA0",baudrate=9600,timeout=1)
logging.basicConfig(filename='sms.log', filemode='w', level=logging.DEBUG)
#port.write("ATD*102#"+'\r\n')
#print("Calling")
#port.write('AT+CMGD=1,4'+'\r\n')
#time.sleep(2)
#time.sleep(5)
port.write('AT+CUSD=1,"*102#",15'+'\r\n')
#time.sleep(2)
#port.write('AT+CMGL="ALL"'+'\r\n')
print('Waiting....')
time.sleep(5)
reply = port.read(port.inWaiting())
logging.info(reply)
print reply
