<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $data = [
        "hakkinda_icerik" => $_POST["hakkinda_icerik"]
    ];
    try
    {
        $database->update("global_vars", $data, "var_key = 'hakkinda_icerik'");
        echo "<script>alert('Hakkında İçeriği başarıyla güncellendi!')</script>";
    }
    catch (Exception $e)
    {
        echo "<script>alert('Hata: " . $e->getMessage() . "')</script>";
    }
    
}
$hakkinda_icerik = $database->select("var_value FROM global_vars WHERE var_key = 'hakkinda_icerik'", true);
?>
<main>
    <form action="" method="POST">
        <section class="col-xs-12 p-4 text-center">
            <h2 class="text-[25px] font-bold mb-3">Hakkımızda Sayfası İçeriği</h2>
            <p>Bu alanda sitenizin "Hakkımızda" sayfasında yer alacak olan içeriği girebilirsiniz.</p>
        </section>
        <section class="text-center">
            <textarea id="editor" name="hakkinda_icerik" novalidate><?= $hakkinda_icerik ?></textarea>
        </section>
        <div class="mt-4" style="text-align: center;">
            <button class="btn btn-success">Kaydet</button>
        </div>
    </form>
</main>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>