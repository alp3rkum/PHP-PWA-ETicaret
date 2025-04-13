<?php
date_default_timezone_set('Europe/Istanbul');
require_once '../functions/db.php';
$database = Database::getInstance();
$conn = $database->getConnection();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$currentPath = $_SERVER['REQUEST_URI'];

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(!isset($_SESSION['admin']))
    {
        $admin_adi = $_POST['admin_adi'];
        $admin_sifre = md5($_POST['admin_sifre']);
        $admin_bilgi = $database->select("* FROM adminler WHERE kullanici_adi = '$admin_adi' AND sifre = '$admin_sifre'");
        if(count($admin_bilgi) == 1)
        {
            $_SESSION['admin'] = $admin_adi;
            header("Location: /admin/");
            exit();
        }
        else
        {
            echo '<script>alert("Geçersiz kullanıcı adı veya şifre");</script>';
        }
    }
    
}
?>
<?php if (!isset($_SESSION['admin'])): ?>
    <!DOCTYPE html>
    <html lang="tr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Girişi</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>

    <body style="min-height: 100vh; background-image: linear-gradient(225deg, #ffffff, #e0e0e0); background-position: center; background-repeat: no-repeat;">
        <main style="padding-top: 20px;">
            <div class="container" style="max-width: 500px;">
                <div id="login-form" style="padding-top: 120px;">
                    <h2 class="text-center mb-4">Admin Girişi</h2>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="admin_adi" class="form-label">Kullanıcı Adı</label>
                            <input type="text" class="form-control" id="admin_adi" name="admin_adi" required>
                        </div>
                        <div class="mb-3">
                            <label for="admin_sifre" class="form-label">Şifre</label>
                            <input type="password" class="form-control" id="admin_sifre" name="admin_sifre" required>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Giriş Yap</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>

    </html>
<?php else: ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.0/font/bootstrap-icons.min.css">
        <title>Admin Paneli</title>
        <style>
            body
            {
                background-color: rgb(240,240,240);
            }
            .sidebar-button {
                transition-duration: 0.25s;
            }
            input[type="file"]::file-selector-button {
                background-color: oklch(0.882 0.059 254.128);
                color: white;
                padding: 8px 8px;
                border: none;
                border-top-left-radius: 5px;
                border-bottom-left-radius: 5px;
                font-size: 14px;
                cursor: pointer;
                transition: background-color 0.25s ease;
                margin-right: 10px;
            }
            
            input[type="file"]::file-selector-button:hover {
                background-color: oklch(0.809 0.105 251.813);
            }
            
            input[type="file"]::file-selector-button:active {
                background-color: oklch(0.623 0.214 259.815);
            }
        </style>
    </head>
    <body>
        <header>
            <div class="row text-center p-4 bg-gray-800">
                <h1 class="font-bold text-[30px] text-white">Admin Paneli</h1>
            </div>
            <div class="d-flex">
                <nav class="d-flex flex-column w-64 text-white bg-gray-800 flex-shrink-0" style="min-height: calc(100vh - 56px - 84px);">
                    <ul class="flex-grow-1 px-4 space-y-3">
                        <li>
                            <button class="toggleButton d-block p-3 rounded hover:bg-gray-700 active:bg-gray-600 sidebar-button" 
                                    style="width: 100%; text-align: left; border: none; color: white; cursor: pointer;">
                                SEO Ayarları
                            </button>
                            <ul class="contentList px-3 space-y-3" style="max-height: 0; overflow: hidden; transition: max-height 0.5s ease;">
                                <li><a href="/admin/sayfa" class="d-block p-3 mt-2 rounded <?= $currentPath === '/admin/sayfa' ? 'bg-gray-600 hover:bg-gray-600' : 'hover:bg-gray-700 active:bg-gray-600' ?> sidebar-button">Sayfa SEO Ayarları</a></li>
                                <li><a href="/admin/meta" class="d-block p-3 rounded <?= $currentPath === '/admin/meta' ? 'bg-gray-600 hover:bg-gray-600' : 'hover:bg-gray-700 active:bg-gray-600' ?> sidebar-button">Meta SEO Ayarları</a></li>
                                <li><a href="/admin/twitter" class="d-block p-3 rounded <?= $currentPath === '/admin/twitter' ? 'bg-gray-600 hover:bg-gray-600' : 'hover:bg-gray-700 active:bg-gray-600' ?> sidebar-button">Twitter SEO Ayarları</a></li>
                            </ul>
                            <button class="d-block p-3 mt-2 rounded <?= $currentPath === '/admin/sosyalmedya' ? 'bg-gray-600 hover:bg-gray-600' : 'hover:bg-gray-700 active:bg-gray-600' ?> sidebar-button" 
                                    style="width: 100%; text-align: left; border: none; color: white; cursor: pointer;" onclick="window.location.href='/admin/sosyalmedya'">
                                Sosyal Medya Linkleri
                            </button>
                            <button class="d-block p-3 mt-2 rounded <?= $currentPath === '/admin/hizmetler' ? 'bg-gray-600 hover:bg-gray-600' : 'hover:bg-gray-700 active:bg-gray-600' ?> sidebar-button" 
                                    style="width: 100%; text-align: left; border: none; color: white; cursor: pointer;" onclick="window.location.href='/admin/hizmetler'">
                                Hizmetler
                            </button>
                            <button class="d-block p-3 mt-2 rounded <?= $currentPath === '/admin/iletisim' ? 'bg-gray-600 hover:bg-gray-600' : 'hover:bg-gray-700 active:bg-gray-600' ?> sidebar-button" 
                                    style="width: 100%; text-align: left; border: none; color: white; cursor: pointer;" onclick="window.location.href='/admin/iletisim'">
                                İletişim Mesajları
                            </button>
                        </li>
                    </ul>
                </nav>
                <main class="container-fluid">
                    <?php
                        switch($currentPath)
                        {
                            case '/admin':
                            case '/admin/':
                                break;
                            case '/admin/sayfa':
                                include 'seosite.php';
                                break;
                            case '/admin/meta':
                                include 'seometa.php';
                                break;
                            case '/admin/twitter':
                                include 'seotwitter.php';
                                break;
                            case '/admin/sosyalmedya':
                                include 'sosyal.php';
                                break;
                            case '/admin/hakkinda':
                                include 'hakkinda.php';
                                break;
                            case '/admin/hizmetler':
                                include 'hizmetler.php';
                                break;
                            case '/admin/iletisim':
                                include 'iletisim.php';
                                break;
                        }
                    ?>
                </main>
            </div>
        </header>
            
        <footer class="text-center text-white py-3 bg-gray-800">
            <div>
                <p class="mb-0">© 2025 Tüm hakları saklıdır.</p>
            </div>
        </footer>
    </body>
</html>
<script>
    const toggleButtons = document.querySelectorAll(".toggleButton");
    toggleButtons.forEach(button => {
        button.addEventListener("click", function () {
            const contentList = this.nextElementSibling;
            if (contentList.style.maxHeight === "0px" || contentList.style.maxHeight === "") {
                contentList.style.maxHeight = contentList.scrollHeight + "px";
                button.classList.toggle("bg-gray-700");
            } else {
                contentList.style.maxHeight = "0px";
                button.classList.toggle("bg-gray-700");
            }
        });
    });
</script>
<?php endif; ?>