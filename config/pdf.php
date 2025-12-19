<?php
// pdf_config.php

require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configure Dompdf options
$options = new Options();
$options->set('isRemoteEnabled', true); // allow loading of external images/css
$options->set('defaultFont', 'Arial');

// Create Dompdf instance with options
$dompdf = new Dompdf($options);

// Helper function to generate PDF from HTML
function generatePDF($html, $filename = "document.pdf", $paperSize = "A4", $orientation = "portrait", $download = false)
{
    global $dompdf;

    // Load HTML
    $dompdf->loadHtml($html);

    // Setup paper size and orientation
    $dompdf->setPaper($paperSize, $orientation);

    // Render PDF
    $dompdf->render();

    // Output: stream to browser or force download
    if ($download) {
        $dompdf->stream($filename, ["Attachment" => true]);
    } else {
        $dompdf->stream($filename, ["Attachment" => false]);
    }
}
