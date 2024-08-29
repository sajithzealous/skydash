<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>
    <style>
        #pdfViewer {
            width: 100%;
            height: 600px; /* Adjust height as needed */
        }
    </style>
</head>
<body>
    <h2>PDF Viewer</h2>
    <div id="pdfViewer"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script>
        // Initialize PDF.js
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

        // Load PDF document/var/www/html/Elevate/pdf
        const pdfUrl = 'Elevate/pdf/don.pdf'; // Replace with your PDF URL
        const loadingTask = pdfjsLib.getDocument(pdfUrl);
        
        loadingTask.promise.then(function(pdf) {
            // Fetch the first page
            pdf.getPage(1).then(function(page) {
                const scale = 1.5;
                const viewport = page.getViewport({ scale: scale });

                // Prepare canvas using PDF page dimensions
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext).promise.then(function() {
                    document.getElementById('pdfViewer').appendChild(canvas);
                });
            });
        }, function (reason) {
            // PDF loading error
            console.error('Error loading PDF: ' + reason);
        });
    </script>
</body>
</html>
