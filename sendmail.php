<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->isSMTP();
$mail->Mailer = 'smtp';
$mail->SMTPAuth = true;
$mail->SMTPDebug = 0;

$mail->Host = 'ssl://smtp.gmail.com';
$mail->Port = 465;
$mail->Username = 'mymail@gmail.com';
$mail->Password = 'secret';

//from
$mail->setFrom('mymail@gmail.com', 'Do You Speak?');
//to
$mail->addAddress('mail@mail.ru');

$mail->IsHTML(true);
//theme
$mail->Subject = "[Заявка с формы]";

$body = '<h1>Привет! Это письмо пришло, потому что кто-то оставил заявку на сайте.</h1>';

if (trim(!empty($_POST['name']))){
	$body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
}
if (trim(!empty($_POST['number']))){
	$body.='<p><strong>Телефон:</strong> '.$_POST['number'].'</p>';
}
if (trim(!empty($_POST['email']))){
	$body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
}
$mail->Body = $body;

if(!$mail->send()) {
	$message = 'Ошибка';
} else {
	$message = 'Данные отправлены! Я свяжусь с Вами в ближайшее время :)';
}
$response = ['message'=> $message];

header('Content-type: application/json');
echo json_encode($response);

?>