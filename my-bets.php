<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = 'Мои ставки';

require_once('functions/template.php');
require_once('functions/db.php');
require_once('functions/user.php');

if ( ! file_exists('config.php')) {
    die('Создайте файл config.php на основе config.sample.php');
}

$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$user       = null;

if (is_auth()) {
    $user = get_user_by_id($link, get_value($_SESSION, 'user_id'));
}

$bets = get_user_bets($link, get_value($user, 'id'));

$content = include_template('my-bets.php', [
    'categories' => $categories,
    'bets'       => $bets,
]);

$layout = include_template('layout.php', [
    'content'    => $content,
    'title'      => $title,
    'categories' => $categories,
    'user'       => $user,
]);

print $layout;


