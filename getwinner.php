<?php
session_start();

require_once ('functions/db.php');
$config = require 'config.php';
$link = db_connect($config['db']);

update_lot_winner ($link);

$transport = new Swift_SmtpTransport('');
