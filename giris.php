<?php
    if(isset($_SESSION['user_id']))
    {
        header("Location: /");
        exit();
    }
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $kullanici = $database->select("* FROM kullanicilar WHERE eposta = '$email' AND sifre = '$password'",true);
        if ($kullanici)
        {
            header("Location: /");
            exit();
        }
        else
        {
            echo "<script>alert('Giriş bilgileri geçersiz!');</script>";
        }
    }
?>
<main>
    <div class="col-12 d-flex justify-content-center align-items-center mb-4" style="height: 50px;">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="customSwitch">
            <label id="switchLabel" class="form-check-label ms-2" for="customSwitch">Giriş Yap</label>
        </div>
    </div>

    <div class="col-xs-12 p-4 border-3 border-blue-300 rounded-xl bg-gray-300" style="max-width: 500px; margin-left: auto; margin-right: auto;">
        <div id="login-form">
            <h2 class="text-[25px] font-bold text-center mb-4">Giriş Yap</h2>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-Posta</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" class="form-control" id="password" name="password" minlength="8" maxlength="20" required>
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Giriş Yap</button>
                    <a href="/yenisifre" class="btn btn-secondary">Şifremi Unuttum</a>
                </div>
            </form>
        </div>
        <div id="signup-form" style="display: none;">
            <h2 class="text-[25px] font-bold text-center mb-4">Üye Ol</h2>
            <form action="ajax/kayit.php" method="POST">
                <div class="mb-3">
                    <label for="ad" class="form-label">Ad Soyad</label>
                    <input type="text" class="form-control" id="ad_soyad" name="ad_soyad" placeholder="Organizasyon yetkilisinin adı ve soyadı" required>
                </div>
                <div class="mb-3">
                    <label for="soyad" class="form-label">Organizasyon Adı</label>
                    <input type="text" class="form-control" id="organizasyon_ad" name="organizasyon_ad" placeholder="Organizasyonun adı" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-Posta</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="ornek123@mail.com" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" class="form-control" id="password_signup" name="password_signup" minlength="8" maxlength="20" placeholder="8-20 karakter arası bir şifre girin" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Şifreyi Onaylayın</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" minlength="8" maxlength="20" placeholder="Şifrenizi tekrar girin" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Kayıt Ol</button>
                </div>
            </form>
            <script>
                document.getElementById('signup-form').addEventListener('submit', function(event) {
                    const password = document.getElementById('password_signup').value;
                    const passwordConfirm = document.getElementById('password_confirm').value;
                    if (password !== passwordConfirm) {
                        event.preventDefault();
                        alert('Şifreler uyuşmuyor!');
                    }
                });
            </script>
        </div>
    </div>
</main>
<script>
    const checkbox = document.getElementById('customSwitch');
    const label = document.getElementById('switchLabel');
    const loginForm = document.getElementById("login-form");
    const signupForm = document.getElementById("signup-form");

    checkbox.addEventListener('change', function()
    {
        if (this.checked)
        {
            label.textContent = 'Kayıt Ol';
            loginForm.style.display = "none";
            signupForm.style.display = "block";
        }
        else
        {
            label.textContent = 'Giriş Yap';
            loginForm.style.display = "block";
            signupForm.style.display = "none";
        }
    });
</script>