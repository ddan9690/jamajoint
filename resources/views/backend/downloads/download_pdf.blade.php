<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automatic PDF Download</title>
</head>
<body>
    <h1>PDF Download</h1>
    <p>Your PDF is ready. The download will start automatically.</p>

    <script>
        // Redirect to the PDF download link
        window.location.href = "{{ $pdfFilePath }}";
    </script>
</body>
</html>
