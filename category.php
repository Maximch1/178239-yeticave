<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = 'Лоты по категориям';

require_once('functions/template.php');
require_once('functions/db.php');
require_once('functions/user.php');
require_once('functions/validators_pagination.php');
require_once('functions/validators_category.php');

if ( ! file_exists('config.php')) {
    die('Создайте файл config.php на основе config.sample.php');
}

$config = require 'config.php';

$link = db_connect(get_value($config, 'db'));

$categories  = get_categories($link);
$user        = null;
$error       = null;
$category_id = null;
$lots        = null;
$pages       = null;
$pages_count = null;

if (is_auth()) {
    $user = get_user_by_id($link, $_SESSION['user_id']);
}

$category_id = (int)get_value($_GET, 'id');
$cur_page    = get_value($_GET, 'page') ?? 1;
$page_items  = $config['pagination']['items_per_page'];
$error       = validate_category($category_id);
if ( ! $error) {
    $error = validate_pagination_cur_page($cur_page);
}

$category_title = get_category_title($link, $category_id);

if ( ! $error) {
    $items_count = get_category_count_lot($link, $category_id);
    $offset      = ($cur_page - 1) * $page_items;
    $pages_count = ceil($items_count / $page_items);
    $pages       = range(1, $pages_count);
    $lots        = get_category_lot($link, $category_id, $page_items, $offset);
    $error       = validate_pagination_count($pages_count, $cur_page);
}

$content = include_template('category.php', [
    'categories'     => $categories,
    'lots'           => $lots,
    'pages'          => $pages,
    'pages_count'    => $pages_count,
    'cur_page'       => $cur_page,
    'category_title' => $category_title,
    'category_id'    => $category_id,
    'error'          => $error,
]);

$layout = include_template('layout.php', [
    'content'    => $content,
    'title'      => $title,
    'categories' => $categories,
    'user'       => $user,
]);

print $layout;


