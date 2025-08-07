<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isim = strip_tags(trim($_POST["isim"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mesaj = trim($_POST["mesaj"]);

    if (empty($isim) || empty($mesaj) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Lütfen formu doğru doldurun.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kodemyotr@gmail.com';
        $mail->Password = 'drjn toax tmhp rmzq';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($email, $isim);
        $mail->addAddress('kodemyotr@gmail.com');

        $mail->isHTML(false);
        $mail->Subject = 'Yeni İletişim Formu Mesajı';
        $mail->Body = "İsim: $isim\nE-posta: $email\n\nMesaj:\n$mesaj";

        $mail->send();
        echo "Mesaj başarıyla gönderildi!";
    } catch (Exception $e) {
        echo "Mesaj gönderilemedi. Hata: {$mail->ErrorInfo}";
    }
} else {
    header("Location: iletisim.html");
    exit;
}
