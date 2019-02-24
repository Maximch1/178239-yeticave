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
$lots = get_lots($link);

$content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots,
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Главная',
    'categories' => $categories
]);

print $layout;

