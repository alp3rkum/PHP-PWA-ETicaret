<?php
    $currentPath = urldecode($_SERVER['REQUEST_URI']);
?>
<?php include("partials/_header.php") ?>
<?php
    switch($currentPath)
    {
        case '/':
        case '/index':
        case '/anasayfa':
            include('anasayfa.php');
            break;
        /*
        case '/sayfa':
            include('icerik.php');
            break;
        */
        default:
            include '404.php';
            break;
    }
?>
<?php include("partials/_footer.php") ?>