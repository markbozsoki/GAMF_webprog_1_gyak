<?php
function logout_user() {
    unset($_SESSION["surname"]);
    unset($_SESSION["forename"]);
    unset($_SESSION["username"]);
    unset($_SESSION["logged_in"]);
}


?>