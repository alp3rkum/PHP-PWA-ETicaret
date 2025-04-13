<?php
$seo_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $twitter_card = $_POST['twitter_card'] ?? '';
    $twitter_title = $_POST['twitter_title'] ?? '';
    $twitter_description = $_POST['twitter_description'] ?? '';
    $twitter_site = $_POST['twitter_site'] ?? '';

    $twitter_image_path = null;

    if (isset($_FILES['twitter_image']) && $_FILES['twitter_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/twitter/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uploadFile = $uploadDir . 'twitter_image.png';

        if (move_uploaded_file($_FILES['twitter_image']['tmp_name'], $uploadFile)) {
            echo '<script>alert("Twitter Görseli başarıyla yüklendi.");</script>';
            $twitter_image_path = $uploadFile;
        } else {
            echo '<script>alert("Twitter Görseli yükleme sırasında bir hata oluştu.");</script>';
        }
    }

    $queries = [
        'twitter:card' => $twitter_card,
        'twitter:title' => $twitter_title,
        'twitter:description' => $twitter_description,
        'twitter:site' => $twitter_site
    ];

    if ($twitter_image_path !== null) {
        $queries['twitter:image'] = $twitter_image_path;
    }

    try {
        foreach ($queries as $key => $value) {
            $database->update('global_vars', ['var_value' => $value], "var_key = '$key'");
        }
        echo '<script>alert("Twitter SEO ayarları başarıyla güncellendi.");</script>';
    } catch (Exception $e) {
        error_log("Twitter SEO güncellemesi sırasında hata: " . $e->getMessage());
        echo '<script>alert("Twitter SEO ayarları güncellenemedi. Lütfen tekrar deneyin.");</script>';
    }
}

$keys = ['twitter:card', 'twitter:title', 'twitter:description', 'twitter:image', 'twitter:site'];

try {
    $placeholders = "'" . implode("','", $keys) . "'";
    $seo_data_raw = $database->select("var_key, var_value FROM global_vars WHERE var_key IN ($placeholders)", false);
    $seo_data = array_column($seo_data_raw, 'var_value', 'var_key');
} catch (Exception $e) {
    error_log("Twitter bilgileri alınırken hata: " . $e->getMessage());
    echo '<script>alert("Twitter bilgileri alınırken bir hata oluştu.");</script>';
}
?>

<main class="row">
    <form action="" method="POST" enctype="multipart/form-data">
        <section class="col-xs-12 p-4 text-center">
            <h2 class="text-[25px] font-bold mb-3">Twitter SEO Ayarları</h2>
            <p>Bu alanda sitenizin Twitter SEO ayarlarını yapabilirsiniz.</p>
        </section>
        <section class="text-center">
            <div style="max-width: 500px; margin-left: auto; margin-right: auto;">
                <label for="twitter_card" class="font-bold mt-3">Twitter Kart Tipi</label>
                <select id="twitter_card" name="twitter_card" class="form-control">
                    <option value="summary" <?= $seo_data['twitter:card'] == 'summary' ? 'selected' : '' ?>>Özet Kart</option>
                    <option value="summary_large_image" <?= $seo_data['twitter:card'] == 'summary_large_image' ? 'selected' : '' ?>>Büyük Görsel Kart</option>
                    <option value="app" <?= $seo_data['twitter:card'] == 'app' ? 'selected' : '' ?>>Uygulama Kartı</option>
                </select>

                <label for="twitter_title" class="font-bold mt-3">Twitter Başlık</label>
                <input type="text" id="twitter_title" name="twitter_title" class="form-control" value="<?= $seo_data['twitter:title'] ?>" required>

                <label for="twitter_description" class="font-bold mt-3">Twitter Açıklama</label>
                <input type="text" id="twitter_description" name="twitter_description" maxlength="200" value="<?= $seo_data['twitter:description'] ?>" class="form-control" required>

                <label for="twitter_image" class="font-bold mt-3">Twitter Görseli</label>
                <input type="file" id="twitter_image" name="twitter_image" accept="image/*" class="form-control" onchange="previewTwitterImage(event)">
                <img src="<?= $seo_data['twitter:image'] ?>" id="twitter-image-preview" class="d-block mt-3" style="max-width: 100%;">

                <label for="twitter_site" class="font-bold mt-3">Twitter Kullanıcı Adı</label>
                <input type="text" id="twitter_site" name="twitter_site" class="form-control" placeholder="@kullaniciadi" value="<?= $seo_data['twitter:site'] ?>" required>

                <button type="submit" class="btn btn-success mt-3 mb-3">Kaydet</button>
            </div>
        </section>
    </form>
</main>
<script>
    function previewTwitterImage(event) {
    const input = event.target;
    const file = input.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const previewImage = document.getElementById('twitter-image-preview');
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }
}

</script>