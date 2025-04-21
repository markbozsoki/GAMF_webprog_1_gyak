<?php
function clear_user_login_session() {
    unset($_SESSION["surname"]);
    unset($_SESSION["forename"]);
    unset($_SESSION["username"]);
    unset($_SESSION["logged_in"]);
}

function set_user_login_session($surname, $forename, $username, $logged_in = TRUE) {
    $_SESSION["surname"] = $surname;
    $_SESSION["forename"] = $forename;
    $_SESSION["username"] = $username;
    $_SESSION['logged_in'] = $logged_in;
}

function is_user_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE;
}
?>
