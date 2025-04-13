<?php
 if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
    $userId = $_POST['userId'];
    $yeniSifre = isset($_POST['yenisifre1']) ? $_POST['yenisifre1'] : '';

    $data = [
        'sifre' => md5($yeniSifre)
    ];
    $where = "id = '$userId'";
    try
    {
        $database->update("kullanicilar",$data,$where);
        echo "Şifre güncellendi.";
    }
    catch(Exception $e)
    {
        echo "Bir hata oluştu: " . $e->getMessage();
    }
 }
?>