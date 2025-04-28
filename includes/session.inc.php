<?php
function clear_user_login_session() {
    unset($_SESSION['surname']);
    unset($_SESSION['forename']);
    unset($_SESSION['username']);
    unset($_SESSION['logged_in']);
}

function set_user_login_session($surname, $forename, $username, $logged_in = TRUE) {
    $_SESSION['surname'] = $surname;
    $_SESSION['forename'] = $forename;
    $_SESSION['username'] = $username;
    $_SESSION['logged_in'] = $logged_in;
}

function is_user_logged_in(): bool {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === TRUE;
}

function clear_message_auth_session() {
    unset($_SESSION['message_auth_key']);
}

function _generate_message_id_auth_key($message_id): string {
    if (getenv('MSG_ID_SALT') == NULL || getenv('MSG_ID_PEPPER') == NULL) {
        throw new Exception('MSG_ID_SALT and MSG_ID_PEPPER must be set!');
    }
    $_search = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $replace = ['i', "'", 'm', 'a', 't', 'e', '@', 'p', 'o', '!']; // RCF2324 based string suffle
    $shuffled_message_id = str_replace($_search, $replace, $message_id);
    return hash('md5', getenv('MSG_ID_SALT') . $shuffled_message_id . getenv('MSG_ID_PEPPER'));
}

function set_message_auth_session($message_id) {
    if (!isset($message_id) || !is_string($message_id)) {
        return;
    }
    $mesage_auth_keys = array();
    if (isset($_SESSION['message_auth_key'])) {
        $mesage_auth_keys = $_SESSION['message_auth_key'];
    }
    array_push($mesage_auth_keys, _generate_message_id_auth_key($message_id));
    $_SESSION['message_auth_key'] = $mesage_auth_keys;
}

function is_message_auth_session_valid($message_id): bool {
    if (!isset($_SESSION['message_auth_key'])) {
        return FALSE;
    }
    if (!is_array($_SESSION['message_auth_key'])) {
        return FALSE;
    }
    if (count($_SESSION['message_auth_key']) === 0) {
        return FALSE;
    }

    foreach ($_SESSION['message_auth_key'] as $message_auth_key) {
        if ($message_auth_key === _generate_message_id_auth_key($message_id)) {
            return TRUE;
        }
    }
    return FALSE;
}
?>
