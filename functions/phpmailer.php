<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($fromEmail, $fromName, $toAddresses, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alperkum.cs@gmail.com';
        $mail->Password = 'nxjy lfgd orwd fifa';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom($fromEmail, $fromName);

        if (is_array($toAddresses)) {
            foreach ($toAddresses as $address) {
                $mail->addAddress($address);
            }
        } else {
            $mail->addAddress($toAddresses);
        }

        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return "Mesaj başarıyla gönderildi!";
    } catch (Exception $e) {
        return "Mesaj gönderilemedi. Hata: " . $mail->ErrorInfo;
    }
}
?>