<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'fpdf/fpdf.php';
require 'FPDI/src/autoload.php';

use setasign\Fpdi\Fpdi;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signatureData"])) {
    // Get the uploaded signature image
    $signatureData = $_POST['signatureData'];

    // Move the uploaded file to a temporary location
    $uploadDir = 'pdf/';
    $signatureImage = $uploadDir . 'signature.png'; // Temporary signature image file
    file_put_contents($signatureImage, file_get_contents($signatureData));

    // Load the existing PDF file
    $pdf = new Fpdi();
    $pageCount = $pdf->setSourceFile('pdf/don.pdf'); // Assuming 'don.pdf' is in the 'pdf/' directory

    // Loop through each page of the PDF
    for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
        $pdf->AddPage();
        $templateId = $pdf->importPage($pageNumber);
        $pdf->useTemplate($templateId, 0, 0, null, null, true);

        // Add the signature image
        $pdf->Image($signatureImage, 50, 50, 50, 0, 'PNG'); // Adjust position and size as needed
    }

    // Output the modified PDF
    $outputFilename = 'signed_don.pdf';
    $pdf->Output($uploadDir . $outputFilename, 'F');

    // Provide a link to download the signed PDF
    echo '<a href="' . $uploadDir . $outputFilename . '">Download Signed PDF</a>';

    // Clean up: remove the temporary signature image
    unlink($signatureImage);
} else {
    echo 'Error: Signature data not provided.';
}
?>
