<?php


/**
 * Функция проводит проверку на ошибки: заполненность полей + проверка начальной цены и шаг ставки на числовой тип.
 * @param $lot array массив в _POST, который надо проверить
 *
 * @return array
 */
function validate_lot($lot) {
    $required = ['title', 'description', 'category', 'price', 'end_time', 'step_rate'];
    $errors   = [];

    if ( ! is_numeric($lot['price'])) {
        $errors['price'] = 'Введите число';
    }

    if ( ! is_numeric($lot['step_rate'])) {
        $errors['step_rate'] = 'Введите число';
    }

    foreach ($required as $key) {
        if (empty($lot[$key])) {
            $errors[$key] = 'Заполните это поле';
        }
    }

    return $errors;
}


/**
 * Функция проверяет валидность файла на расширение JPEG
 *
 * @param $img_name array массив _FILES
 *
 * @return array
 */
function validate_file($img_name) {
    $errors = [];
    if ($img_name['tmp_name'] != null) {
        $finfo     = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $img_name['tmp_name']);

        if (mb_strpos ($file_type, 'image') === false) {
            $errors['img'] = 'Файл должен быть картинкой';

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
    $date_format = date("d.m.Y", strtotime($date['end_time']));
    if (preg_match($regexp, $date_format, $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[1], $parts[3]);
    }

    if ($result == false) {
        $errors['end_time'] = 'Неверная дата, введите дату в формате дд.мм.гггг';

        return $errors;
    }
    return $errors;
}


function validate_user ($user, $sum_email) {
    $required = ['email', 'password', 'name', 'contacts'];
    $errors   = [];

    foreach ($required as $key) {
        if (empty($user[$key])) {
            $errors[$key] = 'Заполните это поле';
        }
    }

    if (empty($errors['email'])) {
        if (mysqli_num_rows($sum_email) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'введите верный email';
        }
    }

    return $errors;
}
