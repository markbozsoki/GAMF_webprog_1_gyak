<?php
const USRMGT_MAX_USERNAME_LENGTH = 25;
const USRMGT_PASSWORD_HASH_REQUIRED_LENGTH = 64;
const USRMGT_MAX_SURNAME_LENGTH = 35;
const USRMGT_MAX_FORENAME_LENGTH = 35;

function _parse_nonempty_string_with_max_length($DATA, $key, $max_length) {
    if (!isset($DATA[$key])){
        return NULL;
    }
    $value = $DATA[$key];
    if (strlen($value) === 0 || strlen($value) > $max_length) {
        return NULL;
    }
    return $value;
}

function parse_username($DATA, $key = 'username'): ?string {
    $username = _parse_nonempty_string_with_max_length($DATA, $key, USRMGT_MAX_USERNAME_LENGTH);
    return $username;
}

function parse_surname($DATA, $key = 'surname'): ?string {
    $surname = _parse_nonempty_string_with_max_length($DATA, $key, USRMGT_MAX_SURNAME_LENGTH);
    return $surname;
}

function parse_forename($DATA, $key = 'forename'): ?string {
    $forename = _parse_nonempty_string_with_max_length($DATA, $key, USRMGT_MAX_FORENAME_LENGTH);
    return $forename;
}

function parse_password_hash($DATA, $key = 'password'): ?string {
    if (!isset($DATA[$key])){
        return NULL;
    }
    $password_hash = $DATA[$key];
    if (strlen($password_hash) != USRMGT_PASSWORD_HASH_REQUIRED_LENGTH) {
        return hash('sha256', $password_hash); // hash password if not hashed
    }
    return $password_hash;
}

function is_username_exists($username): bool {
    $query_template = "SELECT count(username) AS username_exists FROM USERNAMES WHERE username = :username;";
    $params = array(':username' => $username);

    $result = DataAccessLayerSingleton::getInstance()->executeCommand($query_template, $params);
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

    $result = DataAccessLayerSingleton::getInstance()->executeCommand($query_template, $params);
    if (!isset($result['password_hash'])) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'password_hash'!");
    }
    return $password_hash === $result['password_hash'];
}

function get_name_details_for_user($username): array {
    $query_template = "SELECT surname, forename FROM USER_DETAILS WHERE username = :username;";
    $params = array(':username' => $username);

    $result = DataAccessLayerSingleton::getInstance()->executeCommand($query_template, $params);
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

    $result = DataAccessLayerSingleton::getInstance()->executeCommand($query_template, $params);
    return $result;
}

function register_new_user($username, $password_hash, $surname, $forename) {
    $insert_access_record_template = "INSERT INTO ACCESS VALUES (NULL, UNIX_TIMESTAMP(NOW()), '0', :password_hash);";
    $insert_access_record_params = array(
        ':password_hash' => $password_hash,
    );

    $insert_detail_record_template = "INSERT INTO DETAILS VALUES (NULL, :surname, :forename);";
    $insert_detail_record_params = array(
        ':surname' => $surname,
        ':forename' => $forename,
    );

    $insert_user_record_template = "INSERT INTO USERS VALUES (NULL, :username, UNIX_TIMESTAMP(NOW()), :access_id, :details_id);";
    $insert_user_record_params = array(
        ':username' => $username,
        ':access_id' => NULL,
        ':details_id' => NULL,
    );

    $data_access_layer = DataAccessLayerSingleton::getInstance();
    try {
        $data_access_layer->beginTransaction();
        
        $data_access_layer->executeCommand($insert_access_record_template, $insert_access_record_params);
        $insert_user_record_params[':access_id'] = $data_access_layer->lastInsertId();
        
        $data_access_layer->executeCommand($insert_detail_record_template, $insert_detail_record_params);
        $insert_user_record_params[':details_id'] = $data_access_layer->lastInsertId();
        
        $data_access_layer->executeCommand($insert_user_record_template, $insert_user_record_params);
        
        $data_access_layer->commit();
    } catch (Exception $e) {
        $data_access_layer->rollBack();
        throw $e;
    }
}

?>
