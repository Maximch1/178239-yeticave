<?php
session_start();
date_default_timezone_set("Europe/Moscow");
$title = 'Регистрация нового аккаунта';

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/validators_login.php');
require_once ('functions/user.php');
$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$errors = [];
$login = [];

if (is_auth()) {
    header("Location: /");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['login'])) {
        die('Некорректные данные для входа');
    }

    $user_data = $_POST['login'];
    $user_data_base = get_user_by_email($link, $user_data['email']);

    $errors = validate_login($user_data, $user_data_base);

    if (!count($errors)) {
        $_SESSION['user_id'] = $user_data_base['id'];
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

