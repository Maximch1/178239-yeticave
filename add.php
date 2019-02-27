<?php
date_default_timezone_set("Europe/Moscow");
$is_auth    = rand(0, 1);
$user_name  = 'Maxim';
$title = 'Добавление лота';

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/validators.php');
$config = require 'config.php';

$link = db_connect($config['db']);

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

    $errors = validate_lot($lot_data);
    $file_errors = validate_file($lot_img);
    $errors_date = check_date_format($lot_data);
    $errors = array_merge($errors, $file_errors, $errors_date);

    if (!count($errors)) {
        $lot_data['img'] = add_file($lot_img);
        $lot_id = insert_lot($link, $lot_data);
    }

    if ($lot_id) {
        header("Location: lot.php?id=" . $lot_id);
        exit();
    }
}

$content = include_template('add.php', [
    'categories' => $categories,
    'errors'     => $errors,
    'lot'        => $lot_data
]);

$layout = include_template('layout.php', [
    'content'    => $content,
    'is_auth'    => $is_auth,
    'user_name'  => $user_name,
    'title'      => $title,
    'categories' => $categories
]);


print $layout;

