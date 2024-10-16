document.addEventListener('DOMContentLoaded', function() {
    
    const messageElement = document.getElementById('session-message');              // Green
    const errorElement = document.getElementById('session-error');                  // Red
    const alertElement = document.getElementById('session-alert');                  // Yellow
    
    if (messageElement || errorElement || alertElement) {
        let isVisible = true;
        let interval = setInterval(() => {
            isVisible = !isVisible;
            if (messageElement) {
                messageElement.style.visibility = isVisible ? 'visible' : 'hidden';
            }
            if (errorElement) {
                errorElement.style.visibility = isVisible ? 'visible' : 'hidden';
            }
            if (alertElement) {
                alertElement.style.visibility = isVisible ? 'visible' : 'hidden';
            }
            
        }, 500); // Toggle visibility every 500 milliseconds (0.5 seconds)

        setTimeout(() => {
            clearInterval(interval);
             if (messageElement) {
                messageElement.style.display = 'none';
            }
            if (errorElement) {
                errorElement.style.display = 'none';
            }
            if (alertElement) {
                alertElement.style.display = 'none';
            }
            
            
            
        }, 10000); // Stop blinking and hide after 10 seconds (10000 milliseconds)
    }


});





