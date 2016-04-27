function startTimer(duration) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        _("time").textContent = minutes + ":" + seconds;

        if (--timer == 0) {
            //timer = duration;
            
            alert("Your booked slot time has elapsed.");
            //hearder to booking page
            window.location = "https://remoteavrlab-irpl.c9users.io/webclient/";
        }
    }, 1000);
}