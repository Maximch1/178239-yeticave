<?php
session_start();
$title = 'Главная';


require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/user.php');

$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$lots = get_lots($link);
$user = null;

if (is_auth()) {
    $user = get_user_by_id($link, $_SESSION['user_id']);
}

$content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots,
    'link' => $link,
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'title'      => $title,
    'categories' => $categories,
    'user' => $user
]);

print $layout;

