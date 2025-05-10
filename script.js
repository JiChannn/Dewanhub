document.addEventListener("DOMContentLoaded", function() {
    // Fade in the main container
    var container = document.querySelector(".container");
    if (container) {
        container.classList.add("fade-in");
    }

    // Animate toast message
    var message = document.querySelector(".message");
    if (message) {
        message.classList.add("show");
        // Automatically remove mesagge lepas 3 saat
        setTimeout(function() {
            message.classList.remove("show");
        }, 3000);
    }
});