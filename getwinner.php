<?php
//session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ('vendor/autoload.php');
require_once('functions/template.php');
require_once ('functions/db.php');
$config = require 'config.php';
$link = db_connect($config['db']);

//$transport = new Swift_SmtpTransport("smtp.mailtrap.io", 25);
//$transport->setUsername("d5f1803dfc24be");
//$transport->setPassword("cc78c3dde097d9");

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));


$message = new Swift_Message();
$message->setSubject("Ваша ставка победила");
//$message->setFrom(['keks@phpdemo.ru' => 'htmlacademy']);
//$message->setTo(['maximch@bk.ru' => 'Max']);
$message->setTo("maximch@bk.ru", "Max");

//$msg_content = include_template('email.php', []);
//$message->setBody($msg_content, 'text/html');

$message->setFrom("mail@giftube.academy", "GifTube");

$mailer = new Swift_Mailer($transport);
$result = $mailer->send($message);

if ($result) {
    print("Рассылка успешно отправлена");
}
else {
    print("Не удалось отправить рассылку: " . $logger->dump());
}






