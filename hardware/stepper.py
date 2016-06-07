# stepper.py - stepper moter driver for Baguni
# by lino

import RPi.GPIO as GPIO
import time

class STEP:
	# predefined valeus
	CW = 1
	CCW = 2

	# stepper motor setting values
	STEP_PINS = [16, 19, 20, 26] # [A, A', B, B']
	PULSE_WIDTH = 1.2 # in ms

	def __init__(self):
		GPIO.setmode(GPIO.BCM)
		GPIO.setwarnings(False) 
		for i in range(0, len(self.STEP_PINS)):
			GPIO.setup(self.STEP_PINS[i], GPIO.OUT)

	def run(self, dir, step):
			for i in range(step):
				if dir == self.CW:
					for j in range(0, 4):
						GPIO.output(self.STEP_PINS[j], i%4 == j)
				if dir == self.CCW:
					for j in range(0, 4):
						GPIO.output(self.STEP_PINS[3-j], i%4 == j)
				time.sleep(self.PULSE_WIDTH/1000.0)

			#signal off after done
			for i in range(0, len(self.STEP_PINS)):
				GPIO.output(self.STEP_PINS[i], GPIO.LOW)

	def __del__(self):
		GPIO.cleanup()
