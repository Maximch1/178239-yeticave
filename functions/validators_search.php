<?php

/**
 * Функция проводит проверку на ошибки формы поиска
 *
 * @param $search string поисковый запрос
 *
 * @return array массив ошибок
 */
function validate_search ($search) {
    $errors = [];

    if ($error = validate_search_text ($search)) {
        $errors = $error;
    }
    return $errors;
}

/**
 * Функция проверяет поисковой запрос на валидность
 * @param $search string поисковой запрос
 *
 * @return string|null
 */
function validate_search_text ($search) {
    if (!$search) {
        return 'Задан пустой поисковый запрос';
    }

    if (mb_strlen($search, 'utf-8') < 3) {
        return 'Запрос должен содержать больше 3 символов';
    }
    return null;
}
