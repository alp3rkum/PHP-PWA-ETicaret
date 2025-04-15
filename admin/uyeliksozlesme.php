<?php
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $data = [
        "icerik" => $_POST["icerik"]
    ];
    try
    {
        $database->update("global_vars", $data, "var_key = 'uyelik_sozlesmesi'");
        echo "<script>alert('Hakkında İçeriği başarıyla güncellendi!')</script>";
    }
    catch (Exception $e)
    {
        echo "<script>alert('Hata: " . $e->getMessage() . "')</script>";
    }
}
$icerik = $database->select("var_value FROM global_vars WHERE var_key = 'uyelik_sozlesmesi'", true)['var_value'];
?>
<main>
    <form action="" method="POST">
        <section class="col-xs-12 p-4 text-center">
            <h2 class="text-[25px] font-bold mb-3">Üyelik Sözleşmesi İçeriği</h2>
            <p>Bu alanda sitenizin "Üyelik Sözleşmesi" sayfasında yer alacak olan içeriği girebilirsiniz.</p>
        </section>
        <section class="text-center">
            <textarea id="editor" name="icerik" novalidate><?= $icerik ?></textarea>
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