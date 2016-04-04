#define F_CPU 1000000L
#include <avr/io.h>
#include <util/delay.h>

int de = 10;
int main(void)
{
	DDRB = 0xFF; // PORTB is output, all pins
	PORTB = 0x01; // Make pins low to start	
    
  	int i;
	while(1)
	{
      PORTB=0x01;
      _delay_ms(10);
      for(i =0; i<4;i++)
      {
		//PORTB ^= 0xFF; // invert all the pins
      	PORTB *= 0x02;
      	_delay_ms(10);
      }
      
	}
	return 0;
}