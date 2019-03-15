<?php

/**
 * Функция проводит проверку на ошибки формы ставки
 *
 * @param $user_id_auth     int ID авторизированного юзера
 * @param $bet_rate         int сумма ставки
 * @param $lot              array массив лота
 * @param $last_bet         array массив ставок
 *
 * @return string
 */
function validate_bet($user_id_auth, $bet_rate, $lot, $last_bet)
{
    if ($error = validate_bet_user($user_id_auth, get_value($lot, 'user_id'), get_value($last_bet, 'user_id'))) {
        return $error;
    }

    if ($error = validate_bet_end_time(get_value($lot, 'end_time'))) {
        return $error;
    }

    if ($error = validate_bet_rate($bet_rate, get_value($lot, 'max_rate'), get_value($lot, 'step_rate'))) {
        return $error;
    }

    return null;
}


/**
 * Функция проверяет, чтобы автор лота не смог сделать в своем лоте ставку.
 *
 * @param $user_id_auth int ID авторизированного юзера
 * @param $user_id_lot  int ID автора лота
 * @param $user_id_bet  int ID юзера сделавшего последнюю ставку
 *
 * @return string|null
 */
function validate_bet_user($user_id_auth, $user_id_lot, $user_id_bet)
{
    if ($user_id_auth === $user_id_lot) {
        return 'Своему лоту сделать ставку нельзя';
    }

    if ($user_id_auth === $user_id_bet) {
        return 'Вы уже сделали ставку';
    }

    return null;
}

/**
 * Функция проверяет временной промежуток, нельзя сделать ставку после истечения даты окончания торгов
 *
 * @param $end_time string дата окончания торгов
 *
 * @return string|null
 */
function validate_bet_end_time($end_time)
{
    if (time() < $end_time) {
        return 'Торги окончены';
    }

    return null;
}

/**
 * Функция проверяет сумму ставки на валидность
 *
 * @param $rate      int сумма ставки
 * @param $max_rate  int максимальная сумма ставки
 * @param $step_rate int шаг ставки
 *
 * @return string|null
 */
function validate_bet_rate($rate, $max_rate, $step_rate)
{
    if (empty($rate)) {
        return 'Введите сумму';
    }

    if ( ! is_numeric($rate)) {
        return 'Значение должно быть числом';
    }

    if ($rate < 0) {
        return 'Цена не должна быть отрицательной';
    }

    if ( ! ctype_digit($rate)) {
        return 'Введите целое число';
    }

    if ($rate < ($max_rate + $step_rate)) {
        return 'нельзя сделать ставку ниже ' . ($max_rate + $step_rate);
    }

    if ($rate > 10000000) {
        return 'Сумма не должно превышать 10&nbsp;000&nbsp;000';
    }

    return null;
}


