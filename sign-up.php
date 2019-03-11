<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = 'Регистрация нового аккаунта';

require_once('functions/template.php');
require_once('functions/db.php');
require_once('functions/validators_user.php');
require_once('functions/user.php');

if ( ! file_exists('config.php')) {
    die('Создайте файл config.php на основе config.sample.php');
}

$config = require 'config.php';

$link = db_connect($config['db']);

$user = null;

if (is_auth()) {
    header("Location: /");
    exit();
}

$categories = get_categories($link);
$errors     = [];
$signup     = [];
$user_data  = null;
$user       = null;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ( ! get_value($_POST, 'signup')) {
        die('Некорректные данные для регистрации');
    }

    $user_data = get_value($_POST, 'signup');
    $user_img  = get_value($_FILES, 'avatar');

    $errors      = validate_user($link, $user_data);
    $file_errors = validate_user_file_avatar(get_value($user_img, 'tmp_name'));
    $errors      = array_merge($errors, $file_errors);

    if ( ! count($errors)) {
        if (is_uploaded_file(get_value($user_img,'tmp_name'))) {
            $user_data['avatar'] = add_file($user_img);
        } else {
            $user_data['avatar'] = '';
        }
        $insert_user = insert_user($link, $user_data);
    }

    if (isset($insert_user)) {
        header("Location: login.php");
        exit();
    }
}

$content = include_template('sign-up.php', [
    'categories' => $categories,
    'errors'     => $errors,
    'signup'     => $user_data,
]);

$layout = include_template('layout.php', [
    'content'    => $content,
    'title'      => $title,
    'categories' => $categories,
    'user'       => $user,
]);


print $layout;

