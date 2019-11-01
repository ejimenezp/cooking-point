var time = document.getElementsByTagName('time')[0],
    start = document.getElementById('start'),
    stop = document.getElementById('stop'),
    clear = document.getElementById('clear'),
    myBar = document.getElementById("myBar"),

    seconds = 0, minutes = 12, width = 0,
    t;

function add() {
    seconds++;
    if (seconds >= 60) {
        seconds = 0;
        minutes++;
    }
    
    time.textContent = (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);
        width = minutes/120 * 100;
        width = (width > 100) ? 100 : width;
        myBar.style.width = width + "%";
        myBar.innerHTML = minutes + "'";


    timer();
}

function timer() {
    t = setTimeout(add, 1000);
}
timer();


/* Start button */
start.onclick = timer;

/* Stop button */
stop.onclick = function() {
    clearTimeout(t);
}

/* Clear button */
clear.onclick = function() {
    time.textContent = "00:00";
    seconds = 0; minutes = 0;
}

