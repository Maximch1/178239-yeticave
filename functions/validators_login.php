<?php

/**
 * Функция проводит проверку на ошибки формы входа
 * @param $link mysqli Ресурс соединения
 * @param $user_data array массив в _POST, который надо проверить
 *
 * @return array массив ошибок
 */
function validate_login ($user_data, $user_data_base) {
    $errors = [];
//    $base_user_data = check_isset_email($link, $user_data['email']);

    if ($error = validate_user_email($user_data['email'], $user_data_base)) {
        $errors['email'] = $error;
    }

    if ($error = validate_user_password($user_data['password'], $user_data_base['password'])) {
        $errors['password'] = $error;
    }
    return $errors;
}



function validate_user_email ($email, $user_data_base) {
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


function validate_user_password ($password, $password_base) {
    if (empty($password)) {
        return 'Введите пароль';
    }

    if (!password_verify($password, $password_base)) {
        return 'Вы ввели неверный пароль';
    }
    return null;
}
