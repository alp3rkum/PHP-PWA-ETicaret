<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'about_info' => $_POST['about_info'],
        'facebook_link' => $_POST['facebook_link'],
        'instagram_link' => $_POST['instagram_link'],
        'twitter_link' => $_POST['twitter_link'],
        'youtube_link' => $_POST['youtube_link'],
        'linkedin_link' => $_POST['linkedin_link'],
        'tiktok_link' => $_POST['tiktok_link']
    ];

    try {
        foreach ($data as $var_key => $var_value) {
            // Her var_key için güncelleme işlemi
            $where = "var_key = ?";
            $update_data = ['var_value' => $var_value];

            try
            {
                $database->update("global_vars", $update_data, $where, [$var_key]);
                echo "<script>alert('Sosyal Medya linkleri başarıyla güncellendi!')</script>";
            }
            catch(Exception $e)
            {
                echo "<script>alert('Hata: " . $e->getMessage() . "')</script>";
            }
        }

        echo "<script>alert('Başarıyla güncellendi!');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Güncelleme başarısız oldu: " . $e->getMessage() . "');</script>";
    }
}
?>
<main class="row">
    <section class="col-xs-12 p-4 text-center">
        <h2 class="text-[25px] font-bold mb-3">Sosyal Medya Bağlantıları</h2>
        <p>Sitenizin/firmanızın sosyal medya bağlantılarını buradan belirleyebilirsiniz.</p>
    </section>
    <form action="" method="POST">
        <section class="p-4">
            <h3 class="font-bold">Sosyal Medya Bağlantıları</h3>

            <label for="facebook_link" class="mt-3 font-bold"><i class="bi bi-facebook"></i> Facebook</label>
            <input type="url" id="facebook_link" name="facebook_link" class="form-control" placeholder="Facebook bağlantısını girin" value="<?= htmlspecialchars($data['facebook_link'] ?? '') ?>" required>

            <label for="instagram_link" class="mt-3 font-bold"><i class="bi bi-instagram"></i> Instagram</label>
            <input type="url" id="instagram_link" name="instagram_link" class="form-control" placeholder="Instagram bağlantısını girin" value="<?= htmlspecialchars($data['instagram_link'] ?? '') ?>" required>

            <label for="twitter_link" class="mt-3 font-bold"><i class="bi bi-twitter"></i> Twitter</label>
            <input type="url" id="twitter_link" name="twitter_link" class="form-control" placeholder="Twitter bağlantısını girin" value="<?= htmlspecialchars($data['twitter_link'] ?? '') ?>" required>

            <label for="youtube_link" class="mt-3 font-bold"><i class="bi bi-youtube"></i> YouTube</label>
            <input type="url" id="youtube_link" name="youtube_link" class="form-control" placeholder="YouTube bağlantısını girin" value="<?= htmlspecialchars($data['youtube_link'] ?? '') ?>" required>

            <label for="linkedin_link" class="mt-3 font-bold"><i class="bi bi-linkedin"></i> LinkedIn</label>
            <input type="url" id="linkedin_link" name="linkedin_link" class="form-control" placeholder="LinkedIn bağlantısını girin" value="<?= htmlspecialchars($data['linkedin_link'] ?? '') ?>" required>

            <label for="tiktok_link" class="mt-3 font-bold"><i class="bi bi-tiktok"></i> TikTok</label>
            <input type="url" id="tiktok_link" name="tiktok_link" class="form-control" placeholder="TikTok bağlantısını girin" value="<?= htmlspecialchars($data['tiktok_link'] ?? '') ?>" required>
        </section>
        <section class="text-center p-4">
            <button type="submit" class="btn btn-success mt-3">Değişiklikleri Kaydet</button>
        </section>
    </form>
</main>