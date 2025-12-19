<?php
require_once __DIR__ . '/pdf.php';

$divContent = $_POST['html'] ?? '<p>No content</p>';

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pupil's Report Sheet - Tauheed Academy</title>
  <style>
    @page {
      size: A4;
      margin: 20px;
    }
  </style>
</head>

<body style="font-family: Helvetica, sans-serif; font-size:15px;">
$divContent
</body>

</html>
HTML;

generatePDF($html, "section.pdf", "A4", "portrait", false);
