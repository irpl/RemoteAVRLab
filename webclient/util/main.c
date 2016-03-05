/*
 * KishFan.c
 *
 * Created: 01/03/2016 09:20:34
 * Author: kishf_000
 * The Purpose of this code is to control the a cooling fan based on the temperature of the environment
 * This can be seen proof of concept for a processor cooling fan
 *
 *
 */ 


#define  F_CPU 4000000UL
#include <avr/io.h>
#include <avr/interrupt.h>
#include <util/delay.h>
#include "lcd.h"
#include "stdio.h"
#include "stdlib.h"

float temp;
int Duty;



//Counter on T0 Pin
void countInit()
{
	TCCR0 |= (1<<CS00)|(1<<CS01)|(1<<CS02);//External clock source select
	TCNT0 =0;	
}

//Calculate and print Frequency Using Timer 1 Interrupt 
ISR(TIMER1_COMPA_vect)
{
	char buffer[10];
	int freq=0;
	
	freq = TCNT0;
	
	itoa(freq,buffer,10);
	lcd_gotoxy(14,2);
	lcd_print(buffer);
	TCNT0 = 0;
}

//Measure Temperature
ISR(ADC_vect)
{
	float volt = 0.0;
	volt = ADC;
	
	
	temp = (volt/4);//Vres = 2.56 / 1024 = 2.5 mv , There Each degree Celsius = 4 counts
	
	ADCSRA |= (1<<ADSC);//STart Conversion immediately
	
	//LM35 range = 2 to 150 degree Celsius from Datasheet
	
}

void printTemp()
{
	char buffer[10];
	
	lcd_gotoxy(6,1);
	sprintf(buffer,"%2.1f",temp);
	lcd_print(buffer);
	_delay_ms(61);
}

//Duty Cycle Functions
void printDuty()
{
	char buffer[10];
	
	itoa(Duty,buffer,10);
	lcd_gotoxy(13,1);
	
	lcd_print(buffer);
}

void calcDuty(int duty)
{
	
	TCCR2 = 0x65;//Phase Correct PWM ,Non-Inverting mode, 128 prescaler for 61 HZ PWM
	OCR2 = (duty*255)/100;
	Duty = duty;
}

//Changes the duty Cycle of the PWM signal in response to Change in Temperature 
void setDuty(float temp)
{
	
	if((temp>=0)&&(temp<26))
	{
		calcDuty(30);
	}
	else
	{
		if((temp>=26)&&(temp<28))
		{
			calcDuty(65);
		}
		else
		{
		
			if((temp>28)&&(temp<=32))
			{
				calcDuty(85);
			}
			else
			{
				
				if(temp>32)
				{
					calcDuty(100);
				}
				
			}
				
			
		}
		
	}
			
}



void printOCR()
{
	char buffer[10];
	lcd_gotoxy(6,2);
	
	itoa(OCR2,buffer,10);
	lcd_print(buffer);
	
}

int main(void)
{
	
	DDRB = 0xFF;
	DDRB |= (1<<PB3)|(1<<PB2)|(1<<PB1);
	DDRD |= (1<<PD0);
	PORTD &= ~(1<<PD0);
	DDRA &= ~(1<<PA0);
	
	ADMUX |= (1<<REFS1)|(1<<REFS0);//Internal Vref and ADC on PA0
	ADCSRA |= (1<<ADEN)|(1<<ADIE)|(1<<ADPS2)|(1<<ADPS1);
	ADCSRA |= (1<<ADSC);
	
	TCCR1A = 0x00;
	TCCR1B = 0x0C;		//CTC mode, 256 prescaler
	TIMSK = (1<<OCIE1A);	//enable Timer1 compare match int.
	OCR1A = 15625; //Compare at 1 second
	
	sei();//Global Interrupt Enable
	
	
	
	lcd_init();
	
	lcd_gotoxy(1,1);
	lcd_print("Temp:");
	
	lcd_gotoxy(10,1);
	lcd_print("DC:");
	
	lcd_gotoxy(1,2);
	lcd_print("OCR2:");
	
	lcd_gotoxy(9,2);
	lcd_print("Freq:");
	
    while(1)
    {
        printTemp();
		setDuty(temp);
		printDuty();
		printOCR();
    }
}