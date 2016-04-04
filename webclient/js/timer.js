function startTimer(duration) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        _("time").textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
            /*
            alert("time's up");
            hearder to booking page
            */
        }
    }, 1000);
}