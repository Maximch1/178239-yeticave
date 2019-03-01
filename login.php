<?php
date_default_timezone_set("Europe/Moscow");
$is_auth    = rand(0, 1);
$user_name  = 'Maxim';
$title = 'Регистрация нового аккаунта';

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/validators_login.php');
$config = require 'config.php';

session_start();

$link = db_connect($config['db']);

$categories = get_categories($link);
$errors = [];
$login = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    if (!isset($_POST['logim'])) {
//        die('Некорректные данные для регистрации');
//    }
//
    $user_data = $_POST['login'];
    $user_data_base = check_isset_email($link, $user_data['email']);

    $errors = validate_login($user_data, $user_data_base);

    if (!count($errors)) {
        $_SESSION['user'] = $user_data_base;
        header("Location: /");
        exit();
    }
//
//    if ($insert_user) {
//        header("Location: /");
//        exit();
//    }
}

$content = include_template('login.php', [
    'categories' => $categories,
    'errors'     => $errors,
    'login'     => $user_data
]);

$layout = include_template('layout.php', [
    'content'    => $content,
    'is_auth'    => $is_auth,
    'user_name'  => $user_name,
    'title'      => $title,
    'categories' => $categories
]);


print $layout;

