<?php
date_default_timezone_set("Europe/Moscow");
$is_auth    = rand(0, 1);
$user_name  = 'Maxim';

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/validators.php');
$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['lot'])) {
        die('Некорректные данные для добавления лота');
    }

    if (!isset($_FILES['lot_img']['tmp_name'])) {
        die('Некорректный файл');
    }

    $lot_data = $_POST['lot'];
    $lot_img =  $_FILES['lot_img']['tmp_name'];

    $errors = valid_lot($lot_data);
    $errors = valid_file($lot_img, $errors);

    if (!count($errors)) {
        $lot_data['img'] = add_file($lot_img);
        $lot_id = insert_lot($link, $lot_data);
    }

    if ($lot_id) {
        header("Location: lot.php?id=" . $lot_id);
    }

    if (count($errors)) {
        $content = include_template('add.php', [
            'categories' => $categories,
            'errors'     => $errors,
            'lot'        => $lot_data
        ]);
    }
}
else {
    $content = include_template('add.php', [
        'categories' => $categories
    ]);
}

$layout = include_template('layout.php', [
    'content'    => $content,
    'is_auth'    => $is_auth,
    'user_name'  => $user_name,
    'title'      => 'Главная',
    'categories' => $categories
]);


print $layout;

