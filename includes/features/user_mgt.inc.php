<?php
function is_username_exists($username): bool {
    try {
        $query_template = "SELECT count(username) AS username_exists FROM USERNAMES WHERE username = :username";
        $params = array(':username' => $username);

        $data_access_layer = DataAccessLayerSingleton::getInstance();
        $prepared_statement = $data_access_layer->prepare($query_template);
        $prepared_statement->execute($params);
        $result = $prepared_statement->fetch(PDO::FETCH_ASSOC);

        return (bool) $result['username_exists'];
    }
    catch (Exception $e) {
        load_error_page($errors['500'], $e->getMessage());
    }
}
?>
