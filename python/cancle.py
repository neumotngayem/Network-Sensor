import serial
import sys
import time
port = serial.Serial("/dev/ttyAMA0",baudrate=9600,timeout=1)
port.write('ATH')
print('ATH')
time.sleep(5)
reply = port.read(port.inWaiting())
print reply
    
