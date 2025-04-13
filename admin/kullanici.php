<?php
$kullanici_veri = $database->select("* FROM kullanicilar");
$kullanicilar = [];
foreach ($kullanici_veri as $kullanici) {
    $kullanicilar[$kullanici['id']] = $kullanici;
}
?>
<main class="row">
    <div class="col-xs-12 p-4 text-center">
        <h2 class="text-[25px] font-bold mb-3">Aktif Kullanıcılar</h2>
        <p>Bu sayfada aktif kullanıcılar üzerinde inceleme ve gerekli işlemleri yapabilirsiniz.</p>
    </div>
    <div>
        <div class="row" style="max-width: 400px; margin-left: auto; margin-right: auto;">
            <div class="col-xs-12 p-4 text-center">
                <h3 class="text-[20px] font-bold mb-3">Aktif Kullanıcılar</h3>
                <div id="pending-users">
                    <select name="users" id="users" class="form-control" onchange="showPendingUserInfo()">
                        <option value="0">Seçiniz</option>
                        <?php
                        foreach ($kullanicilar as $id => $kullanici) {
                            echo '<option value="' . $id . '">' . $kullanici[''] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 p-4 text-center" style="max-width: 400px; margin-left: auto; margin-right: auto;">
        <h3 class="text-[20px] font-bold mb-3">Seçilen Kullanıcı Bilgileri</h3>
        <form id="user-info-form">
            <input type="hidden" id="user_id" name="user_id">
            <div class="form-group">
                <label for="" class="control-label mt-3"></label>
                <div>
                    <input type="text" class="form-control" id="" name="" readonly>
                </div>
            </div>

            <div id="buttons-container" class="form-group mt-4">
            
            </div>
        </form>
    </div>
</main>
<script>
    const users = <?php echo json_encode($kullanicilar); ?>;
    function showUserInfo()
    {
        const select = document.getElementById("users");
        const userId = select.value;

        if (userId != "0") {
            const user = activeUsers[userId];
            document.getElementById("user_id").value = user.id;
            //document.getElementById("").value = user.;

            const buttonsContainer = document.getElementById("buttons-container");
            buttonsContainer.innerHTML = `
            <button type="button" class="btn btn-danger" onclick="deleteUser(${userId})">Kaydı Sil</button>
            `;
        }
        else
        {
            document.getElementById("buttons-container").innerHTML = '';
        }
    }

    function deleteUser(userId)
    {
        if (!confirm("Bu kaydı silmek istediğinizden emin misiniz?")) {
            return;
        }
        //silme işlemi buraya yazılır
    }
</script>