<?php
// actions/download_catalogue.php

$file = __DIR__ . '/../assets/DonaMart_Catalogue.pdf';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="DonaMart_Catalogue.pdf"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
} else {
    die("Catalogue file not found.");
}
?>
