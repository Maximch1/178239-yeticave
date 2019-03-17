<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ('vendor/autoload.php');
require_once('functions/template.php');
require_once ('functions/db.php');
$config = require 'config.php';
$link = db_connect($config['db']);

$winners = update_lot_winner($link);

if ($winners) {
    foreach ($winners as $win) {
        $subject  = 'Ваша ставка победила';
        $set_from   = ['maximch@bk.ru' => 'Max'];
        $set_to = [$win['0']['email'] ?? null => $win['0']['name'] ?? null];
        $set_body = include_template('email.php', [
            'lot_id' => $win['0']['id'] ?? null,
            'title'   => $win['0']['title'] ?? null,
            'user_name' => $win['0']['name'] ?? null,
        ]);
        send_mailer($config['mailer'], $subject, $set_to, $set_from, $set_body);
    }
}
