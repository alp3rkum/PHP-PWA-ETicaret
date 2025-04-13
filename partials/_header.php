<?php
    date_default_timezone_set('Europe/Istanbul');
    require_once 'functions/db.php';
    $database = Database::getInstance();
    $conn = $database->getConnection();

    $keys = ['site_baslik', 'site_aciklama', 'site_keywords', 'og:title', 'og:description', 'og:image', 'og:url', 'og:type', 'og:site_name', 'twitter:card', 'twitter:title', 'twitter:description', 'twitter:image', 'twitter:site'];
    $placeholders = "'" . implode("','", $keys) . "'";

    $global_vars = $database->select("var_key, var_value FROM global_vars WHERE var_key IN ($placeholders)",false);
    
    $seo_data = [];
    foreach ($global_vars as $row) {
        $seo_data[$row['var_key']] = $row['var_value'];
    }

    $currentPath = $_SERVER['REQUEST_URI'];
    ob_start();
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <meta name="description" content="<?= $seo_data['site_aciklama'] ?>">
    <meta name="keywords" content="<?= $seo_data['site_keywords'] ?>">
    <title><?= $seo_data['site_baslik'] ?></title>

    <meta property="og:title" content="<?= $seo_data['og:title'] ?>">
    <meta property="og:description" content="<?= $seo_data['og:description'] ?>">
    <meta property="og:image" content="<?= $seo_data['og:image'] ?>">
    <meta property="og:url" content="<?= $seo_data['og:url'] ?>">
    <meta property="og:type" content="<?= $seo_data['og:type'] ?>">
    <meta property="og:site_name" content="<?= $seo_data['og:site_name'] ?>">

    <meta name="twitter:card" content="<?= $seo_data['twitter:card'] ?>">
    <meta name="twitter:title" content="<?= $seo_data['twitter:title'] ?>">
    <meta name="twitter:description" content="<?= $seo_data['twitter:description'] ?>">
    <meta name="twitter:image" content="<?= $seo_data['twitter:image'] ?>">
    <meta name="twitter:site" content="<?= $seo_data['twitter:site'] ?>">
</head>
<body>
    <header>

    </header>