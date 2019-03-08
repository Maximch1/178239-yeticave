<?php
session_start();
$title = 'Добавление лота';

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/validators_lot.php');
require_once ('functions/user.php');
$config = require 'config.php';

$link = db_connect($config['db']);

if (!is_auth()) {
    http_response_code(403);
    exit();
}

$user = null;
$user = get_user_by_id($link, $_SESSION['user_id']);

$categories = get_categories($link);
$errors = [];
$lot = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['lot'])) {
        die('Некорректные данные для добавления лота');
    }

    if (!isset($_FILES['lot_img'])) {
        die('Некорректный файл');
    }

    $lot_data = $_POST['lot'];
    $lot_img =  $_FILES['lot_img'];
    $user_id = $_SESSION['user_id'];

    $errors = validate_lot($lot_data);
    $file_errors = validate_lot_file_image($lot_img['tmp_name']);
    $errors = array_merge($errors, $file_errors);

    if (!count($errors)) {
        $lot_data['img'] = add_file($lot_img);
        $lot_id = insert_lot($link, $lot_data, $user_id);
    }

    if ($lot_id) {
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

