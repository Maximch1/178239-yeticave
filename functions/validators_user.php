<?php

function validate_user ($link, $user_data) {
    $errors   = [];

    if ($error = validate_user_email($link, $user_data['email'])) {
        $errors['email'] = $error;
    }

    if ($error = validate_user_password($user_data['password'])) {
        $errors['password'] = $error;
    }

    if ($error = validate_user_name($user_data['name'])) {
        $errors['name'] = $error;
    }

    if ($error = validate_user_contacts($user_data['contacts'])) {
        $errors['contacts'] = $error;
    }
    return $errors;
}

function validate_user_email ($link, $email) {
    if (empty($email)) {
        return 'Введите email';
    }

    if (check_isset_email($link, $email)) {
        return 'Пользователь с этим email уже зарегистрирован';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Введите верный email';
    }
    return null;
}

function validate_user_password ($password) {
    if (empty($password)) {
        return 'Введите пароль';
    }
    return null;
}

function validate_user_name ($name) {
    if (empty($name)) {
        return 'Введите имя';
    }
    return null;
}
function validate_user_contacts ($contacts) {
    if (empty($contacts)) {
        return 'Напишите как с вами связаться';
    }
    return null;
}
