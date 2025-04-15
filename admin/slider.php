<?php
 if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
    $resim_baslik = $_POST['baslik'] ?? null;
    $resim_aciklama = $_POST['aciklama'] ?? null;
    $slider_image_path = null;

    if (isset($_FILES['slider_image']) && $_FILES['slider_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/slider/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Dizin yoksa oluştur
        }

        $uploadFile = $uploadDir . time() . '_' . basename($_FILES['slider_image']['name']);

        if (move_uploaded_file($_FILES['slider_image']['tmp_name'], $uploadFile)) {
            $slider_image_path = $uploadFile; // Yüklenen dosya yolu
        } else {
            echo '<script>alert("Görsel yükleme sırasında bir hata oluştu.");</script>';
        }
    }

    if ($slider_image_path) {
        // Görsel verilerini veritabanına ekle
        $stmt = $conn->prepare("INSERT INTO sliders (resim_yolu, baslik, aciklama) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $slider_image_path, $resim_baslik, $resim_aciklama);
        if ($stmt->execute()) {
            echo '<script>alert("Slider görseli başarıyla eklendi.");</script>';
        } else {
            echo '<script>alert("Veritabanına kayıt sırasında bir hata oluştu.");</script>';
        }
        $stmt->close();
    }
 }

 $slider_images = $database->select("* FROM sliders ORDER BY created_at DESC");
?>

<main class="row">
    <form action="" method="POST" enctype="multipart/form-data" id="sliderForm">
        <section class="col-xs-12 p-4 text-center">
            <h2 class="text-[25px] font-bold mb-3">Anasayfa Slider Yönetimi</h2>
            <p>Slider görsellerini buradan yükleyebilir, güncelleyebilir ve silebilirsiniz.</p>
        </section>
        <section class="text-center">
            <div style="max-width: 500px; margin-left: auto; margin-right: auto;">
                <input type="hidden" id="slider_id" name="slider_id" value="0">
                <label for="slider_image" class="font-bold mt-3">Slider Görseli</label>
                <input type="file" id="slider_image" name="slider_image" accept="image/*" class="form-control" required onchange="previewSliderImage(event)">

                <img id="slider-image-preview" src="empty.png" alt="Görsel Önizleme" style="display: none; max-width: 100%; margin-top: 15px;">

                <label for="baslik" class="font-bold mt-3">Görsel Başlığı</label>
                <input type="text" id="baslik" name="baslik" class="form-control" placeholder="Başlık" maxlength="200">

                <label for="aciklama" class="font-bold mt-3">Görsel Açıklaması</label>
                <input type="text" id="aciklama" name="aciklama" class="form-control" placeholder="Açıklama" maxlength="255">

                <button type="submit" class="btn btn-success mt-3 mb-3">Görsel Yükle</button>
            </div>
        </section>
    </form>

    <section class="text-center mt-5">
        <h3>Mevcut Slider Görselleri</h3>
        <div class="slider-list" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; padding: 20px;">
            <?php
            // Mevcut slider görsellerini listeleme
            foreach ($slider_images as $slider) {
                echo '<div class="slider-item" id="slider-' . $slider['id'] . '" style="border: 1px solid #ddd; padding: 10px; border-radius: 8px; text-align: center;">';
                echo '<img src="' . $slider['resim_yolu'] . '" style="max-width: 100%; border-radius: 4px; cursor: pointer;" onclick="loadSliderData(' . htmlspecialchars(json_encode($slider), ENT_QUOTES, 'UTF-8') . ')">';
                echo '<h4>' . $slider['baslik'] . '</h4>';
                echo '<p>' . $slider['aciklama'] . '</p>';
                echo '<button class="btn btn-danger mt-2" onclick="deleteSlider(' . $slider['id'] . ')">Sil</button>';
                echo '</div>';
            }
            ?>
        </div>
    </section>
</main>
<script>
    function deleteSlider(sliderId) {
        if (!confirm("Bu slider görselini silmek istediğinizden emin misiniz?")) {
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/slidersil.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                if (response.success) {
                    const sliderElement = document.getElementById("slider-" + sliderId);
                    sliderElement.remove();
                    alert("Slider başarıyla silindi.");
                } else {
                    alert("Slider silinemedi: " + response.message);
                }
            }
        };

        xhr.send("id=" + sliderId);
    }

    function loadSliderData(slider) {
        console.log(slider);
        if (!slider || typeof slider !== 'object') {
            console.error("Geçersiz slider verisi:", slider);
            return;
        }
        document.getElementById('slider_id').value = slider.id;
        document.getElementById('baslik').value = slider.baslik;
        document.getElementById('aciklama').value = slider.aciklama;

        const previewImage = document.getElementById('slider-image-preview');
        previewImage.src = slider.resim_yolu;
        previewImage.style.display = 'block';

        const formSubmitButton = document.querySelector('button[type="submit"]');
        formSubmitButton.textContent = "Görsel Güncelle";
        formSubmitButton.classList.remove('btn-success');
        formSubmitButton.classList.add('btn-primary');

        formSubmitButton.onclick = updateSlider;
    }

    function previewSliderImage(event) {
        const input = event.target;
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = document.getElementById('slider-image-preview');
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    function updateSlider(event) {

event.preventDefault();

const sliderId = document.getElementById('slider_id').value;
const resimBaslik = document.getElementById('baslik').value;
const resimAciklama = document.getElementById('aciklama').value;
const sliderImage = document.getElementById('slider_image').files[0];


const formData = new FormData();
formData.append('id', sliderId);
formData.append('baslik', resimBaslik);
formData.append('aciklama', resimAciklama);
if (sliderImage) {
    formData.append('slider_image', sliderImage);
}

// AJAX isteği gönder
const xhr = new XMLHttpRequest();
xhr.open('POST', 'ajax/sliderguncelle.php', true);

xhr.onload = function() {
    if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
            alert('Slider başarıyla güncellendi!');
            location.reload();
        } else {
            alert('Güncelleme sırasında hata oluştu: ' + response.message);
        }
    } else {
        alert('Sunucu hatası! Güncelleme gerçekleştirilemedi.');
    }
};

xhr.onerror = function() {
    alert('AJAX isteği sırasında bir hata oluştu.');
};

xhr.send(formData);
}
</script>