<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $sifre = md5($_POST['sifre']);
        $data = ["admin_sifre" => $sifre];
        $database->update("adminler",$data,"id = 1");
    }
    $admin = $database->select("admin_adi, admin_sifre FROM adminler WHERE id = 1",true);
?>
<main class="row">
    <section class="col-xs-12 p-4 text-center">
        <h2 class="text-[25px] font-bold mb-3">Admin</h2>
        <p>Bu sayfada mevcut admin hesabı üzerinde düzenleme yapabilirsiniz.</p>
    </section>
    <section class="col-xs-12 p-4 text-center" style="max-width: 400px; margin-left: auto; margin-right: auto;">
        <h3 class="text-[20px] font-bold mb-3">Admin Bilgileri</h3>
        <form id="user-info-form">           
            <div class="form-group">
                <label for="ad" class="control-label">Admin Adı:</label>
                <div>
                    <input type="text" class="form-control" id="ad" name="ad" value="<?=$admin['admin_adi']?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="sehir" class="control-label">Yeni Şifre:</label>
                <div>
                    <input type="text" class="form-control" id="sifre" name="sifre">
                </div>
            </div>

            <div id="buttons-container" class="form-group mt-4">
            
            </div>
        </form>

    </section>
</main>