<?php
function is_auth () {
    if (isset($_SESSION['user_id'])) {
        return true;
    }
    return false;
}
