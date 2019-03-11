<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$title = 'Лот';

require_once('functions/template.php');
require_once('functions/db.php');
require_once('functions/validators_lot.php');
require_once('functions/validators_bet.php');
require_once('functions/user.php');

if ( ! file_exists('config.php')) {
    die('Создайте файл config.php на основе config.sample.php');
}

$config = require 'config.php';

$link = db_connect($config['db']);

$user = null;

if (is_auth()) {
    $user = get_user_by_id($link, get_value($_SESSION, 'user_id'));
}

$categories = get_categories($link);
$lot_id     = get_value($_GET, 'id');

if ( ! $lot_id) {
    die('Отсутствует id лота');
}
if ( ! is_numeric($lot_id)) {
    die('Некорректный тип у id лота');
}

$lot      = get_lot($link, $lot_id);
$bets     = get_bets_by_lot_id($link, $lot_id);
$errors   = null;
$bet_rate = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ( ! get_value($_POST, 'rate')) {
        die('Некорректные данные для добавления ставки');
    }

    $bet_rate = get_value($_POST, 'rate');
    $errors   = validate_bet(get_value($user, 'id'), $bet_rate, $lot, get_value($bets, 0));

    if ( ! count($errors)) {
        $bet_rate_id = insert_bet($link, $bet_rate, get_value($user, 'id'), $lot_id);
        header("Location: lot.php?id=" . $lot_id);
        exit();
    }
}

$show_bet_form = show_bet_form($user, $lot, get_value($bets, 0));

if ( ! $lot) {
    $content = include_template('404.php', [
        'categories' => $categories,
    ]);
} else {
    $content = include_template('lot.php', [
        'categories'    => $categories,
        'lot'           => $lot,
        'user'          => $user,
        'bets'          => $bets,
        'errors'        => $errors,
        'rate'          => $bet_rate,
        'show_bet_form' => $show_bet_form,
    ]);
}

$layout = include_template('layout.php', [
    'content'    => $content,
    'title'      => $title,
    'categories' => $categories,
    'user'       => $user,
]);

print $layout;

