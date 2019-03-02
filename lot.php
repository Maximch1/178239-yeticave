<?php
date_default_timezone_set("Europe/Moscow");
$title = 'Лот';
session_start();

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/validators_lot.php');
$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$lots = get_lots($link);

if (!isset($_GET['id'])) {
    die('Отсутствует id лота');
}
if (!is_numeric($_GET['id'])) {
    die('Некорректный тип у id лота');
}

$lot_id = (int)$_GET['id'];

$lot = get_lot($link, $lot_id);

if (!$lot) {
    $content = include_template('404.php', [
        'categories' => $categories,
    ]);
}
else {
    $content = include_template('lot.php', [
        'categories' => $categories,
        'lot'        => $lot,
    ]);
}

$layout = include_template('layout.php', [
    'content' => $content,
    'title'      => $title,
    'categories' => $categories
]);

print $layout;

