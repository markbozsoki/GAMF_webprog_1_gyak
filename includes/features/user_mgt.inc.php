<?php
function is_username_exists($username): bool {
    try {
        $query_template = "SELECT count(username) AS username_exists FROM USERNAMES WHERE username = :username;";
        $params = array(':username' => $username);

        $data_access_layer = DataAccessLayerSingleton::getInstance();
        $prepared_statement = $data_access_layer->prepare($query_template);
        $prepared_statement->execute($params);
        $result = $prepared_statement->fetch(PDO::FETCH_ASSOC);
        if (!isset($result['username_exists'])) {
            throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'username_exists'!");
        }
        return (bool) $result['username_exists'];
    }
    catch (Exception $e) {
        load_error_page($errors['500'], $e->getMessage());
    }
}

function is_password_correct($username, $password_hash): bool {
    try {
        
        $query_template = "SELECT password_hash FROM ACCESS WHERE id IN (SELECT access_id FROM USERS WHERE username = :username);";
        $params = array(':username' => $username);

        $data_access_layer = DataAccessLayerSingleton::getInstance();
        $prepared_statement = $data_access_layer->prepare($query_template);
        $prepared_statement->execute($params);
        $result = $prepared_statement->fetch(PDO::FETCH_ASSOC);
        if (!isset($result['password_hash'])) {
            throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'password_hash'!");
        }
        if ($password_hash == $result['password_hash']) {
            return TRUE;
        }
        return FALSE;
    }
    catch (Exception $e) {
        load_error_page($errors['500'], $e->getMessage());
    }
}

function get_user_name_details($username): array {
    try {
        
        $query_template = "SELECT surname, forename FROM USER_DETAILS WHERE username = :username;";
        $params = array(':username' => $username);

        $data_access_layer = DataAccessLayerSingleton::getInstance();
        $prepared_statement = $data_access_layer->prepare($query_template);
        $prepared_statement->execute($params);
        $result = $prepared_statement->fetch(PDO::FETCH_ASSOC);
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
    catch (Exception $e) {
        load_error_page($errors['500'], $e->getMessage());
    }
}

?>
