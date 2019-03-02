<?php
date_default_timezone_set("Europe/Moscow");
$title = 'Регистрация нового аккаунта';
session_start();

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/validators_user.php');
$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$errors = [];
$signup = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['signup'])) {
        die('Некорректные данные для регистрации');
    }

    $user_data = $_POST['signup'];
    $user_img =  $_FILES['avatar'];

    $errors = validate_user($link, $user_data);
    $file_errors = validate_user_file_avatar($user_img['tmp_name']);
    $errors = array_merge($errors, $file_errors);

    if (!count($errors)) {
        $user_data['avatar'] = add_file($user_img);
        $insert_user = insert_user($link, $user_data);
    }

    if ($insert_user) {
        header("Location: login.php");
        exit();
    }
}

$content = include_template('sign-up.php', [
    'categories' => $categories,
    'errors'     => $errors,
    'signup'     => $user_data
]);

$layout = include_template('layout.php', [
    'content'    => $content,
    'title'      => $title,
    'categories' => $categories
]);


print $layout;

