document.addEventListener("DOMContentLoaded", function() {
    // Fade in the main container
    var container = document.querySelector(".container");
    if (container) {
        container.classList.add("fade-in");
    }

    // Animate any toast message
    var message = document.querySelector(".message");
    if (message) {
        message.classList.add("show");
        // Automatically remove message after 3 seconds
        setTimeout(function() {
            message.classList.remove("show");
        }, 3000);
    }
});