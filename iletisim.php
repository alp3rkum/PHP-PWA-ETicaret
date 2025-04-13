<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $first_name = $_POST['first-name'];
        $last_name = $_POST['last-name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        //geri kalan kısım buraya yazılır
    }
?>
<main>
    <div class="container text-center mt-10">
        <h2 class="text-[30px] font-bold mb-4 mt-3">Bizimle İletişime Geçin</h2>
        <p class="mb-3">QR Fotoğraf Albümü Sistemi konusunda aklınıza takılan bir soru, bir öneri veya başka bir şey varsa bizimle aşağıdaki mesaj formunu doldurarak iletişime geçebilirsiniz. Gösterdiğiniz ilgi için teşekkür ederiz.</p>

        <form class="p-3" method="POST">
            <div class="row">
                <div class="col-sm-12 col-lg-6 col-xl-4 mb-3">
                    <label for="first-name" class="block text-sm font-bold mb-2">Adınız</label>
                    <input type="text" id="first-name" name="first-name" placeholder="Adınız" class="w-full px-3 py-2 border rounded-lg focus:outline-none">
                </div>
                <div class="col-sm-12 col-lg-6 col-xl-4 mb-3">
                    <label for="last-name" class="block text-sm font-bold mb-2">Soyadınız</label>
                    <input type="text" id="last-name" name="last-name" placeholder="Soyadınız"class="w-full px-3 py-2 border rounded-lg focus:outline-none">
                </div>
                <div class="col-lg-12 col-xl-4 mb-3">
                    <label for="email" class="block text-sm font-bold mb-2">E-Posta Adresiniz</label>
                    <input type="email" id="email" name="email" placeholder="E-Posta Adresiniz" class="w-full px-3 py-2 border rounded-lg focus:outline-none">
                </div>
                <div class="col-sm-12 mb-3">
                    <label for="message" class="block text-sm font-bold mb-2">Mesajınız</label>
                    <textarea id="message" name="message" placeholder="Mesajınız"class="w-full px-3 py-2 border rounded-lg focus:outline-none"></textarea>
                </div>
                <div class="col-sm-12">
                    <button type="submit" class="w-300 btn">
                        Mesaj Gönder
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>