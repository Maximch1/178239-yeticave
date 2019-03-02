<?php
date_default_timezone_set("Europe/Moscow");
$title = 'Регистрация нового аккаунта';
session_start();

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/validators_login.php');
$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$errors = [];
$login = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['login'])) {
        die('Некорректные данные для входа');
    }

    $user_data = $_POST['login'];
    $user_data_base = check_isset_email($link, $user_data['email']);

    $errors = validate_login($user_data, $user_data_base);

    if (!count($errors)) {
        $_SESSION['user']['name'] = $user_data_base['name'];
        header("Location: /");
        exit();
    }
}

$content = include_template('login.php', [
    'categories' => $categories,
    'errors'     => $errors,
    'login'     => $user_data
]);

$layout = include_template('layout.php', [
    'content'    => $content,
    'title'      => $title,
    'categories' => $categories
]);


print $layout;

