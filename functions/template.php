<?php

/**
 * Функция возвращает HTML-код с подставленными данными или описание ошибки
 * @param $name string имя файла шаблона
 * @param $data array массив с данными для этого шаблона
 *
 * @return false|string
 */
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


/**
 * Функция окуругляет число в большую сторону и разбивает на разделы возвращая число с знаком рубля
 * @param $price string
 *
 * @return string
 */
function format_price($price) {
    return number_format(ceil($price), 0, null, ' ') . "<b class=\"rub\">р</b>";
}


/**
 * Функция возвращает разницу от текущего времени до определенной даты(необходимо ввести аргумент) в формате часы:минуты
 * @param $str_time string дата окончания
 *
 * @return string
 */
function time_to_end ($str_time) {
    $secs_to_end = strtotime($str_time) - time();

    if ($secs_to_end <= 0) {
        return '00:00';
    }

    $hours = sprintf("%'.02d", floor($secs_to_end / 3600));
    $minutes = sprintf("%'.02d", floor(($secs_to_end % 3600) / 60));

    return $hours.":".$minutes;
}


/**
 * Функция загружает файл в папку img/ и выводит имя файла в массив _POST
 * @param $img_name
 *
 * @return mixed
 */
function add_file ($img_name) {
    $file_type = pathinfo($img_name['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $file_type;
    move_uploaded_file($img_name['tmp_name'], 'img/' . $filename);
    $data = 'img/' . $filename;

    return $data;
}
