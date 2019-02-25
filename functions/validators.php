<?php


/**
 * Функция проводит проверку на ошибки: заполненность полей + проверка начальной цены и шаг ставки на числовой тип.
 * @param $lots array массив в _POST, который надо проверить
 *
 * @return array
 */
function validate_lot($lots) {
    $required = ['title', 'description', 'category', 'price', 'end_time', 'step_rate'];
    $errors   = [];

    if ( ! is_numeric($lots['price'])) {
        $errors['price'] = 'Введите число';
    }

    if ( ! is_numeric($lots['step_rate'])) {
        $errors['step_rate'] = 'Введите число';
    }

    foreach ($required as $key) {
        if (empty($lots[$key])) {
            $errors[$key] = 'Заполните это поле';
        }
    }

    return $errors;
}


/**
 * Функция проверяет валидность файла на расширение JPEG
 *
 * @param $img_name string массив _FILES
 *
 * @return array
 */
function validate_file($img_name) {
    $errors = [];
    if ($img_name != null) {
        $finfo     = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $img_name);

        if (mb_strpos ($file_type, 'image') === false) {
            $errors['img'] = 'Загрузите картинку в формате JPEG';

            return $errors;
        }

        return $errors;
    }
    $errors['img'] = 'Вы не загрузили файл';

    return $errors;
}

/**
 * Проверяет, что переданная дата соответствует формату ДД.ММ.ГГГГ
 * @param $date array массив лота
 *
 * @return array
 */
function check_date_format($date) {
    $result = false;
    $errors = [];
    $regexp = '/(\d{2})\.(\d{2})\.(\d{4})/m';
    if (preg_match($regexp, $date['end_time'], $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[1], $parts[3]);
    }

    if ($result == false) {
        $errors['end_time'] = 'Неверная дата, введите дату в формате дд.мм.гггг';

        return $errors;
    }

    return $errors;
}

