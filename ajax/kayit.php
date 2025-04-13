<?php
    require '../functions/db.php';

    $password_md5 = md5($password);

    $varmi = $database->select("COUNT(*) FROM kullanicilar WHERE ");
    if($varmi)
    {
        echo 'Bu organizasyon/eposta zaten kayıtlı.';
    }
    else
    {
        $data = [
            //'sutun' => $veri
        ];
        $database->insert("kullanicilar",$data);
        echo "Kayıt başarılı!";
        header("Location:/");
    }

    function sendWelcomeEmail($toEmail/*, $param*/) {
        //fonksiyon içeriği buraya girilir
    }
?>