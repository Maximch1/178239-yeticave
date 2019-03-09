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
 * Функция окуругляет число в большую сторону и разбивает на разделы возвращая число с знаком рубля. использунтся в выводе ставок.
 * @param $price string
 *
 * @return string
 */
function format_price_bets($price) {
    return number_format(ceil($price), 0, null, ' ') . " р";
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
 * Функция загружает файл в папку uploads/ и выводит имя файла в массив _POST
 * @param $img_name
 *
 * @return mixed
 */
function add_file ($img_name) {
    $file_type = pathinfo($img_name['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $file_type;
    move_uploaded_file($img_name['tmp_name'], 'uploads/' . $filename);
    $data = 'uploads/' . $filename;
    return $data;
}



/**
 * Функция возращает верное написание слова из массива
 *
 * @param integer $time
 * @param array $words
 * @return string возращает правилный вариант склонения слова в русском языке
 */
function get_correct_word ($time, $words) {
    if ($time % 100 > 4 && $time % 100 < 21) {
        return $words[0];
    } elseif ($time % 10 === 1) {
        return $words[1];
    } elseif ($time % 10 > 1 && $time % 10 < 5) {
        return $words[2];
    }
    return $words[0];
};
const HOURS = ['часов', 'час', 'часа'];
const MINUTES = ['минут', 'минута', 'минуты'];


/**
 * Функция форматирует поле с датой и временем, исходя из давности даты.
 * @param $str_time string дата + время с БД
 *
 * @return string|null
 */
function get_time_format($str_time) {
    $secs_to_end = time() - strtotime($str_time);
    $hours   = sprintf("%'.02d", floor($secs_to_end / 3600));
    $minutes = sprintf("%'.02d", floor(($secs_to_end % 3600) / 60));

    if (strtotime('yesterday') < strtotime($str_time) AND strtotime('midnight') > strtotime($str_time) ) {
        return 'Вчера, в ' . date('H:i', strtotime($str_time));
    }

    if (strtotime('midnight') < strtotime($str_time) AND $hours <= 24 && $hours > 0) {
        return $hours . ' ' . get_correct_word($hours, HOURS) . ' ' .  $minutes . ' ' . get_correct_word($minutes, MINUTES) . ' назад';
    }


    if ($hours <= 0 AND $minutes <= 1) {
        return 'минуту назад';
    }

    if ($hours <= 0) {
        return $minutes . ' ' . get_correct_word($minutes, MINUTES) . ' назад';
    }
    return null;
}


/**
 * Функция проверки массива на существование переменной.
 * @param $array array массив
 * @param $key string ключ массива
 *
 * @return null|array
 */
function getValue($array, $key) {
    if (!isset($array[$key])) {
        return null;
    }
    return $array[$key];
}


/**
 * Функция выводит одну из найденных ошибок
 * @param $errors1 array|string ошибка 1
 * @param $errors2 array|string ошибка 2
 *
 * @return array|string
 */
function get_errors ($errors1, $errors2) {
    $errors = [];
    if ($errors1) {
        return $errors = $errors1;
    }
    if ($errors2) {
        return $errors = $errors2;
    }
    return $errors;
}
