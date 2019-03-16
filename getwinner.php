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

$subject = 'Ваша ставка победила';
$set_to = ['maximch@bk.ru' => 'Max'];
$set_from = ['keks@phpdemo.ru' => 'htmlacademy'];


send_mailer($config['mailer'], $subject, $set_to, $set_from);




