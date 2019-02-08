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

function time_to_midnight (){
    $secs_to_midnight = strtotime('tomorrow') - time();
    $hours = sprintf("%'.02d\n", floor($secs_to_midnight / 3600));
    $minutes = sprintf("%'.02d\n", floor(($secs_to_midnight % 3600) / 60));
    return $hours.":".$minutes;
};
