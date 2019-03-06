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
    $sql = "SELECT l.id, l.title AS name, c.title AS category, l.price AS price, l.image, l.end_time, l.description, l.step_rate,  MAX(b.rate) AS max_rate, l.user_id
             FROM lots l
             JOIN categories c ON c.id = l.category_id
             JOIN bets b ON l.id = b.lot_id
             WHERE l.winner_id IS NULL AND l.id = " . $lot_id . " ORDER BY l.id DESC;";
    $result = mysqli_query($link, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (!isset($lots[0]['max_rate'])) {
        $lots[0]['max_rate'] = $lots[0]['price'];
    }

    if (!isset($lots[0]['id'])) {
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
 *
 * @param $link mysqli Ресурс соединения
 * @param $lots array массив в _POST
 * @param $user_id int ID юзера
 *
 * @return int|null
 */
function insert_lot ($link, $lots, $user_id) {
    $sql = 'INSERT INTO lots (create_time, title, description, image, category_id, price, end_time, step_rate, user_id ) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';

    $stmt = db_get_prepare_stmt($link, $sql, [$lots['title'], $lots['description'], $lots['img'],  $lots['category_id'], $lots['price'], $lots['end_time'], $lots['step_rate'], $user_id]);
    mysqli_stmt_execute($stmt);
    $lot_id = mysqli_insert_id($link);

    if (!$lot_id) {
        return null;
    }
    return $lot_id;
}

/**
 * Функция производит поиск в базе users по полю email, если находит, то возвращает количество найденных записей.
 *
 * @param $link mysqli Ресурс соединения
 * @param $email string email юзера
 *
 * @return int
 */
function check_isset_email ($link, $email) {
    $email = mysqli_real_escape_string($link, $email);
    $sql   = "SELECT id FROM users WHERE email = '$email'";
    $res   = mysqli_query($link, $sql);
    return mysqli_num_rows($res);
}

/**
 * Функция производит поиск в базе users по полю email, если находит, то возвращает данные пользователя.
 * @param $link mysqli Ресурс соединения
 * @param $email string email юзера
 *
 * @return array|null
 */
function get_user_by_email ($link, $email) {
    $email = mysqli_real_escape_string($link, $email);
    $sql   = "SELECT * FROM users WHERE email = '$email'";
    $res   = mysqli_query($link, $sql);

    $user_data = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
    return $user_data;
}

/**
 * Функция производит поиск в базе users по ID, если находит, то возвращает данные пользователя.
 * @param $link mysqli Ресурс соединения
 * @param $id int ID юзера
 *
 * @return array|null
 */
function get_user_by_id ($link, $id) {
    $sql   = 'SELECT * FROM users WHERE id = ' . (int)$id;
    $res   = mysqli_query($link, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!$user) {
        return null;
    }
    return $user;
}

/**
 * Функция добавляет юзера в базу SQL, возвращает id добавленного юзера
 * @param $link mysqli Ресурс соединения
 * @param $user array массив в _POST
 *
 * @return int|null возвращает все данные пользователя с БД
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

/**
 * Функция производит поиск ставок по ID лота, возвращает данные пользователей и сделанные ими ставки сортируя по дате создания ставки с лимитом в 10 последних записей.
 * @param $link mysqli Ресурс соединения
 * @param $lot_id int ID ставки
 *
 * @return array|null
 */
function get_bets_by_lot_id ($link, $lot_id) {
    $sql = 'SELECT b.id, b.user_id, u.name, b.rate, b.create_time, DATE_FORMAT(b.create_time, "%d.%m.%y в %H:%i") AS format_create_time 
            FROM bets b JOIN users u ON b.user_id = u.id WHERE b.lot_id = ' . (int)$lot_id . ' ORDER BY create_time DESC LIMIT 10;';
    $res = mysqli_query($link, $sql);
    $bet = $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : null;
    return $bet;
}


/**
 * Функция добавляет ставку в базу SQL, возвращает id добавленной ставки
 * @param $link mysqli Ресурс соединения
 * @param $rate int ставка
 * @param $user_id int ID юзера
 * @param $lot_id int ID лота
 *
 * @return int|string|null
 */
function insert_bet ($link, $rate, $user_id, $lot_id) {
    $sql = 'INSERT INTO bets (rate, user_id, lot_id) VALUES (?, ?, ?)';

    $stmt = db_get_prepare_stmt($link, $sql, [$rate, $user_id, $lot_id]);
    mysqli_stmt_execute($stmt);
    $bet_id = mysqli_insert_id($link);

    if (!$bet_id) {
        return null;
    }
    return $bet_id;
}

/**
 * Функция возвращает список лотов по поисковому запросу
 * аргумент - соединение с базой.
 *
 * @param $link   mysqli Ресурс соединения
 * @param $search string значение поиска
 * @param $page_items int количество лотов на странице
 * @param $offset int количество смещенных лотов
 *
 * @return array|null
 */
function get_search_lots($link, $search, $page_items, $offset) {
    $search = mysqli_real_escape_string($link, $search);
    $sql = 'SELECT l.id, l.title AS name, c.title AS category, l.price AS price, l.image, l.end_time, l.winner_id
             FROM lots l
             JOIN categories c ON c.id = l.category_id
             WHERE MATCH(l.title, l.description) AGAINST(? IN BOOLEAN MODE) AND l.winner_id IS NULL ORDER BY l.id DESC LIMIT ' . $page_items . ' OFFSET ' . $offset;
    $stmt = db_get_prepare_stmt($link, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $lots;
}


/**
 * Функция выводит массив с номерами всех страниц
 * @param $link mysqli Ресурс соединения
 * @param $search string значение поиска
 *
 * @return array
 */
function get_search_count_lot ($link, $search) {
    $search = mysqli_real_escape_string($link, $search);
    $result = mysqli_query($link, "SELECT COUNT(*) as cnt FROM lots WHERE MATCH(title, description) AGAINST ('$search' IN BOOLEAN MODE) AND winner_id IS NULL;");
    $items_count = mysqli_fetch_assoc($result)['cnt'];
    return $items_count;
}

function update_lot_winner (){

}
