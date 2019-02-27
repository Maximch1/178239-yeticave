<?php


/**
 * Функция проводит проверку на ошибки: заполненность полей + проверка начальной цены и шаг ставки на числовой тип.
 * @param $lot_data array массив в _POST, который надо проверить
 *
 * @return array массив ошибок
 */
function validate_lot($lot_data) {
//    $required = ['title', 'description', 'category_id', 'price', 'end_time', 'step_rate'];
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



//    if ($error = validate_lot_end_time($lot_data['end_time'])) {
//        $errors['end_time'] = $error;
//    }

    return $errors;
}


/** Проверяет наименование лота
 * @param $title string название лота
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
 * @param $price string название лота
 * @return string|null текст ошибки
 */
function validate_lot_price($price) {
    if (empty($price)) {
        return 'Заполните начальную стоимость';
    }

    if (!is_numeric($price)) {
        return 'Значение должно быть числом';
    }

    if ($price > 1000000000) {
        return 'Сумма не должно превышать 1 000 000 000';
    }

    if ($price < 0) {
        return 'Цена не должна быть отрицательной';
    }
    return null;
}

function validate_lot_description($description) {
    if (empty($description)) {
        return 'Напишите описание лота';
    }

    if (mb_strlen($description) > 65535) {
        return 'Описание лота не должно превышать 65535 символов';
    }
    return null;
}

function validate_lot_category_id($category_id) {
    if (empty($category_id)) {
        return 'Выберите категорию';
    }
}

function validate_lot_step_rate($step_rate) {
    if (empty($step_rate)) {
        return 'Введите шаг ставки';
    }

    if (!is_numeric($step_rate)) {
        return 'Значение должно быть числом';
    }

    if ($step_rate > 1000000000) {
        return 'Шаг ставки не должен превышать 1 000 000 000';
    }

    if ($step_rate < 0) {
        return 'Шаг ставки не должен быть отрицательным';
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
 * @param $date string дата
 *
 * @return string
 */
//function check_date_format($date) {
//    return DateTime::createFromFormat('Y-m-d', $date) !== false;
//}
//
function validate_lot_end_time($end_time) {
    if (empty($end_time)) {
        return 'Заполните дату окончания лота';
    }
//
//    if (!check_date_format($end_time)) {
//        return 'Неверный формат даты';
//    }
}

