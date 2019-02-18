<?php
date_default_timezone_set("Europe/Moscow");
$is_auth    = rand(0, 1);
$user_name  = 'Maxim';

require_once ('functions.php');
require_once('mysql_helper.php');
$config = require 'config.php';

$link = mysqli_connect($config[db]["host"], $config[db]["user"], $config[db]["password"], $config[db]["database"]);
mysqli_set_charset($link, "utf8");

$categories_sql = "SELECT * FROM categories";
$lots_sql = "SELECT l.title AS name, c.title AS category, l.price AS price, l.image, l.end_time
             FROM lots l
             JOIN categories c ON c.id = l.category_id
             WHERE l.winner_id IS NULL";

$categories = get_categories($link, $categories_sql);
$lots = get_lots($link, $lots_sql, '6');

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

