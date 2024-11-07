function checkConnection() {
    let slowConnectionAlertTriggered = false;

    if (!navigator.onLine) {
        alert('No Internet Connection');
        slowConnectionAlertTriggered = true;
    } else {
        const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

        let isSlow = false;

        if (connection) {
            if (connection.downlink < 0.5 || connection.effectiveType.includes('2g')) {
                console.log("Connection is slow based on downlink or effective type.");
                isSlow = true;
            }
        } else {
            console.log("Connection information not available.");
        }

        const startTime = Date.now();
        const img = new Image();
        img.src = 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_light_color_272x92dp.png' + '?_t=' + new Date().getTime();

        img.onload = function() {
            const loadTime = Date.now() - startTime;
            console.log("Image loaded in " + loadTime + " ms");

            if (!slowConnectionAlertTriggered && (isSlow || loadTime >= 3000)) { 
                console.log("Connection determined to be slow.");
                alert('Your Internet Connection is Slow');
                slowConnectionAlertTriggered = true;
            }
        };

        img.onerror = function() {
            if (!slowConnectionAlertTriggered) {
                console.log("Error loading image. Likely a slow connection.");
                alert('Your Internet Connection is Slow');
                slowConnectionAlertTriggered = true;
            }
        };

        setTimeout(function() {
            if (!slowConnectionAlertTriggered && document.readyState !== 'complete') {
                console.log("Page is still loading after 7 seconds. Triggering slow connection alert.");
                alert('Your Internet Connection is Slow');
                slowConnectionAlertTriggered = true;
            }
        }, 7000);
    }
}

checkConnection();

window.addEventListener('offline', checkConnection);
window.addEventListener('online', checkConnection);
if (navigator.connection) {
    navigator.connection.addEventListener('change', checkConnection);
}

window.addEventListener('load', function() {
    console.log("Page has fully loaded.");
});
