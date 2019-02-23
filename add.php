<?php
date_default_timezone_set("Europe/Moscow");
$is_auth    = rand(0, 1);
$user_name  = 'Maxim';

require_once ('functions.php');
$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$lot = insert_lot($link);

if (count($lot)) {
    $content = include_template('add.php', [
        'categories' => $categories,
        'errors' => $lot[0],
        'dict' => $lot[1],
        'lot' => $lot[2]
    ]);
}
else {
    $content = include_template('add.php', [
        'categories' => $categories,
    ]);
}

$layout = include_template('layout.php', [
    'content' => $content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Главная',
    'categories' => $categories
]);


print $layout;

