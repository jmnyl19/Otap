

document.addEventListener("DOMContentLoaded", function () {
    function updateDateTime() {
        const date = new Date().toDateString();
        const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        document.getElementById("time").innerHTML = date.concat(" | " + time);
    }
    
    // Initial update
    updateDateTime();
    
    // Set interval to update every 1 second (adjust as needed)
    setInterval(updateDateTime, 1000);
});