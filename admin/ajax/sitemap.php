<?php

// require_once '../../functions/db.php';
// $database = Database::getInstance();
// $conn = $database->getConnection();

header("Content-Type: application/xml; charset=utf-8");

$static_urls = [
    //statik URL'ler buraya eklenir
];

$dynamic_urls = [];

//$dynamic_url_chunk1 = select("");

$xml_output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$xml_output .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

// Statik URL'ler
foreach ($static_urls as $url) {
    $xml_output .= "  <url>\n";
    $xml_output .= "    <loc>$url</loc>\n";
    $xml_output .= "    <changefreq>monthly</changefreq>\n";
    $xml_output .= "    <priority>0.8</priority>\n";
    $xml_output .= "  </url>\n";
}

$xml_output .= "</urlset>";

$file_path = '../../sitemap.xml';
$file = fopen($file_path, 'w');
fwrite($file, $xml_output);
fclose($file);

echo "Sitemap başarıyla oluşturuldu ve ana dizine kaydedildi!";
?>