/*
 * Digital Clock.c
 *
 * Created: 10/24/2015 7:07:06 PM
 *  Author: Jevon Butler 
 * ID: 620058357
 prescalar  - 1024
 XTAL = 7.372800MHZ
 1/7.3638MHz = 0.0135 us * prescalar = 34.722us -> #machine cycles = 1/34.722us = 28,800
 
 TCNT1 = 65,535 - 28,800 = 36735 = 0x8f7f  - value was adjusted to accomplish real time
 No CLock Division (No Divide by 8)
 External Crystal 3-8 mhz  4ms1
 */ 
#define F_CPU 7372800UL
#include <stdlib.h>
#include <avr/interrupt.h>
#include <avr/io.h>
#include <util/delay.h>

//Declaration and Initialization of Variables
//Time Values
int twen_twel = 0; //default to twenty four slot
int am_pm = 1; //default to pm
int midnight_midday = 0; //default to midnight
int hrs =12;
int mins =0;
int secs =0;
//Alarm Values
int asecs = 0;
int amins = 0;
int ahrs =  0;
//Button and Alarm Variables
int alarm_on = 0;
int buzzer = 0;
//Declaration of Functions 
void setdisplay(int led, unsigned char number);
void initiate_clock();
void setup();
/**********************************************************************/
// This function is used to display the number on the 7-segment .
/*********************************************************************/

unsigned char display7seg(unsigned char light)
{
	unsigned char display = '0'; // initialize the variable display.
	switch(light)  // begin switch statements
	{						  
		case 0:	display = 0b00111111; //display 0
			break;
		case 1: display = 0b00000110;  //  display 1 on the 7 segment display
			break;
		case 2 :display = 0b01011011;	//  displaying 2 on the 7-segment
			break;
		case 3: display = 0b01001111; //  displaying 3 on the 7-segment
			break;
		case 4: display = 0b01100110;	// displaying 4 on the 7-segment 
			break;
		case 5: display = 0b01101101;  // displaying 5 on the 7-segment
			break;
		case 6: display = 0b01111101; // displaying 6 on the 7-segment
			break;
		case 7: display = 0b00000111; // displaying 7 on the 7-segment
			break;
		case 8: display = 0b01111111; // displaying 8 on the 7-segment		
			break;
		case 9: display = 0b01101111; // displaying 9 on the 7-segment
			break;
		case 10: display = 0b01110110; // displaying H on the 7-segment
			break;
		case 11: display = 0b01110111; // displaying A on the 7-segment
			break;
		case 12: display = 0b01111011; // displaying P on the 7-segment
			break;
	}
	return (display); // return display value
}

/**********************************************************/
//  Mode Button
// This function it ussed to display and set alarm hours and minutes during setup procedure
/*********************************************************/
void setup(){
	do{
		//display alarm hours on respective 7 segment displays
		setdisplay(1,ahrs/10);
		PORTD = 0b00001111;
		setdisplay(2,ahrs%10);
		PORTD = 0b01001111;
		//display alarm minutes on repsective 7 segment displays
		setdisplay(3,amins/10);
		PORTD = 0b00101111;
		setdisplay(4,amins%10);
		PORTD = 0b01101111;
		//displaying running seconds 
		setdisplay(5,secs/10);
		PORTD = 0b00011111;
		setdisplay(6,secs%10);
		PORTD = 0b01011111;
		if (twen_twel == 0){setdisplay(7,10);PORTD = 0b00111111;
		}else{if (am_pm==0){ setdisplay(7,11); PORTD = 0b00111111;
			}else{setdisplay(87,12);PORTD = 0b00111111;}}
		//If PIND0 is pressed increment alarm hours
		if(!(PIND & (0x01)))
		{
			_delay_ms(70);
			if (twen_twel == 0){if(ahrs < 23 )ahrs++;
			}else if (twen_twel == 1 && am_pm == 1){if(ahrs < 11 )ahrs++;}
				else if (twen_twel == 1 && am_pm == 0){if(ahrs < 12 )ahrs++;}
				else ahrs = 0;
		}
		// If PIND1 is pressed increment alarm minutes
		if(!(PIND & (0x02)))
		{   _delay_ms(70);amins ++;if(amins > 59)amins = 0;
		}
		//If PIND3 is pressed the mode will be switched from 24 hour to 12 hour
		if(!(PIND & (0x08)))
		{   _delay_ms(70);if (twen_twel == 0){twen_twel = 1;if (ahrs>12)ahrs = ahrs - 12;if (hrs>12){hrs = hrs -12;am_pm = 1;}else{am_pm = 0 ;}
			}else{ twen_twel =0;if (am_pm ==1){ahrs = ahrs + 12;hrs = hrs + 12;}	}
		}
	}				
	while((PIND & (0x04))); // Repeat procedure until PIND2 is pressed 
		_delay_ms(70);			
	}
void initiate_clock(){
	DDRB = 0xFF;		// Defining Port B as Output (Direct Data Register PortB as high)
	DDRD = 0b01110000;		// Defining Port D  pins 0-3 as Input (Direct Data Register PortD as low) and pins 4-6 as output
	TCNT1H =0xf1;	   // Timer 1 High Byte  - Values tested until value was close to real time [f2,0xea,];
	TCNT1L =0xcc;	 //Timer 1 Low Byte  - Values tested until value was close to real time [0x60,0xd8];
	TCCR1A =0x00; 	//Ommitting TCCR1A
	TCCR1B= 0x04;  // Setting Timer Counter Register 1B to 1024 prescalar Equivalent expression 
	TIMSK|=(1<<TOIE1);  //Enabling Timer overflow interrupt 
	sei();				// set global interrupt flag
}
/*************************************************/
//	SET DISPLAY FUNCTION - Call to this function causes a delay in the main execution of this program
/************************************************/
void setdisplay(int led, unsigned char number){
	unsigned char display = '0'; //initialize display to 0
	switch(led){ // begin switch statements
		case 1:
			display = display7seg(number); //saves binary representation returned from call to display7 seg function
			PORTB = display;				//sets display on port B 
		    break;
		case 2:display = display7seg(number);PORTB = display;break;	
		case 3:display = display7seg(number);PORTB = display;break;
		case 4:display = display7seg(number);PORTB = display;break;	
		case 5:display = display7seg(number);PORTB = display;break;		
		case 6:display = display7seg(number);PORTB = display;break;	
		case 7:display = display7seg(number);PORTB = display;break;}
}

/**********************************************************************/
// MAIN FUNCTION.
/*********************************************************************/
int main(void)
{
	initiate_clock(); // Initialize the clock
	while (1){do 
		{
			setdisplay(1,hrs/10); // display  first digit in hours
			PORTD = 0b00001111;  // send 000 to 3 to 8 decoder  
			setdisplay(2,hrs%10); // display second digit in hours
			PORTD = 0b01001111;// send 001 to 3 to 8 decoder   
			setdisplay(3,mins/10);// display first digit in minutes
			PORTD = 0b00101111;// send 010 to 3 to 8 decoder  
			setdisplay(4,mins%10);// display second digit in minutes
			PORTD = 0b01101111;// send 011 to 3 to 8 decoder  
			setdisplay(5,secs/10);// display first digit in seconds
			PORTD = 0b00011111;// send 100 to 3 to 8 decoder  
			setdisplay(6,secs%10);// display second digit in seconds
			PORTD = 0b01011111;// send 101 to 3 to 8 decoder 	
			if (twen_twel == 0){setdisplay(7,10);PORTD = 0b00111111;}else{
				if (am_pm==0){setdisplay(7,11);PORTD = 0b00111111;}
				else{setdisplay(7,12);PORTD = 0b00111111;}}
			//checks if PIND0 is pressed
			if(!(PIND & (0x01)))
			{
				_delay_ms(70); //delay the display
				if (alarm_on==0){
			    if (twen_twel==0){if(hrs < 23) 
						hrs++;		//increment the hours. 
					else
						hrs = 0; // set hours to 0 if it exceeds 23
				}
				else if (twen_twel==1){ //if 12 hour clock
						if (am_pm == 0){ //if am
							if (hrs>11 && midnight_midday == 0) {// if hours = 12 and midnight passed = true
								am_pm = 1; // set time of day to pm
							    midnight_midday = 1; //set midday = true
								//am_pm=1;
							}
						}
						else if (am_pm == 1 ) {// if pm
								if (hrs >12 && midnight_midday == 1)	{// if hours = 13
								hrs=1;  midnight_midday = 0; 
								}// hours = 1;
								if (hrs>11 && midnight_midday == 0){ //if hours 12 pm (midnight)
									hrs=0;  // hours = 0
									am_pm=0; //set time of day am.
							}}}}
			}
			//checks if PIND1 is pressed
			if(!(PIND & (0x02)))
			{_delay_ms(70);
				if (alarm_on==0){if(mins < 59)
					mins++; //increment the minutes. 
					else
					mins = 0; // set minutes to 0 if it exceeds 59
				}
			}
			//Checks if PIND2 is pressed 
			if(!(PIND & (0x04)))
			{ _delay_ms(70);if (alarm_on==1){  // if the alarm is on (1)
					buzzer=1;		// set buzzer pressed (1)
					alarm_on=0;   
					}   // turn off alarm (0)
					else{if (alarm_on==0)buzzer=1;}	
			}
			//Check if PIND3 is pressed 
			if(!(PIND & (0x08)))
			{_delay_ms(70);
				setup();  // Call setup function to enter alarm setting mode
				buzzer=0;	// set buzzer pressed off (0);			
			}			
			//Check if alarm time (hours and minutes) is reached while the buzzer pressed is off
		if ((hrs == ahrs) && (amins==mins)&& (buzzer==0)){PORTB = (1<<7);alarm_on=1;}
		else  if ((hrs == ahrs) && (amins==mins)&& (buzzer==1)){if (alarm_on == 1){PORTB = ~(1<<7);}}
		// Checks if it is 2 minutes beyond the alarm time. 
		if ((hrs == ahrs) && (amins+2==mins)){buzzer=0; // enable alarm check by setting buzzer pressed off(0)
		} 
	}
	while((TIFR &(1<<TOV1))==0); // While the timer1 has not overflowed continue procedure
	TIFR = 0x1<<TOV1; // when timer has overflowed set value to 1 and begin again 
}
}
// Interrupt service routine 
// Timer overflow interrupt 
// On Timer overflow interrupt this function is called
ISR(TIMER1_OVF_vect){
	secs++;  // Increment seconds
	if(secs == 60) // if seconds is at 60
	{ secs = 0;  // set seconds to 0
		mins++; // increment minutes
	}
	if(mins == 60) // if minutes is at 60
	{	mins = 0;		//set minutes to 0
		hrs++;			//increment hours
	}
	if (twen_twel==0){if(hrs > 23)  // if hours exceed 23
		hrs = 0;     // set hours = 0
	}else if (twen_twel==1){ //if 12 hour clock
			if (am_pm == 0){ //if am
				if (hrs>11 && midnight_midday == 0) {// if hours = 12 and midnight passed = true
					am_pm = 1; // set time of day to pm
				    midnight_midday = 1; //set midday = true
					//am_pm=1;
				}}else
				if (am_pm == 1 ) {// if pm
					if (hrs >12 && midnight_midday == 1)	{// if hours = 13
					hrs=1;  midnight_midday = 0; 
					}// hours = 1;
					if (hrs>11 && midnight_midday == 0){ //if hours 12 pm (midnight)
						hrs=0;  // hours = 0
						am_pm=0; //set time of day am.
				}}}
	//setting Timer Counter 1 for the next cycle
	TCNT1H =0xf1;	   // Timer 1 High Byte
	TCNT1L =0xcc;	 //Timer 1 Low Byte  
}