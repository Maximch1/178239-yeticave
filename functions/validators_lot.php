<?php

/**
 * Функция проводит проверку на ошибки формы лота
 *
 * @param $lot_data array массив с введенными юзером данными, который надо проверить
 *
 * @return array массив ошибок
 */
function validate_lot($lot_data)
{
    $errors = [];

    if ($error = validate_lot_title(get_value($lot_data, 'title'))) {
        $errors['title'] = $error;
    }

    if ($error = validate_lot_price(get_value($lot_data, 'price'))) {
        $errors['price'] = $error;
    }

    if ($error = validate_lot_description(get_value($lot_data, 'description'))) {
        $errors['description'] = $error;
    }

    if ($error = validate_lot_category_id(get_value($lot_data, 'category_id'))) {
        $errors['category_id'] = $error;
    }

    if ($error = validate_lot_step_rate(get_value($lot_data, 'step_rate'))) {
        $errors['step_rate'] = $error;
    }

    if ($error = validate_lot_end_time(get_value($lot_data, 'end_time'))) {
        $errors['end_time'] = $error;
    }

    return $errors;
}

/**
 * Функция проверяет валидность наименования лота
 *
 * @param $title string название лота
 *
 * @return string|null текст ошибки
 */
function validate_lot_title($title)
{
    if (empty($title)) {
        return 'Заполните наименование лота';
    }

    if (mb_strlen($title) > 128) {
        return 'Наименование лота не должно превышать 128 символов';
    }

    return null;
}

/**
 * Функция проверяет валидность начальной цены
 *
 * @param $price string название лота
 *
 * @return string|null текст ошибки
 */
function validate_lot_price($price)
{
    if (empty($price)) {
        return 'Заполните начальную стоимость';
    }

    if ( ! is_numeric($price)) {
        return 'Значение должно быть числом';
    }

    if ($price > 10000000) {
        return 'Сумма не должно превышать 10&nbsp;000&nbsp;000';
    }

    if ($price < 0) {
        return 'Цена не должна быть отрицательной';
    }

    return null;
}

/**
 * Функция проверяет валидность опсания
 *
 * @param $description string описание
 *
 * @return string|null
 */
function validate_lot_description($description)
{
    if (empty($description)) {
        return 'Напишите описание лота';
    }

    if (mb_strlen($description) > 2000) {
        return 'Описание лота не должно превышать 2000 символов';
    }

    return null;
}

/**
 * Функция проверяет валидность категории
 *
 * @param $category_id  int ID категории
 *
 * @return string|null
 */
function validate_lot_category_id($category_id)
{
    if (empty($category_id)) {
        return 'Выберите категорию';
    }

    return null;
}

/**
 * Функция проверяет валидность шаг ставки
 *
 * @param $step_rate string шаг ставки
 *
 * @return string|null
 */
function validate_lot_step_rate($step_rate)
{
    if (empty($step_rate)) {
        return 'Введите шаг ставки';
    }

    if ( ! is_numeric($step_rate)) {
        return 'Значение должно быть числом';
    }

    if ($step_rate <= 0) {
        return 'Шаг ставки должен быть больше ноля';
    }

    if ( ! ctype_digit($step_rate)) {
        return 'Введите целое число';
    }

    if ($step_rate > 10000000) {
        return 'Шаг ставки не должен превышать 10&nbsp;000&nbsp;000';
    }

    return null;
}

/**
 * Функция проверяет валидность даты
 *
 * @param $end_time string дата
 *
 * @return string|null
 */

function validate_lot_end_time($end_time)
{
    if (empty($end_time)) {
        return 'Заполните дату окончания лота';
    }

    $result = false;
    $regexp = '/(\d{4})\-(\d{2})\-(\d{2})/m';

    if (preg_match($regexp, $end_time, $parts) && count($parts) == 4) {
        $result = checkdate(get_value($parts, 2), get_value($parts, 3), get_value($parts, 1));
    }

    if ( ! $result) {
        return 'Неверная дата';
    }

    if (strtotime($end_time) < time()) {
        return 'Дата должна быть больше текущей';
    }

    return null;
}

/**
 * Функция проверяет валидность файла, файл должен быть изображением.
 *
 * @param $img_name string наименование файла
 *
 * @return array
 */
function validate_lot_file_image($img_name)
{
    $errors = [];
    if ( ! empty($img_name)) {
        $finfo     = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $img_name);

        if ( ! is_image($file_type)) {
            $errors['img'] = 'Загрузите картинку в формате jpeg или png';

            return $errors;
        }

        return $errors;
    }
    $errors['img'] = 'Вы не загрузили файл';

    return $errors;
}

/**
 * Функция сравнивает перечисленные в функции типы с типом файла
 *
 * @param $mime_type string тип файла
 *
 * @return bool
 */
function is_image($mime_type)
{
    $allow_types = [
        'image/jpeg',
        'image/png'

    ];

    return (array_search($mime_type, $allow_types) !== false);
}

/**
 * Функция проверяет отображаль ли форму добавления ставки или нет.
 * Скрывает, если пользователь не авторизирован, торги окончены, автору лота, автору последней ставки.
 *
 * @param $user     array юзер
 * @param $lot      array данные юзера
 * @param $last_bet array данные последней ставки
 *
 * @return bool
 */
function show_bet_form($user, $lot, $last_bet)
{
    if ( ! $user) {
        return false;
    }

    if (get_value($lot, 'end_time') < date('Y-m-d H:i:s')) {
        return false;
    }

    if (get_value($user, 'id') === get_value($lot, 'user_id')) {
        return false;
    }

    if (get_value($user, 'id') === get_value($last_bet, 'user_id')) {
        return false;
    }

    return true;
}
