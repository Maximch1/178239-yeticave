<?php

/**
 * Функция проводит проверку на ошибки формы входа
 * @param $user_data array массив с введенными юзером данными, который надо проверить
 * @param $user_data_base array массив с данными юзера с БД
 *
 * @return array массив ошибок
 */
function validate_login ($user_data, $user_data_base) {
    $errors = [];

    if ($error = validate_user_login_email(get_value($user_data,'email'), get_value($user_data_base,'email'))) {
        $errors['email'] = $error;
    }

    if ($error = validate_user_login_password(get_value($user_data,'password'), get_value($user_data_base,'password'))) {
        $errors['password'] = $error;
    }
    return $errors;
}


/**
 * Функция проверяет валидность email
 * @param $email string email, который ввел юзер, нужно проверить
 * @param $user_data_base string email с БД
 *
 * @return string|null выводит ошибку либо null
 */
function validate_user_login_email ($email, $user_data_base) {
    if (empty($email)) {
        return 'Введите email';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Введите верный email';
    }

    if (!$user_data_base) {
        return 'Пользователь не найден';
    }
    return null;
}


/**
 * Функция проверяет валидность пароля
 * @param $password string пароль, который ввел юзер, нужно проверить
 * @param $password_base string пароль с БД
 *
 * @return string|null выводит ошибку либо null
 */
function validate_user_login_password ($password, $password_base) {
    if (empty($password)) {
        return 'Введите пароль';
    }

    if (!password_verify($password, $password_base)) {
        return 'Вы ввели неверный пароль';
    }
    return null;
}
