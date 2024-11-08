<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Scanner</title>
</head>
<body>
<h1>Barcode Scanner</h1>

<!-- Video container for camera feed -->
<div id="scanner" style="width: 100%; height: auto;"></div>

<!-- Placeholder for the scanned result -->
<p>Scanned Code: <span id="result"></span></p>

<!-- QuaggaJS from CDN -->
<script src="https://unpkg.com/@ericblade/quagga2@1.2.6/dist/quagga.min.js"></script>

<script>
    // Initialize QuaggaJS
    document.addEventListener("DOMContentLoaded", function() {
        if (navigator.mediaDevices && typeof navigator.mediaDevices.getUserMedia === 'function') {
            // Configure QuaggaJS
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#scanner'), // Attach to the video element
                    constraints: {
                        facingMode: "environment" // Use the back camera
                    }
                },
                decoder: {
                    readers: ["code_128_reader", "ean_reader", "ean_8_reader", "upc_reader"] // Supported barcode types
                }
            }, function(err) {
                if (err) {
                    console.log(err);
                    return;
                }
                Quagga.start(); // Start the camera and begin scanning
            });

            // Handle detected barcode
            Quagga.onDetected(function(data) {
                const code = data.codeResult.code;
                document.getElementById('result').innerText = code; // Display the scanned barcode
                Quagga.stop(); // Stop scanning after one result is found (optional)
            });
        } else {
            alert("Camera not accessible!");
        }
    });
</script>
</body>
</html>
