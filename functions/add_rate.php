<?php

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
}
const HOURS = ['часов', 'час', 'часа'];
const MINUTES = ['минут', 'минута', 'минуты'];


/**
 * Функция выводит дату и время в ставках в верном формате
 * @param string $str_time дата
 *
 * @return string|null
 */
function get_time_format_bet(string $str_time) {
    $secs_to_end = time() - strtotime($str_time);
    $hours   = sprintf("%'.02d", floor($secs_to_end / 3600));
    $minutes = sprintf("%'.02d", floor(($secs_to_end % 3600) / 60));

    if ($hours < 24 && $hours > 0) {
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
 * Функция редиректа на определенный лот
 * @param $lot_id int ID лота
 */
function redirect_lot_id ($lot_id) {
    header("Location: lot.php?id=" . $lot_id);
    exit();
}
