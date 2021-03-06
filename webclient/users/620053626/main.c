/*
Author: Phillip Logan
ID Number: 620053626
Date: Fri Mar 18, 2016
Title:
*/

//include libraries
.include "tn85def.inc"

	LDI	R16, 0xFF
	OUT	DDRB, R16

loop:	LDI	R16, 0x00
	OUT	PORTB, R16

	LDI	R17, 0xFF
dly1:	LDI	R18, 0xFF
loop1:	DEC	R18
	BRNE	loop1
	DEC	R17
	BRNE	dly1

	LDI	R16, 0xFF
	OUT	PORTB, R16

	LDI	R17, 0xFF
dly2:	LDI	R18, 0xFF
loop2:	DEC	R18
	BRNE	loop2
	DEC	R17
	BRNE	dly2

	RJMP	loop