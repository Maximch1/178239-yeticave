<?php
date_default_timezone_set("Europe/Moscow");
$is_auth    = rand(0, 1);
$user_name  = 'Maxim';

require_once ('functions.php');
$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$lots = get_lots($link);

$lot_id = $_GET['id'] ?? null;
$lot = get_lot($link, $lot_id);

if ($lot[0]['id'] == null) {
    $content = include_template('404.php', [
        'categories' => $categories,
    ]);
}
else {
    $content = include_template('lot.php', [
        'categories' => $categories,
        'lot'        => $lot[0],
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

