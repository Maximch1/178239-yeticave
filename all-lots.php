<?php
session_start();
date_default_timezone_set("Europe/Moscow");
$title = 'Лоты по категориям';


require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/user.php');

$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$user = null;
//$search = [];

if (is_auth()) {
    $user = get_user_by_id($link, $_SESSION['user_id']);
}

//$search = trim($_GET['search']) ?? null;
//if (!isset($_GET['category'])) {
//    die('Отсутствует категория');
//}

$category_id = (int)$_GET['category'];
$cur_page = $_GET['page'] ?? 1;
$page_items = 9;
$category_title = get_category_title($link, $category_id);
//$errors = validate_search($search);

    $items_count = get_category_count_lot($link, $category_id);
    $offset = ($cur_page - 1) * $page_items;
    $pages_count = ceil($items_count / $page_items);
    $pages = range(1, $pages_count);
    $lots = get_category_lot($link, $category_id, $page_items, $offset);

$content = include_template('all-lots.php', [
    'categories' => $categories,
    'lots' => $lots,
//    'search' => $search,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page,
    'category_title' => $category_title,
    'category_id' => $category_id,
//    'errors' => $errors,
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'title'      => $title,
    'categories' => $categories,
    'user' => $user,
]);

print $layout;


