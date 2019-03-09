<?php
session_start();
$title = 'Поиск';


require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/user.php');
require_once ('functions/validators_search.php');
require_once ('functions/validators_pagination.php');

$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$user = null;
$search = null;
$errors = null;

if (is_auth()) {
    $user = get_user_by_id($link, $_SESSION['user_id']);
}

$search = trim($_GET['search']) ?? null;

$cur_page = $_GET['page'] ?? 1;
$page_items = 9;
$errors = validate_search($search);

if (!count($errors) && $search) {
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
    'errors' => $errors,
    'link' => $link,
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'title'      => $title,
    'categories' => $categories,
    'user' => $user,
]);

print $layout;


