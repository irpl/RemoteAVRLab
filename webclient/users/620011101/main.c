#define F_CPU 1000000L
#include <avr/io.h>
#include <util/delay.h>

int main(void)
{
	DDRB = 0xFF; // PORTB is output, all pins
	PORTB = 0b10101010; // Make pins low to start

	for (;;) 
	{
      
		PORTB ^= 0xff; // invert all the pins
		_delay_ms(1000); // wait some time
      }
	
	return 0;
}