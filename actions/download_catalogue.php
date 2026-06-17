<?php
// DonaMart/actions/download_catalogue.php
// Serves the product catalogue PDF for download

$catalogue_path = __DIR__ . '/../assets/DonaMart_Catalogue.pdf';

// Check if file exists
if (!file_exists($catalogue_path)) {
    // Friendly fallback page instead of blank/broken page
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Catalogue Not Available</title>
        <style>
            *{box-sizing:border-box;margin:0;padding:0}
            body{
                font-family:'Segoe UI',system-ui,sans-serif;
                min-height:100vh;background:#fcfaf5;
                display:flex;align-items:center;justify-content:center;
            }
            .card{
                background:#fff;border-radius:20px;padding:48px 40px;
                max-width:440px;text-align:center;
                box-shadow:0 10px 40px rgba(0,0,0,0.08);
            }
            .icon{font-size:48px;margin-bottom:16px;}
            h2{color:#1b4332;margin-bottom:10px;font-size:20px;}
            p{color:#888;font-size:14px;margin-bottom:24px;line-height:1.6;}
            a{
                display:inline-block;background:#1b4332;color:#fff;
                padding:12px 28px;border-radius:50px;text-decoration:none;
                font-weight:700;font-size:14px;transition:background 0.2s;
            }
            a:hover{background:#2d6a4f;}
        </style>
    </head>
    <body>
        <div class="card">
            <div class="icon">📄</div>
            <h2>Catalogue Coming Soon</h2>
            <p>Our product catalogue PDF is being updated. Please contact our sales team directly for detailed specifications and pricing.</p>
            <a href="/DonaMart/bulk-order.php">Request Quote Instead</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// File exists - serve it for download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="DonaMart_Product_Catalogue.pdf"');
header('Content-Length: ' . filesize($catalogue_path));
header('Cache-Control: private, max-age=0, must-revalidate');
readfile($catalogue_path);
exit;