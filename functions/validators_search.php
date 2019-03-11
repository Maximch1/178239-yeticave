<?php

/**
 * Функция проверяет поисковой запрос на валидность
 * @param $search string поисковой запрос
 *
 * @return string|null
 */
function validate_search ($search) {
    if (!$search) {
        return 'Задан пустой поисковый запрос';
    }

    if (mb_strlen($search, 'utf-8') < 3) {
        return 'Запрос должен содержать больше 3 символов';
    }
    return null;
}
