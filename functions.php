<?php

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function format_price($price) {
    return number_format(ceil($price), 0, null, ' ') . "<b class=\"rub\">р</b>";
}

function time_to_end ($str_time) {
    $secs_to_end = strtotime($str_time) - time();
    if ($secs_to_end <= 0) {
        return '00:00';
    }
    $hours = sprintf("%'.02d", floor($secs_to_end / 3600));
    $minutes = sprintf("%'.02d", floor(($secs_to_end % 3600) / 60));
    return $hours.":".$minutes;
};

function db_connect ($config) {
    $link = mysqli_connect($config["host"], $config["user"], $config["password"], $config["database"]);
    if ($link == false) {
        die ("Ошибка подключения: " . mysqli_connect_error());
    }
    mysqli_set_charset($link, "utf8");
    return $link;
}

function get_categories($link) {
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($link, $sql);
    $category = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $category;
}

function get_lots($link) {
    $sql = "SELECT l.id, l.title AS name, c.title AS category, l.price AS price, l.image, l.end_time
             FROM lots l
             JOIN categories c ON c.id = l.category_id
             WHERE l.winner_id IS NULL";
    $result = mysqli_query($link, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $lots;
}

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

function insert_lot($link) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lots = $_POST['lot'];

        $filename     = uniqid() . '.jpg';
        $lots['path'] = 'img/' . $filename;
        move_uploaded_file($_FILES['lot_img']['tmp_name'], 'img/' . $filename);
        $sql = 'INSERT INTO lots (create_time, title, description, image, category_id, price, end_time, step_rate, user_id ) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, 1)';

        $stmt = db_get_prepare_stmt($link, $sql, [$lots['title'], $lots['description'], $lots['path'],  $lots['category'], $lots['price'], $lots['end_time'], $lots['step_rate']]);
        $res  = mysqli_stmt_execute($stmt);

        if ($res) {
            $lots_id = mysqli_insert_id($link);

            header("Location: lot.php?id=" . $lots_id);
        }
    }
}
