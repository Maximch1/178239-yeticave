<?php

/**
 * Функция проводит проверку на ошибки формы добавления пользователя
 *
 * @param $link      mysqli Ресурс соединения
 * @param $user_data array массив данных из формы регистрации
 *
 * @return array массив ошибок
 */
function validate_user($link, $user_data)
{
    $errors = [];

    if ($error = validate_user_email($link, get_value($user_data, 'email'))) {
        $errors['email'] = $error;
    }

    if ($error = validate_user_password(get_value($user_data, 'password'))) {
        $errors['password'] = $error;
    }

    if ($error = validate_user_name(get_value($user_data, 'name'))) {
        $errors['name'] = $error;
    }

    if ($error = validate_user_contacts(get_value($user_data, 'contacts'))) {
        $errors['contacts'] = $error;
    }

    return $errors;
}

/**
 * Функция проверяет валидность email
 *
 * @param $link  mysqli Ресурс соединения
 * @param $email string email
 *
 * @return string|null текст ошибки
 */
function validate_user_email($link, $email)
{
    if (empty($email)) {
        return 'Введите email';
    }

    if (check_isset_email($link, $email)) {
        return 'Пользователь с этим email уже зарегистрирован';
    }

    if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Введите верный email';
    }

    return null;
}

/**
 * Функция проверяет валидность пароля
 *
 * @param $password string пароль
 *
 * @return string|null текст ошибки
 */
function validate_user_password($password)
{
    if (empty($password)) {
        return 'Введите пароль';
    }

    return null;
}

/**
 * Функция проверяет валидность имени пользователя
 *
 * @param $name string имя пользователя
 *
 * @return string|null текст ошибки
 */
function validate_user_name($name)
{
    if (empty($name)) {
        return 'Введите имя';
    }

    if (mb_strlen($name) > 50) {
        return 'Имя не должно превышать 50 символов';
    }

    return null;
}

/**
 * Функция проверяет валидность контактных данных
 *
 * @param $contacts string контактные данные
 *
 * @return string|null текст ошибки
 */
function validate_user_contacts($contacts)
{
    if (empty($contacts)) {
        return 'Напишите как с вами связаться';
    }

    if (mb_strlen($contacts) > 500) {
        return 'Имя не должно превышать 500 символов';
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
function validate_user_file_avatar($img_name)
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
