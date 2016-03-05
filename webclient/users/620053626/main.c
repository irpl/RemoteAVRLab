/* Attint2313 blink program */
int main(void)
{
    DDRD |= (1 << PD6);  // make PD6 an output

    while(1)
    {
        PORTD ^= (1 << PD6);  // toggle PD6
        _delay_ms(1000);  // delay for a second
    }
    return 0;  // the program executed successfully
}