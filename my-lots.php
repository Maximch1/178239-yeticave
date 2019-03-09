<?php
session_start();
$title = 'Мои ставки';

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/user.php');

$config = require 'config.php';

$link = db_connect($config['db']);

$categories = get_categories($link);
$user = null;

if (is_auth()) {
    $user = get_user_by_id($link, $_SESSION['user_id']);
}

$cur_page = $_GET['page'] ?? 1;
$page_items = 9;
//$errors = validate_search($search);

//if (!count($errors) && $search) {
    $items_count = get_user_count_bets($link, $user['id']);
    $offset = ($cur_page - 1) * $page_items;
    $pages_count = ceil($items_count / $page_items);
    $pages = range(1, $pages_count);
    $bets = get_user_bet($link, $user['id'], $page_items, $offset);
//}

$content = include_template('my-lots.php', [
    'categories' => $categories,
    'bets' => $bets,
//    'search' => $search,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page,
//    'errors' => $errors,
    'link' => $link,
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'title'      => $title,
    'categories' => $categories,
    'user' => $user,
]);

print $layout;


