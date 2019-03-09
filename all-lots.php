<?php
session_start();
$title = 'Лоты по категориям';

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/user.php');
require_once ('functions/validators_pagination.php');

$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$user = null;

if (is_auth()) {
    $user = get_user_by_id($link, $_SESSION['user_id']);
}

$category_id = (int)$_GET['category'];
$cur_page = getValue($_GET,'page') ?? 1;
$errors = validate_pagination_cur_page($cur_page);
$page_items = 2;
$category_title = get_category_title($link, $category_id);

if (!$errors) {
    $items_count = get_category_count_lot($link, $category_id);
    $offset      = ($cur_page - 1) * $page_items;
    $pages_count = ceil($items_count / $page_items);
    $pages       = range(1, $pages_count);
    $lots        = get_category_lot($link, $category_id, $page_items, $offset);
    $errors      = validate_pagination_count($pages_count, $cur_page);
}

$content = include_template('all-lots.php', [
    'categories' => $categories,
    'lots' => $lots,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page,
    'category_title' => $category_title,
    'category_id' => $category_id,
    'link' => $link,
    'errors' => $errors,
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'title'      => $title,
    'categories' => $categories,
    'user' => $user,
]);

print $layout;


