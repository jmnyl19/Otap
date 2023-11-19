

document.addEventListener("DOMContentLoaded", function () {
    function updateDateTime() {
        var now = new Date();
        var datetime = now.toLocaleString();
        document.getElementById("datetime").innerHTML = datetime;
    }
    
    // Initial update
    updateDateTime();
    
    // Set interval to update every 1 second (adjust as needed)
    setInterval(updateDateTime, 1000);
});