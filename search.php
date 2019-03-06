<?php
session_start();
date_default_timezone_set("Europe/Moscow");
$title = 'Поиск';


require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/user.php');

$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
//$lots = get_lots($link);
$user = null;
$search = [];

if (is_auth()) {
    $user = get_user_by_id($link, $_SESSION['user_id']);
}

$search = trim($_GET['search']) ?? '';

$cur_page = $_GET['page'] ?? 1;
$page_items = 2;

if ($search) {
    $items_count = get_search_count_lot($link, $search);
    $offset = ($cur_page - 1) * $page_items;
    $pages_count = ceil($items_count / $page_items);
    $pages = range(1, $pages_count);
    $lots = get_search_lots($link, $search, $page_items, $offset);
}

$content = include_template('search.php', [
    'categories' => $categories,
    'lots' => $lots,
    'search' => $search,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page,
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'title'      => $title,
    'categories' => $categories,
    'user' => $user,
]);

print $layout;


