<!DOCTYPE html>
<html>
<head>
<title></title>
<style type="text/css">
   
    textarea{
        width:100%;
    }
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>


</head>
<body>
<div id="content">
<h1>DELAY LOOPS & DIGITAL INPUT/OUTPUT</h1>
<h3>EXPERIMENT 1</h3>
<h4>AVR Microcontroller Experiment</h4>
<p>Experiments adapted from AVR-Tutorials - Website: <a href="http://www.AVR-Tutorials.com">www.AVR-Tutorials.com<a></p>
<p>
    <h3>Objectives</h3>
    <ul>
        <li>Setup the AVR STK500 programmer.</li>
        <li>Write assembly code in AVR studio 6. </li>
        <li>Build and download a hex file to an AVR microcontroller. </li>
        <li>Calculate execution time for an assembly code. </li>
    </ul>
</p>
<p>
    <h3>Preparation</h3>
    <ul>
        <li>Review the section of the AVR 8-bit microcontroller family datasheet on digital input/output. </li>
        <li>Review the sections in the text book on digital input/output and the calculation of execution time.</li>
    </ul>
</p>
<p>
    <h3>Laboratory Procedure</h3>
    <ol>
        <li>Obtain a breadboard and the necessary components and construct the circuit in <strong>Figure 1</strong>.</li><br/>
        <img width="75%" src="img/fig1.jpg"></img><br/><br/>
        <li>Analyze the code in <strong>Figure 2</strong>. How would the LEDs behave if this code was downloaded to and running on the microcontroller?</li><br/>
        <textarea rows="4" cols="50" ></textarea><br/>
        <img src="img/fig2.jpg"></img><br/><br/>
        <li>Start AVR studio 6. Create a new assembly project selecting the ATTINY2313 as the microcontroller for this project.</li><br/>
        <li>Type the code given in <strong>Figure 2</strong>, generate the hex file and download it to the microcontroller in the circuit from part 1.</li><br/>
        <li>Power-up your circuit and describe the behavior of the LEDs.</li><br/>
        <textarea rows="4" cols="50" ></textarea><br/><br/>
        <li>Does your expected observation from part 2 differ from that of part 5? Yes No</li>
        <form>
            <input type="radio" name="answer" value="yes" > Yes
            <input type="radio" name="answer" value="no"> No<br>
        </form> <br/>
        <li>If you answer for part 6 is yes give an explanation for the difference.</li><br/>
        <textarea rows="4" cols="50" ></textarea><br/><br/>
        <li>Now modify your code to reflect the changes in <strong>Figure 3</strong>. Generate the new hex file and download it to the microcontroller.</li><br/>
        <li>Power-up your circuit and describe the behavior of the LEDs.</li><br/>
        <textarea rows="4" cols="50" ></textarea><br/><br/>
        <li>Give an explanation why the LEDs blink using one code and does not using the other code.</li><br/>
        <textarea rows="4" cols="50" ></textarea><br/><br/>
        <img src="img/fig3.jpg"></img>
        <li>Calculate the execution time for the block of code in Figure 3.</li><br/>
        <textarea rows="4" cols="50" ></textarea><br/><br/>
        <li>Design and write an assembly code in the space provided below that if downloaded to the microcontroller in Figure 1 will simulate a lit LED running back and forth indefinitely.</li><br/>
        <li>Verify that your code works by typing the code in AVR Studio 6. Generate the hex file and download it to the microcontroller.</li><br/>
        <li>Ensure that you demonstrate the working of your code to the Lecturer or the Lab Personnel and obtain their verification signature.</li><br/>
    </ol>
</p>
<p>Experiments adapted from AVR-Tutorials - Website: <a href="http://www.AVR-Tutorials.com">www.AVR-Tutorials.com<a></p>
</div>
<script type="text/javascript" >
 function demoFromHTML() {
    var pdf = new jsPDF('p', 'pt', 'letter');
   //pdf = new jsPdf();
    //...
   
    
//     // source can be HTML-formatted string, or a reference
//     // to an actual DOM element from which the text will be scraped.
    source = $('#content');

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
        top: 0,
        bottom: 60,
        left: 0,
        width: 522
    };
    // all coords and widths are in jsPDF instance's declared units
    // 'inches' in this case
    pdf.addHTML(
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
// }
    
    // var pdf = new jsPDF('p','pt','a4');
    // var options = {
    //      pagesplit: true
    // };
    // pdf.addHTML(document.getElementById("content"),function() {
    //     pdf.save('web.pdf');
    // });
 }
</script>
<button onclick="javascript:demoFromHTML();">Generate Report</button>
</body>
</html> 