<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = 'Поиск';

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/user.php');
require_once ('functions/validators_search.php');
require_once ('functions/validators_pagination.php');

if (!file_exists ('config.php')) {
    die('Создайте файл config.php на основе config.sample.php');
}

$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$user = null;
$search = null;
$error = null;
$lots = null;
$pages = null;
$pages_count = null;

if (is_auth()) {
    $user = get_user_by_id($link, get_value($_SESSION, 'user_id'));
}

$search = trim(get_value($_GET,'search'));
$cur_page = get_value($_GET,'page') ?? 1;

$page_items = $config['pagination']['items_per_page'];
$error = validate_search($search);
if (!$error) {
    $error = validate_pagination_cur_page($cur_page);
}

if (!$error && $search) {
    $items_count = get_search_count_lot($link, $search);
    $offset = ($cur_page - 1) * $page_items;
    $pages_count = ceil($items_count / $page_items);
    $pages = range(1, $pages_count);
    $lots = get_search_lots($link, $search, $page_items, $offset);
    $error = validate_pagination_count($pages_count, $cur_page);
}

$content = include_template('search.php', [
    'categories' => $categories,
    'lots' => $lots,
    'search' => $search,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page,
    'error' => $error,
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'title'      => $title,
    'categories' => $categories,
    'user' => $user,
]);

print $layout;


