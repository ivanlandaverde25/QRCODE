<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escanear Código QR</title>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
        #qr-reader {
            width: 500px;
            margin: auto;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Escanear Código QR</h2>

    <div id="qr-reader" style="width: 500px; margin: auto;"></div>
    <div id="qr-result" style="text-align: center; margin-top: 20px;"></div>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Este método se llama cuando un código QR es escaneado correctamente.
            document.getElementById('qr-result').innerHTML = `Código escaneado: ${decodedText}`;

            // Aquí puedes hacer una solicitud AJAX a Laravel para enviar el valor escaneado.
            fetch(`/api/consulta-qr/${decodedText}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert('Resultado encontrado: ' + JSON.stringify(data));
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function onScanFailure(error) {
            // Esto se llama si no se pudo escanear el QR.
            console.warn(`Error de escaneo: ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250 });

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
</body>
</html>
