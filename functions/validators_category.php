<?php

/**
 * Функция выводит сообщение в случае отсутствия ID категории
 *
 * @param $category_id int ID категории
 *
 * @return string|null
 */
function validate_category($category_id)
{
    if ( ! $category_id) {
        return 'Не выбрана категория';
    }

    return null;
}
