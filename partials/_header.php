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
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/slider.css">
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.0/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <header class="container-fluid p-3">
        <div class="row">
            <div class="col select-none">
                <div id="logo-mobile">
                    <img src="../assets/images/logo.png" alt="" width="80">
                </div>
                <div id="logo-standard" class="d-inline-flex align-items-center gap-4">
                    <i class="bi bi-cart4 text-[42px]"></i>
                    <span class="font-extralight text-[28px]"><h1>PWA ECommerce Demo</h1></span>
                </div>
            </div>
            <div class="col">
                <div id="search-bar" class="d-flex justify-content-center align-items-center mt-2 mb-2">
                    <input type="text" class="form-control" placeholder="Search for products...">
                    <button class="btn ml-2">Search</button>
                </div>
            </div>
            <div class="col d-flex justify-content-end align-items-center mr-2">
                <div id="header-nav-1">
                    <a href="#" class="btn">Main Page</a>
                    <a href="#" class="btn">About</a>
                    <a href="#" class="btn">Products</a>
                    <a href="#" class="btn">Contact</a>
                    <a href="#" class="btn">Login/Signup</a>
                </div>
                <div id="header-nav-2">
                    <button class="navbar-toggler mt-4 mb-4" type="button" id="toggleNavbar" aria-expanded="false" aria-label="Toggle navigation">
                        <i id="navbar-chevron" class="bi bi-chevron-down transition duration-250 text-[22px]"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="navbarMobile">
            <ul class="nav flex-column">
                <li class="nav-item"><a href="#" class="btn">Main Page</a></li>
                <li class="nav-item"><a href="#" class="btn">About</a></li>
                <li class="nav-item"><a href="#" class="btn">Products</a></li>
                <li class="nav-item"><a href="#" class="btn">Contact</a></li>
                <li class="nav-item"><a href="#" class="btn">Login/Signup</a></li>
            </ul>
        </div>
    </header>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var navbarToggler = document.querySelector('.navbar-toggler');
            var navbarMobile = document.querySelector('#navbarMobile');
            var navbarChevron = document.querySelector('#navbar-chevron');
            
            navbarToggler.addEventListener('click', function() {
                navbarMobile.classList.toggle('show');
                navbarChevron.classList.toggle('bi-chevron-down');
                navbarChevron.classList.toggle('bi-chevron-up');
                navbarChevron.classList.toggle('');
            });
        });
    </script>