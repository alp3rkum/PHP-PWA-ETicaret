<?php
require_once __DIR__ . '/../vendor/autoload.php';
    use Dipnot\PayTR\Config;
    use Dipnot\PayTR\Model\Buyer;
    use Dipnot\PayTR\Model\Currency;
    use Dipnot\PayTR\Model\Language;
    use Dipnot\PayTR\Model\Product;
    use Dipnot\PayTR\Request\CreatePaymentFormRequest;
    use Dipnot\PayTR\Response\GetPayment;

    function config()
    {
        $config = new Config();
        $config->setMerchantId("");
        $config->setMerchantKey("");
        $config->setMerchantSalt("");
        $config->setTestMode(false);
		$config->setDebugMode(false);
        return $config;
    }

    function paymentForm($buyer_data,$products)
    {
        
        $buyer = new Buyer();
        $buyer->setEmailAddress($buyer_data["email"]);
        $buyer->setFullName($buyer_data["name_surname"]);
        $buyer->setAddress($buyer_data["address"]);
        $buyer->setPhoneNumber($buyer_data["phone"]);
        $buyer->setIpAddress($_SERVER['REMOTE_ADDR'] === "::1" ? "127.0.0.1" : $_SERVER['REMOTE_ADDR']);
        //$buyer->setIpAddress($buyer_data["ip"]);
        

        $products_array = [];
        $total_price = 0;

        foreach($products as $product)
        {
            $product_to_add = new Product();
            $product_to_add->setTitle($product["name"]);
            $product_to_add->setPrice($product["price"]);
            $product_to_add->setQuantity($product["quantity"]);
            $total_price += $product["price"];
            $products_array[] = $product_to_add;
        }

        $orderId = "UNIQUEORDERCODE" . time();

        $createPaymentFormRequest = new CreatePaymentFormRequest(config());
        $createPaymentFormRequest->setBuyer($buyer);
        $createPaymentFormRequest->setCurrency(Currency::TL);
        $createPaymentFormRequest->setLanguage(Language::TR);
        $createPaymentFormRequest->setAmount($total_price);
        $createPaymentFormRequest->setOrderId($orderId);
        $createPaymentFormRequest->setSuccessUrl("");
        $createPaymentFormRequest->setFailedUrl("");
        $createPaymentFormRequest->addProducts($products_array);
        /*foreach($products_array as $product)
        {
            $createPaymentFormRequest->addProduct($product);
        }*/
        $createPaymentFormRequest->setTimeout(30);
        $createPaymentFormRequest->setNoInstallment(true);
        $createPaymentFormRequest->setMaxInstallment(0);

        try {
            $paymentForm = $createPaymentFormRequest->execute();
            $paymentForm->printPaymentForm();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    function getPayment($data)
    {
        $getPayment = new GetPayment(config());
        $getPayment->setData($data);

        try {
            $payment = $getPayment->execute();
            exit("OK");
          } catch(Exception $exception) {
            exit($exception->getMessage());
          }
    }
?>