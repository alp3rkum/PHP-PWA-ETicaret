<?php
$seo_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_baslik = isset($_POST['site_baslik']) ? trim($_POST['site_baslik']) : '';
    $site_aciklama = isset($_POST['site_aciklama']) ? trim($_POST['site_aciklama']) : '';
    $site_keywords = isset($_POST['site_keywords']) ? trim($_POST['site_keywords']) : '';
    $robots_txt = isset($_POST['robots_txt']) ? trim($_POST['robots_txt']) : '';
    $google_analytics = isset($_POST['google_analytics']) ? trim($_POST['google_analytics']) : '';
    $google_search = isset($_POST['google_search']) ? trim($_POST['google_search']) : '';

    $queries = [
        'site_baslik' => $site_baslik,
        'site_aciklama' => $site_aciklama,
        'site_keywords' => $site_keywords,
        'robots_txt' => $robots_txt,
        'google_analytics' => $google_analytics,
        'google_search' => $google_search,
    ];

    try {
        foreach ($queries as $key => $value) {
            $database->update('global_vars', ['var_value' => $value], "var_key = '$key'");
        }

        if (!empty($robots_txt)) {
            $file = fopen('../../robots.txt', 'w');
            fwrite($file, $robots_txt);
            fclose($file);
        }

        echo '<script>alert("SEO ayarları başarıyla güncellendi.");</script>';
    } catch (Exception $e) {
        echo '<script>alert("SEO ayarları güncellemesinde hata oluştu. Hata: ' . $e->getMessage() . '");</script>';
        error_log("SEO ayarları güncellemesi sırasında hata: " . $e->getMessage());
    }

    if (isset($_FILES['site_favicon']) && $_FILES['site_favicon']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/';
        $uploadFile = $uploadDir . 'favicon.ico';

        if (move_uploaded_file($_FILES['site_favicon']['tmp_name'], $uploadFile)) {
            echo '<script>alert("Favicon başarıyla yüklendi.");</script>';
        } else {
            echo '<script>alert("Favicon yükleme sırasında bir hata oluştu.");</script>';
        }
    } else {
        echo '<script>alert("Favicon için bir dosya yüklenmedi.");</script>';
    }
}

$keys = ['site_baslik', 'site_aciklama', 'site_keywords', 'robots_txt', 'google_analytics', 'google_search'];

try {
    $placeholders = "'" . implode("','", $keys) . "'";
    $seo_data_raw = $database->select("var_key, var_value FROM global_vars WHERE var_key IN ($placeholders)", false);
    $seo_data = array_column($seo_data_raw, 'var_value', 'var_key');

    $file_path = '../../robots.txt';
    $seo_data['robots_txt'] = file_exists($file_path) ? file_get_contents($file_path) : '';
} catch (Exception $e) {
    echo '<script>alert("Veriler alınırken bir hata oluştu: ' . $e->getMessage() . '");</script>';
}

$faviconPath = '../assets/favicon.ico';
$faviconExists = file_exists($faviconPath) ? $faviconPath : 'empty.png';
?>
<main class="row">
    <form action="" method="POST" enctype="multipart/form-data">
        <section class="col-xs-12 p-4 text-center">
            <h2 class="text-[25px] font-bold mb-3">Sayfa SEO Ayarları</h2>
            <p>Bu alanda sitenizin genel SEO ayarlarını yapabilirsiniz.</p>
        </section>
        <section class="text-center">
            <div style="max-width: 500px; margin-left: auto; margin-right: auto;">
                    <label for="site_baslik" class="font-bold mt-3">Site Başlığı</label>
                    <input type="text" id="site_baslik" name="site_baslik" class="form-control" value="<?= $seo_data['site_baslik'] ?>" required>

                    <label for="site_aciklama" class="font-bold mt-3">Site Açıklaması</label>
                    <input type="text" id="site_aciklama" name="site_aciklama" maxlength="160" value="<?= $seo_data['site_aciklama'] ?>" class="form-control" required>

                    <label for="site_keywords" class="font-bold mt-3">Site Anahtar Kelimeleri</label>
                    <input type="text" id="site_keywords" name="site_keywords" maxlength="160" class="form-control" value="<?= $seo_data['site_keywords'] ?>" required>
            
                    <label for="robots_txt">Robots.txt</label><br>
                    <textarea id="robots_txt" name="robots_txt" class="form-control"></textarea>

                    <label for="google_analytics">Google Analytics Kodu</label>
                    <input type="text" id="google_analytics" name="google_analytics" class="form-control" value="<?= $seo_data['google_analytics'] ?>">

                    <label for="google_search">Google Search Console Kodu</label>
                    <input type="text" id="google_search" name="google_search" class="form-control" value="<?= $seo_data['google_search'] ?>">

                    <label for="sitemap" class="mb-2">Sitemap.xml</label><br>
                    <button id="sitemap" class="btn btn-primary">Sitemap Oluştur</button>
                    <h3 class="mt-3 mb-3">Sosyal Medya Linkleri</h3>

                    <div class="row align-items-center">
                        <div class="col-sm-12 col-xl-6 d-flex justify-content-center">
                        <img src="<?= $faviconExists ?>" id="initial-img-preview" class="d-block mt-3">
                        </div>
                        <div class="col-sm-12 col-xl-6 d-flex flex-column justify-content-center">
                            <label for="site_favicon" class="font-bold mt-2">Favicon.ico Dosyası</label>
                            <input type="file" accept="image/*,.ico" id="site_favicon" name="site_favicon" onchange="previewInitialImage(event)">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Kaydet</button>
                    
            </div>
            
        </section>
    </form>
</main>
<script>
    function previewInitialImage(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function(){
            const img = document.getElementById('initial-img-preview');
            img.src = reader.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
<script>
document.querySelector("#sitemap").addEventListener("click", function() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "ajax/sitemap.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var blob = new Blob([xhr.responseText], { type: "application/xml" });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement("a");
            a.style.display = "none";
            a.href = url;
            a.download = "sitemap.xml";
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            alert("Sitemap başarıyla oluşturuldu ve indirildi!");
        }
    };
    xhr.send();
});
</script>