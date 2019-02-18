<?php

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function format_price($price) {
    return number_format(ceil($price), 0, null, ' ') . "<b class=\"rub\">р</b>";
}

function time_to_end ($str_time) {
    $secs_to_midnight = strtotime($str_time) - time();
    $hours = sprintf("%'.02d", floor($secs_to_midnight / 3600));
    $minutes = sprintf("%'.02d", floor(($secs_to_midnight % 3600) / 60));
    return $hours.":".$minutes;
};

function db_connect ($config) {
    $link = mysqli_connect($config["host"], $config["user"], $config["password"], $config["database"]);
    if ($link == false) {
        print ("Ошибка подключения: " . mysqli_connect_error());
    }
    else {
        mysqli_set_charset($link, "utf8");
        return $link;
    }
}
