<?php
date_default_timezone_set("Europe/Moscow");
$is_auth    = rand(0, 1);
$user_name  = 'Maxim';
$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
$lots       = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => $categories[0],
        'price' => 10999,
        'image' => 'img/lot-1.jpg'
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => $categories[0],
        'price' => 159999,
        'image' => 'img/lot-2.jpg'
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => $categories[1],
        'price' => 8000,
        'image' => 'img/lot-3.jpg'
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => $categories[2],
        'price' => 10999,
        'image' => 'img/lot-4.jpg'
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => $categories[3],
        'price' => 7500,
        'image' => 'img/lot-5.jpg'
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => $categories[5],
        'price' => 5400,
        'image' => 'img/lot-6.jpg'
    ]
];

require_once ('functions.php');

$content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots,
    'time_to_midnight' => time_to_midnight()
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Главная',
    'categories' => $categories
]);

print $layout;

