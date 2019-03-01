<?php

/**
 * Функция проводит проверку на ошибки формы входа
 * @param $link mysqli Ресурс соединения
 * @param $user_data array массив в _POST, который надо проверить
 *
 * @return array массив ошибок
 */
function validate_login ($link, $user_data, $user_session)
{
    $errors = [];
//    $base_user_data = check_isset_email($link, $user_data['email']);

    if ($error = validate_user_email($link, $user_data['email'])) {
        $errors['email'] = $error;
    }

    if ($error = validate_user_password($link, $user_data['email'], $user_data['password'], $user_session)) {
        $errors['password'] = $error;
    }
    return $errors;
}


/**
 * Функция проверяет валидность email
 * @param $link mysqli Ресурс соединения
 * @param $email string email
 *
 * @return string|null текст ошибки
 */
function validate_user_email ($link, $email) {
    if (empty($email)) {
        return 'Введите email';
    }

    if (!check_isset_email($link, $email)) {
        return 'Пользователь не найден';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Введите верный email';
    }
    return null;
}

/**
 * Функция проверяет валидность пароля
 *
 * @param $link
 * @param $email
 * @param $password string пароль
 *
 * @param $user_session
 *
 * @return array|string|null
 */
function validate_user_password ($link, $email, $password, $user_session) {
    if (empty($password)) {
        return 'Введите пароль';
    }

    $user_data = check_isset_email($link, $email);
    if (password_verify($password, $user_data['password'])) {
        $user_session = $user_data;
        return $user_session;
    }
    return null;
}
