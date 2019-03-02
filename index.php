<?php
date_default_timezone_set("Europe/Moscow");
$title = 'Главная';
session_start();


require_once ('functions/template.php');
require_once ('functions/db.php');
$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$lots = get_lots($link);

$content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots,
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'title'      => $title,
    'categories' => $categories
]);

print $layout;

