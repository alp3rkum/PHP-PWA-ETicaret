<?php
$conn = new mysqli('localhost:3307', 'root', '', 'qrdugun');
$conn->set_charset('utf8mb4');
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Veritabanı bağlantısı başarısız.']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $resim_baslik = $_POST['resim_baslik'] ?? '';
    $resim_aciklama = $_POST['resim_aciklama'] ?? '';
    $resim_yolu = null;

    // Yeni görsel yüklenmişse işle
    if (isset($_FILES['slider_image']) && $_FILES['slider_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/slider/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uploadFile = $uploadDir . time() . '_' . basename($_FILES['slider_image']['name']);

        if (move_uploaded_file($_FILES['slider_image']['tmp_name'], $uploadFile)) {
            $resim_yolu = $uploadFile;
        } else {
            echo json_encode(['success' => false, 'message' => 'Görsel yüklenirken hata oluştu.']);
            exit;
        }
    }

    // Veritabanında güncelleme yap
    $sql = "UPDATE sliders SET baslik = ?, aciklama = ?";
    if ($resim_yolu) {
        $sql .= ", resim_yolu = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $resim_baslik, $resim_aciklama, $resim_yolu, $id);
    } else {
        $sql .= " WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $resim_baslik, $resim_aciklama, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Veritabanı güncellemesi başarısız.']);
    }

    $stmt->close();
}

$conn->close();
?>