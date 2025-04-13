<?php
require_once 'functions/paytr.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $buyer_data = [
        "email" => $_POST["email_address"],
        "name_surname" => $_POST["full_name"],
        "address" => $_POST["address"],
        "phone" => $_POST["phone_number"],
        "ip" => $_POST["ip_address"]
    ];

    $products = [
        [
            "name" => $_POST[""],
            "price" => floatval($_POST[""]),
            "quantity" => 1
        ],
        // Diğer ürünleri buraya ekle
    ];

    paymentForm($buyer_data, $products);
}
?>