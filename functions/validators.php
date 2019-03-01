<?php

/**
 * Функция проверяет валидность файла, файл должен быть изображением.
 *
 * @param $img_name array массив _FILES
 *
 * @return array
 */
function validate_file($img_name) {
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



