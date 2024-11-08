<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Scanner</title>
    <!-- Html5-qrcode library from CDN -->
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
        #reader {
            width: 100%;
            max-width: 400px;
            margin: auto;
        }
    </style>
</head>
<body>
<h1>Scan Barcode</h1>
<div id="reader"></div>
<p id="result"></p>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Handle the result here (e.g., display the result in the HTML)
        document.getElementById("result").innerText = `Scanned Barcode: ${decodedText}`;
    }

    function onScanFailure(error) {
        // Log errors if needed
        console.warn(`Scan failed: ${error}`);
    }

    // Initialize the scanner
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: { width: 250, height: 250 } }
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
</body>
</html>
