<?php

/**
 * Функция проводит проверку на ошибки формы лота
 * @param $lot_data array массив в _POST, который надо проверить
 *
 * @return array массив ошибок
 */
function validate_lot($lot_data) {
    $errors   = [];

    if ($error = validate_lot_title($lot_data['title'])) {
        $errors['title'] = $error;
    }

    if ($error = validate_lot_price($lot_data['price'])) {
        $errors['price'] = $error;
    }

    if ($error = validate_lot_description($lot_data['description'])) {
        $errors['description'] = $error;
    }

    if ($error = validate_lot_category_id($lot_data['category_id'])) {
        $errors['category_id'] = $error;
    }

    if ($error = validate_lot_step_rate($lot_data['step_rate'])) {
        $errors['step_rate'] = $error;
    }

    if ($error = validate_lot_end_time($lot_data['end_time'])) {
        $errors['end_time'] = $error;
    }
    return $errors;
}

/**
 * Функция проверяет валидность наименования лота
 * @param $title string название лота
 *
 * @return string|null текст ошибки
 */
function validate_lot_title($title) {
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
 * @param $price string название лота
 *
 * @return string|null текст ошибки
 */
function validate_lot_price($price) {
    if (empty($price)) {
        return 'Заполните начальную стоимость';
    }

    if (!is_numeric($price)) {
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
 * @param $description string описание
 *
 * @return string|null
 */
function validate_lot_description($description) {
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
 * @param $category_id  int ID категории
 *
 * @return string|null
 */
function validate_lot_category_id($category_id) {
    if (empty($category_id)) {
        return 'Выберите категорию';
    }
    return null;
}

/**
 * Функция проверяет валидность шаг ставки
 * @param $step_rate string шаг ставки
 *
 * @return string|null
 */
function validate_lot_step_rate($step_rate) {
    if (empty($step_rate)) {
        return 'Введите шаг ставки';
    }

    if (!is_numeric($step_rate)) {
        return 'Значение должно быть числом';
    }

    if (!ctype_digit($step_rate)) {
        return 'Введите целое число';
    }

    if ($step_rate > 10000000) {
        return 'Шаг ставки не должен превышать 10&nbsp;000&nbsp;000';
    }

    if ($step_rate <= 0) {
        return 'Шаг ставки должен быть больше ноля';
    }
    return null;
}

/**
 * Функция проверяет валидность даты
 * @param $end_time string дата
 *
 * @return string|null
 */

function validate_lot_end_time($end_time) {
    if (empty($end_time)) {
        return 'Заполните дату окончания лота';
    }

    $result = false;
    $regexp = '/(\d{4})\-(\d{2})\-(\d{2})/m';

    if (preg_match($regexp, $end_time, $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[3], $parts[1]);
    }

    if (!$result) {
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
 * @param $img_name array массив _FILES
 *
 * @return array
 */
function validate_lot_file_image($img_name) {
    $errors = [];
    if (!empty($img_name))  {
        $finfo     = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $img_name);

        if (mb_strpos ($file_type, 'image') === false) {
            $errors['img'] = 'Загрузите картинку';
            return $errors;
        }
        return $errors;
    }
    $errors['img'] = 'Вы не загрузили файл';
    return $errors;
}
