<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = 'Добавление лота';

require_once('functions/template.php');
require_once('functions/db.php');
require_once('functions/validators_lot.php');
require_once('functions/user.php');

if ( ! file_exists('config.php')) {
    die('Создайте файл config.php на основе config.sample.php');
}

$config = require 'config.php';

$link = db_connect($config['db']);

if ( ! is_auth()) {
    http_response_code(403);
    exit();
}

$user = null;
$user = get_user_by_id($link, get_value($_SESSION, 'user_id'));

$categories = get_categories($link);
$errors     = [];
$lot_data   = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ( ! get_value($_POST, 'lot')) {
        die('Некорректные данные для добавления лота');
    }

    if ( ! get_value($_FILES, 'lot_img')) {
        die('Некорректный файл');
    }

    $lot_data = get_value($_POST, 'lot');
    $lot_img  = get_value($_FILES, 'lot_img');
    $user_id  = get_value($_SESSION, 'user_id');

    $errors      = validate_lot($lot_data);
    $file_errors = validate_lot_file_image(get_value($lot_img, 'tmp_name'));
    $errors      = array_merge($errors, $file_errors);

    if ( ! $errors) {
        $lot_data['img'] = add_file($lot_img);
        $lot_id          = insert_lot($link, $lot_data, $user_id);
        header("Location: lot.php?id=" . $lot_id);
        exit();
    }
}

$content = include_template('add.php', [
    'categories' => $categories,
    'errors'     => $errors,
    'lot'        => $lot_data,
]);

$layout = include_template('layout.php', [
    'content'    => $content,
    'title'      => $title,
    'categories' => $categories,
    'user'       => $user,
]);


print $layout;

