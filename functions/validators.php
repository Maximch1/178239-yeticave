<?php


/**
 * Функция проводит проверку на ошибки: заполненность полей + проверка начальной цены и шаг ставки на числовой тип.
 * @param $lots array массив в _POST, который надо проверить
 *
 * @return array
 */
function valid_lot($lots) {
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

    if (!isset($errors)) {
        return null;
    }
    return $errors;
}


/**
 * Функция проверяет валидность файла на расширение JPEG
 *
 * @param $img_name string массив _FILES
 * @param $errors
 *
 * @return mixed
 */
function valid_file($img_name, $errors) {
    if ($img_name != null) {
        $finfo     = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $img_name);
        if ($file_type !== "image/jpeg") {
            $errors['file'] = 'Загрузите картинку в формате JPEG';

            return $errors;
        }
        if (!isset($errors)) {
            return null;
        }
        return $errors;
    }
    else {
        $errors['file'] = 'Вы не загрузили файл';
        return $errors;
    }
}



