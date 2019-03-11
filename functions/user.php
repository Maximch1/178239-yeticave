<?php
/**
 * Функция проверяет авторизирован юзер или нет
 * @return bool
 */
function is_auth () {
    if (get_value($_SESSION,'user_id')) {
        return true;
    }
    return false;
}
