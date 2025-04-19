<?php
function logout_user() {
    unset($_SESSION["surname"]);
    unset($_SESSION["forename"]);
    unset($_SESSION["username"]);
    unset($_SESSION["logged_in"]);
}

function is_user_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == TRUE;
}

?>