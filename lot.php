<?php
session_start();
date_default_timezone_set("Europe/Moscow");
$title = 'Лот';

require_once ('functions/template.php');
require_once ('functions/db.php');
require_once ('functions/validators_lot.php');
require_once ('functions/validators_bet.php');
require_once ('functions/user.php');
$config = require 'config.php';

$link = db_connect($config['db']);

$user = null;

if (is_auth()) {
    $user = get_user_by_id($link, $_SESSION['user_id']);
}

$categories = get_categories($link);

if (!isset($_GET['id'])) {
    die('Отсутствует id лота');
}
if (!is_numeric($_GET['id'])) {
    die('Некорректный тип у id лота');
}

$lot_id = (int)$_GET['id'];
$lot = get_lot($link, $lot_id);
$bets = get_bets_by_lot_id($link, $lot_id);
$errors = [];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['rate'])) {
        die('Некорректные данные для добавления ставки');
    }

    $bet_rate = $_POST['rate'];
    $errors = validate_bet($user['id'], $bet_rate, $lot, $bets);

    if (!count($errors)) {
        $bet_rate_id = insert_bet($link, $bet_rate, $user['id'], $lot_id);
    }
    if ($bet_rate_id) {
        header("Location: lot.php?id=" . $lot_id);
        exit();
    }
}

if (!$lot) {
    $content = include_template('404.php', [
        'categories' => $categories,
    ]);
}
else {
    $content = include_template('lot.php', [
        'categories' => $categories,
        'lot'        => $lot,
        'user'       => $user,
        'bets'       => $bets,
        'errors'     => $errors,
    ]);
}

$layout = include_template('layout.php', [
    'content' => $content,
    'title'      => $title,
    'categories' => $categories,
    'user' => $user,
]);

print $layout;

