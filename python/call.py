import serial
import sys
import time

callnum = 'ATD'+sys.argv[1]
port = serial.Serial("/dev/ttyAMA0",baudrate=9600,timeout=1)
port.write('AT'+'\r\n')
print('AT')
time.sleep(1)
port.write(callnum+'\r\n')
print("Calling")

    
