<?php
$seo_data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $og_title = $_POST['og_title'] ?? '';
    $og_description = $_POST['og_description'] ?? '';
    $og_url = $_POST['og_url'] ?? '';
    $og_type = $_POST['og_type'] ?? '';
    $og_site_name = $_POST['og_site_name'] ?? '';

    $og_image_path = null;

    if (isset($_FILES['og_image']) && $_FILES['og_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/seo/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uploadFile = $uploadDir . 'og_image.png';

        if (move_uploaded_file($_FILES['og_image']['tmp_name'], $uploadFile)) {
            echo '<script>alert("OG:Image başarıyla yüklendi.");</script>';
            $og_image_path = $uploadFile;
        } else {
            echo '<script>alert("OG:Image yükleme sırasında bir hata oluştu.");</script>';
        }
    }

    $queries = [
        'og:title' => $og_title,
        'og:description' => $og_description,
        'og:url' => $og_url,
        'og:type' => $og_type,
        'og:site_name' => $og_site_name
    ];

    if ($og_image_path !== null) {
        $queries['og:image'] = $og_image_path;
    }

    try {
        foreach ($queries as $key => $value) {
            $database->update('global_vars', ['var_value' => $value], "var_key = '$key'");
        }
        echo '<script>alert("Open Graph ayarları başarıyla güncellendi.");</script>';
    } catch (Exception $e) {
        error_log("Open Graph ayarları güncellemesi sırasında hata: " . $e->getMessage());
        echo '<script>alert("Open Graph ayarları güncellenemedi. Lütfen tekrar deneyin.");</script>';
    }
}

$keys = ['og:title', 'og:description', 'og:image', 'og:url', 'og:type', 'og:site_name'];

try {
    $placeholders = "'" . implode("','", $keys) . "'";
    $seo_data_raw = $database->select("var_key, var_value FROM global_vars WHERE var_key IN ($placeholders)", false);
    $seo_data = array_column($seo_data_raw, 'var_value', 'var_key');
} catch (Exception $e) {
    error_log("Veriler alınırken hata: " . $e->getMessage());
    echo '<script>alert("Veriler alınırken bir hata oluştu.");</script>';
}
?>


<main class="row">
    <form action="" method="POST" enctype="multipart/form-data">
        <section class="col-xs-12 p-4 text-center">
            <h2 class="text-[25px] font-bold mb-3">Sayfa SEO Ayarları</h2>
            <p>Bu alanda sitenizin genel SEO ayarlarını yapabilirsiniz.</p>
        </section>
        <section class="text-center">
            <div style="max-width: 500px; margin-left: auto; margin-right: auto;">
                <label for="og_title" class="font-bold mt-3">OG Meta Başlık</label>
                <input type="text" id="og_title" name="og_title" class="form-control" value="<?= $seo_data['og:title'] ?>" required>

                <label for="og_description" class="font-bold mt-3">OG Meta Site Açıklaması</label>
                <input type="text" id="og_description" name="og_description" maxlength="200" value="<?= $seo_data['og:description'] ?>" class="form-control" required>

                <label for="og_url" class="font-bold mt-3">OG Meta Site URL</label>
                <input type="url" id="og_url" name="og_url" class="form-control" value="<?= $seo_data['og:url'] ?>" required>

                <label for="og_image" class="font-bold mt-3">OG Meta Site Resmi</label>
                <input type="file" id="og_image" name="og_image" accept="image/*" class="form-control" value="<?= $seo_data['og:image'] ?>" onchange="previewOGImage(event)">
                <img src="<?= $seo_data['og:image'] ?>" id="og-image-preview" class="d-block mt-3" style="max-width: 100%;">

                <label for="og_type" class="font-bold mt-3">OG Meta Site Tipi</label>
                <select id="og_type" name="og_type" class="form-control">
                    <option value="website" <?= $seo_data['og:type'] == 'website' ? 'selected' : '' ?>>Website</option>
                    <option value="article" <?= $seo_data['og:type'] == 'article' ? 'selected' : '' ?>>Makale</option>
                    <option value="product" <?= $seo_data['og:type'] == 'product' ? 'selected' : '' ?>>Ürün</option>
                </select>

                <label for="og_site_name" class="font-bold mt-3">OG Meta Site Adı</label>
                <input type="text" id="og_site_name" name="og_site_name" class="form-control" value="<?= $seo_data['og:site_name'] ?>" required>

                <button type="submit" class="btn btn-success mt-3 mb-3">Kaydet</button>
            </div>
        </section>
    </form>
</main>
<script>
    function previewOGImage(event) {
    const input = event.target;

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const previewImage = document.getElementById('og-image-preview');
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>