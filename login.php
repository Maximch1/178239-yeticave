<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = 'Регистрация нового аккаунта';

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/validators_login.php');
require_once ('functions/user.php');

if (!file_exists ('config.php')) {
    die('Создайте файл config.php на основе config.sample.php');
}

$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$errors = [];
$login = [];
$user_data = null;
$user = null;

if (is_auth()) {
    header("Location: /");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!get_value($_POST,'login')) {
        die('Некорректные данные для входа');
    }

    $user_data = get_value($_POST,'login');
    $user_data_base = get_user_by_email($link, get_value($user_data,'email'));

    $errors = validate_login($user_data, $user_data_base);

    if (!count($errors)) {
        $_SESSION['user_id'] = get_value($user_data_base,'id');
        header("Location: /");
        exit();
    }
}

$content = include_template('login.php', [
    'categories' => $categories,
    'errors'     => $errors,
    'login'     => $user_data,
]);

$layout = include_template('layout.php', [
    'content'    => $content,
    'title'      => $title,
    'categories' => $categories,
    'user' => $user,
]);


print $layout;

