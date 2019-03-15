<?php

/**
 * Функция проверяет значение page на валидность
 *
 * @param $cur_page string запрошенная юзером страница
 *
 * @return string|null
 */
function validate_pagination_cur_page($cur_page)
{
    if ( ! $cur_page or ! ctype_digit((string)$cur_page)) {
        return $errors = 'Страница не задана';
    }

    return null;
}

/**
 * Функция проверяет существование запрошенной страницы
 *
 * @param $pages_count int общее количество страниц исходя из количества объектов
 * @param $cur_page    int запрошеная юзером страница
 *
 * @return string|null
 */
function validate_pagination_count($pages_count, $cur_page)
{
    if ($cur_page > $pages_count && $cur_page > 1) {
        return $errors = 'Ошибка пагинации';
    }

    return null;
}
