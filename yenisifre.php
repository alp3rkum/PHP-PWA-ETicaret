<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        $email = $_POST['email'];
        $eposta = $database->select("eposta FROM kullanicilar WHERE eposta = $email");

        if ($eposta)
        {
            $data = [
                'sifre' => md5(substr(md5(rand()), 0, rand(8,20)))
            ];
            $where = "eposta = '$email'";
            $affectedRows = $database->update('kullanicilar', $data, $where);

            sendPasswordEmail($email, $newPass);
            echo "<script>alert('Yeni şifreniz e-posta adresinize gönderilmiştir. Bu şifreyle giriş yaptıktan sonra Kullanıcı Paneli'nden hesap şifrenizi değiştirebilirsiniz.');</script>";
        }
        else
        {
            echo "<script>alert('Girilen e-posta adresi bulunamadı.');</script>";
        }
    }

    function sendPasswordEmail($toEmail, $newPass) {
        //fonksiyon içeriği buraya girilir
    }
?>
<main>
    <div class="col-xs-12 p-4 border-3 border-blue-300 rounded-xl bg-gray-300 text-center" style="max-width: 500px; margin-left: auto; margin-right: auto;">
        <h2 class="text-[25px] font-bold text-center mb-4">Şifremi Unuttum</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="email" class="control-label">E-posta:</label>
                <div>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Şifre yenileme bağlantısı almak için e-posta giriniz" required>
                </div>
            </div>
            <button type="submit" class="btn mt-3">Yeni Şifre Al</button>
        </form>
    </div>
</main>