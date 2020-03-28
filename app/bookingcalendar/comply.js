
function disabler(id) {
    // this function would highlight and disable timings already booked
    var el = document.getElementById(id);
    el.style.background = "red";
    el.style.color = "white";
    el.disabled = true;
}

