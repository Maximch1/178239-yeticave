<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = 'Главная';


require_once('functions/template.php');
require_once('functions/db.php');
require_once('functions/user.php');

if ( ! file_exists('config.php')) {
    die('Создайте файл config.php на основе config.sample.php');
}

$config = require 'config.php';

$link = db_connect($config['db']);

update_lot_winner($link);
$categories = get_categories($link);
$lots       = get_lots($link);
$user       = null;

if (is_auth()) {
    $user = get_user_by_id($link, get_value($_SESSION, 'user_id'));
}

$content = include_template('index.php', [
    'categories' => $categories,
    'lots'       => $lots,
]);

$layout = include_template('layout.php', [
    'content'    => $content,
    'title'      => $title,
    'categories' => $categories,
    'user'       => $user
]);

print $layout;

