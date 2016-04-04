<!DOCTYPE html>
<html>
<head>
<title></title>
<style type="text/css">
    textarea{
        width:100%;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="//mrrio.github.io/jsPDF/dist/jspdf.debug.js"></script>
</head>
<body>
<div id="content">
<h1 id="title">A 7-SEG ELECTRONIC DICE</h1>
<h3>EXPERIMENT 2</h3>
<h4>AVR Microcontroller Experiment</h4>
<p>Experiments adapted from AVR-Tutorials - Website: <a href="http://www.AVR-Tutorials.com">www.AVR-Tutorials.com<a></p>
<p>
    <h3>INTRODUCTION</h3>
    <p>
        In this experiment you will use the ATtiny2313 controller to create an electronic dice. The electronic dice is designed with an input switch. <br/>
        Upon pressing the switch a random number is generated by the microcontroller. This number is then displayed on a 7-Segment Display. See Figure 1 for the circuit diagram.
    </p>
</p>
<p>
    <h3>COMPONENTS & EQUIPMENT</h3>
    <p>
        <table>
            <tr>
                <td>Components</td>
                <td>Equipment</td>
            </tr>
            <tr>
                <td>1 ATtiny2313 Microcontroller</td>
                <td>1 Breadboard with Power Supply</td>
            </tr>
            <tr>
                <td>2 7-Segment Display (LSD3221)</td>
                <td>1 AVR Chip Programmer (STK500)</td>
            </tr>
            <tr>
                <td>2 100 ohm Resistors</td>
                <td>1 AVR Chip Programmer (STK500)</td>
            </tr>
            <tr>
                <td>2 Pushbutton Switches</td>
                <td></td>
            </tr>
        </table>
    </p>
</p>
<p>
    <h3>Preparation</h3>
    <span>Before the laboratory session students are required to:</span>
    <ol>
        <li>Read the lecture notes on C programming.</li>
        <li>Read the Text Chapters on C language and Interrupts.</li>
        <li>Acquire and become familiar with the LSD3221 7-Segment display datasheet.</li>
        <li>Become familiar with the external interrupts section of ATtiny2313 Datasheet.</li>
    </ol>
</p>
<p>
    <h3>Procedure</h3>
    <ol>
        <li>Acquire the datasheet for the 7-Segment display and use it along with the schematic given in Figure 1 to complete Table I which indicates which LEDs on the 7-Segment Display to turn ON to display each character from 1 through 6.</li><br/>
        
        <li>Add comments to each line of the function <strong>main()</strong> in the c code given in the <strong>APPENDIX</strong> explicitly indicating what configurations are being done to the microcontroller.</li><br/>
        
        <li>Analyze the function <strong>main()</strong>, again from the APPENDIX, as a whole and give an overall description of its operation.</li><br/>
        
        <li>Add comments to each line of the function <strong>ISR(INT0_vect)</strong> given in the code indicating what actually is taking place.</li><br/>
        
        <li>Analyze the function <strong>ISR(INT0_vect)</strong> as a whole and give an overall description of its operation.</li><br/>
        
        <li>Research the function <strong>rand()</strong> which is used in the code and give a description of its operation.</li><br/>
        
        <li>Complete the function <strong>display7seg()</strong> which takes a number from 1 through 6 and return the value to be outputted on PORTB to display that number on the 7-Segment display.</li><br/>
        <textarea rows="4" cols="50" ></textarea><br/><br/>
        
        <li>Obtain all the components necessary to construct the circuit given in Figure 1. Construct the circuit on a breadboard and put it aside.</li><br/>
        
        <li>Create a new C project in AVR studio and type the completed code in the editor. Compile and correct any errors in the code.</li><br/>
        
        <li>Generate the hex file for the completed code and download an <strong>ATtiny2313</strong> microcontroller.</li><br/>
        
        
        <li>Place the microcontroller in the circuit and demonstrate that your code and circuit is working correctly.</li><br/>
    </ol>
</p>
<img src="img/fig1.jpg"></img><br/>
<img src="img/fig2.jpg"></img>
<textarea readonly rows="94" cols="50" style="width:60%;">
/**********************************************************************/ 
/* Authors : Leonardo Clarke                                          */
/* Date     : 01-Oct-2010                                             */
/* Version      : 1                                                   */ 
/* File name   : The Electronic Dice                                  */ 
/* AVR          : ATtiny2313                                          */ 
/**********************************************************************/  

/* Program Description: This code implements an electronic dice*/  
#include <stdlib.h> 
#include <avr/io.h> 
#include <avr/interrupt.h>  
#define F_CPU 4000000UL 
#include <util/delay.h>   

/**********************************************************************/ 
void roll(void) 
{  
	for(int i = 0; i<2;i++)  
	{   
		PORTB = 0b00000110;
		_delay_ms(40);   
		PORTB = 0b01011011;   
		_delay_ms(40);   
		PORTB = 0b01001111;   
		_delay_ms(40);   
		PORTB = 0b01100110;   
		_delay_ms(40);   
		PORTB = 0b01101101;   
		_delay_ms(40);   
		PORTB = 0b01111101;   
		_delay_ms(40);  
	}  
}  
  
//Experiments adapted from AVR-Tutorials – Website: www.AVR-Tutorials.com  

/**********************************************************************/  
// This function is used to turn on the 7-segment to display a number on the dice.  
// YOU ARE REQUIRED TO COMPLETE THIS FUNCTION.  
unsigned char display7seg(unsigned char light) 
{  
	unsigned char display = '0'; // initialize the variable display.    
	switch(light)  
	{   
		case 1 : display = 0b00000110;  // Which number does this represent on
		break;                    		// the dice?  
  		case 2 : // insert your code and comments here,     
  		break;  
		case 3 : // insert your code and comments here,     
		break;  
		case 4 : // insert your code and comments here,     
		break;  
		case 5 : // insert your code and comments here,     
		break;  
		case 6 : // insert your code and comments here,       
	}  
	return (display);  
}  
  
//Experiments adapted from AVR-Tutorials – Website: www.AVR-Tutorials.com  

/**********************************************************************/ 
// DESCRIBE BRIEFLY THE OPERATION OF THE FUNCTIONS BELOW.  
// YOU MUST INCLUDE COMMENTS WHERE NECESSARY.  
ISR(INT0_vect) 
{  
	unsigned char display = '0';  
	int n = 0;  
	unsigned char nchar = '0';  
    n = rand();  
    roll();  
    n = n%6;  
    n++;  
    nchar = (unsigned char)n;  
	display = display7seg(nchar);  
	PORTB = display; 
}  

/**********************************************************************/ 
// DESCRIBE THE OPERATION OF THE INT MAIN() FUNCTION.  
int main() 
{  
	DDRB = 0xFF;  
	DDRD = 0x00;  
	PORTB = 0xFF;    
	MCUCR |= 1;  
	MCUCR &= ~2;  
	GICR |= (1<<6);    
	sei();    
	PORTB = 0b01111111;  
 	while(1); 
}
</textarea>
<p>Experiments adapted from AVR-Tutorials - Website: <a href="http://www.AVR-Tutorials.com">www.AVR-Tutorials.com<a></p>
</div>
<script type="text/javascript" >
    function demoFromHTML() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        // source can be HTML-formatted string, or a reference
        // to an actual DOM element from which the text will be scraped.
        source = $('#content')[0];

        // we support special element handlers. Register them with jQuery-style 
        // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
        // There is no support for any other type of selectors 
        // (class, of compound) at this time.
        specialElementHandlers = {
            // element with id of "bypass" - jQuery style selector
            '#bypassme': function (element, renderer) {
                // true = "handled elsewhere, bypass text extraction"
                return true
            }
        };
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };
        // all coords and widths are in jsPDF instance's declared units
        // 'inches' in this case
        pdf.fromHTML(
        source, // HTML string or DOM elem ref.
        margins.left, // x coord
        margins.top, { // y coord
            'width': margins.width, // max width of content on PDF
            'elementHandlers': specialElementHandlers
        },

        function (dispose) {
            // dispose: object with X, Y of the last line add to the PDF 
            //          this allow the insertion of new lines after html
            pdf.save('Lab2-Report.pdf');
        }, margins);
    }
</script>
<button onclick="javascript:demoFromHTML();">Generate Report</button>
</body>
</html> 