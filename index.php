<?php
session_start();
date_default_timezone_set("Europe/Moscow");
$title = 'Главная';


require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/user.php');

$config = require 'config.php';

$link = db_connect($config['db']);

update_lot_winner ($link);
$categories = get_categories($link);
$lots = get_lots($link);
$user = null;

if (is_auth()) {
    $user = get_user_by_id($link, $_SESSION['user_id']);
}

$content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots,
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'title'      => $title,
    'categories' => $categories,
    'user' => $user
]);

print $layout;

