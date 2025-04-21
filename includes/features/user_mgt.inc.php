<?php
function is_username_exists($username): bool {
    $query_template = "SELECT count(username) AS username_exists FROM USERNAMES WHERE username = :username;";
    $params = array(':username' => $username);

    $result = DataAccessLayerSingleton::getInstance()::executeQuery($query_template, $params);
    if (!isset($result['username_exists'])) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'username_exists'!");
    }
    if ($result['username_exists'] > 1) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result indicates multiple user by this username (" . $username . ")!");
    }
    return (bool) $result['username_exists'];
}

function is_password_correct($username, $password_hash): bool {
    $query_template = "SELECT password_hash FROM ACCESS WHERE id IN (SELECT access_id FROM USERS WHERE username = :username);";
    $params = array(':username' => $username);

    $result = DataAccessLayerSingleton::getInstance()::executeQuery($query_template, $params);
    if (!isset($result['password_hash'])) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'password_hash'!");
    }
    if ($password_hash == $result['password_hash']) {
        return TRUE;
    }
    return FALSE;
}

function get_name_details_for_user($username): array {
    $query_template = "SELECT surname, forename FROM USER_DETAILS WHERE username = :username;";
    $params = array(':username' => $username);

    $result = DataAccessLayerSingleton::getInstance()::executeQuery($query_template, $params);
    if (!isset($result['surname'])) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'surname'!");
    }
    if (!isset($result['forename'])) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'forename'!");
    }
    if (count(array_keys($result)) !== 2) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result contains more keys than expected (" . print_r(array_keys($result)) . ")!");
    }
    return $result;
}

function update_last_logged_in_time($username) {
    $query_template = "UPDATE ACCESS SET last_logged_in = UNIX_TIMESTAMP(NOW()) WHERE id IN (SELECT access_id FROM USERS WHERE username = :username);";
    $params = array(':username' => $username);

    $result = DataAccessLayerSingleton::getInstance()::executeQuery($query_template, $params);
    return $result;
}

?>
