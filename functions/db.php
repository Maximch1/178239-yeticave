<?php

/**
 * Функция производит соединение с базой SQL по параметрам, указанным в файле config.php
 * @param $config array
 *
 * @return mysqli
 */
function db_connect ($config) {
    $link = mysqli_connect($config["host"], $config["user"], $config["password"], $config["database"]);

    if (!$link) {
        die ("Ошибка подключения: " . mysqli_connect_error());
    }

    mysqli_set_charset($link, "utf8");
    return $link;
}

/**
 * Функция возвращает список категорий.
 * аргумент - соединение с базой.
 *
 * @param $link mysqli Ресурс соединения
 *
 * @return array|null
 */
function get_categories($link) {
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($link, $sql);
    $category = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $category;
}

/**
 * Функция возвращает список открытых лотов
 * аргумент - соединение с базой.
 *
 * @param $link mysqli Ресурс соединения
 *
 * @return array|null
 */
function get_lots($link) {
    $sql = "SELECT l.id, l.title AS name, c.title AS category, l.price AS price, l.image, l.end_time
             FROM lots l
             JOIN categories c ON c.id = l.category_id
             WHERE l.winner_id IS NULL";
    $result = mysqli_query($link, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $lots;
}

/**
 * Функция возвращает данные по одному лоту. необходимо указать ID лота.
 * @param $link mysqli Ресурс соединения
 * @param $lot_id string ID лота
 *
 * @return array|null
 */
function get_lot($link, $lot_id) {
    $sql = "SELECT l.id, l.title AS name, c.title AS category, l.price AS price, l.image, l.end_time, l.description, l.step_rate,  MAX(b.rate) AS max_rate
             FROM lots l
             JOIN categories c ON c.id = l.category_id
             JOIN bets b ON l.id = b.lot_id
             WHERE l.winner_id IS NULL AND l.id = " . $lot_id . " ORDER BY l.id DESC;";
    $result = mysqli_query($link, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (!isset($lots[0]['max_rate'])) {
        $lots[0]['max_rate'] = $lots[0]['price'];
    }

    if (!isset($lots[0])) {
        return null;
    }
    return $lots[0];
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }
    return $stmt;
}

/**
 * Функция добавляет лот в базу SQL, возвращает id добавленного лота
 * @param $link mysqli Ресурс соединения
 * @param $lots array массив в _POST
 *
 * @return int|null
 */
function insert_lot ($link, $lots) {
    $sql = 'INSERT INTO lots (create_time, title, description, image, category_id, price, end_time, step_rate, user_id ) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, 1)';

    $stmt = db_get_prepare_stmt($link, $sql, [$lots['title'], $lots['description'], $lots['img'],  $lots['category_id'], $lots['price'], $lots['end_time'], $lots['step_rate']]);
    mysqli_stmt_execute($stmt);
    $lot_id = mysqli_insert_id($link);

    if (!$lot_id) {
        return null;
    }
    return $lot_id;
}

/**
 * Функция производит поиск в базе users по полю email, если находит, то возвращает количество найденных записей.
 * @param $link mysqli Ресурс соединения
 * @param $email string email
 *
 * @return int количество email
 */
function check_isset_email ($link, $email) {
    $email = mysqli_real_escape_string($link, $email);
    $sql   = "SELECT id FROM users WHERE email = '$email'";
    $res   = mysqli_query($link, $sql);

    return mysqli_num_rows($res);
}

/**
 * Функция добавляет юзера в базу SQL, возвращает id добавленного юзера
 * @param $link mysqli Ресурс соединения
 * @param $user array массив в _POST
 *
 * @return int|null
 */
function insert_user ($link, $user) {
    $password = password_hash($user['password'], PASSWORD_DEFAULT);
    $sql = 'INSERT INTO users (email, name, password, contacts, avatar) VALUES (?, ?, ?, ?, ?)';

    $stmt = db_get_prepare_stmt($link, $sql, [$user['email'], $user['name'], $password, $user['contacts'], $user['avatar']]);
    mysqli_stmt_execute($stmt);
    $user_id = mysqli_insert_id($link);

    if (!$user_id) {
        return null;
    }
    return $user_id;
}
