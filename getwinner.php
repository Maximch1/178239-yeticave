<?php
//session_start();
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
    foreach ($winners['0'] as $win) {
        $subject  = 'Ваша ставка победила';
        $set_to   = ['maxkhb@gmail.com' => 'Max'];
        $set_from = [$win['email'] => $win['name']];
        $set_body = include_template('email.php', [
            'lot_id' => $win['id'],
            'name'   => $win['title'],
        ]);
        send_mailer($config['mailer'], $subject, $set_to, $set_from, $set_body);
    }
}
