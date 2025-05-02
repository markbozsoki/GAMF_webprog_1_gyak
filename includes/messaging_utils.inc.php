<?php
const MAXIMUM_MESSAGE_LENGTH = 7000;
const MAXIMUM_SUBJECT_LENGTH = 400;
const MAXIMUM_EMAIL_LENGTH = 250;

const DEFAULT_PAGINATION_START_INDEX = 0;
const MINIMUM_PAGINATION_PAGE_SIZE = 1;
const DEFAULT_PAGINATION_PAGE_SIZE = 10;
const MAXIMUM_PAGINATION_PAGE_SIZE = 100;

const GET_MESSAGE_SQL_PROJECTION = "msg_id AS message_id, sender_id, from_unixtime(sent_at) AS sent_at, email_address, subject, msg_text AS body";


function parse_email_address($DATA, $key = 'email') {
    if (!isset($DATA[$key])){
        return NULL;
    }
    $value = $DATA[$key];
    if (strlen($value) === 0 || strlen($value) > MAXIMUM_EMAIL_LENGTH) {
        return NULL;
    }
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return NULL;
    }
    return "'" . $value . "'";
}

function parse_message_subject($DATA, $key = 'subject') {
    if (!isset($DATA[$key])){
        return NULL;
    }
    $value = $DATA[$key];
    if (strlen($value) === 0 || strlen($value) > MAXIMUM_SUBJECT_LENGTH) {
        return NULL;
    }
    return $value;
}

function parse_message_body($DATA, $key = 'body') {
    if (!isset($DATA[$key])){
        return NULL;
    }
    $value = $DATA[$key];
    if (strlen($value) === 0 || strlen($value) > MAXIMUM_MESSAGE_LENGTH) {
        return NULL;
    }
    return $value;
}

function parse_message_id($DATA, $key = 'message') {
    if (!isset($DATA[$key])){
        return NULL;
    }
    $value = $DATA[$key];
    if (!preg_match("/^[a-z0-9]*$/", $value)) {
        return NULL;
    }
    return $value;
}

function parse_pagination_start($DATA, $key = 'start'): ?int {
    if (!isset($DATA[$key])){
        return DEFAULT_PAGINATION_START_INDEX;
    }
    if (!ctype_digit($DATA[$key])) {
        return NULL;
    }
    $value = (int)$DATA[$key];
    if ($value < 0) {
        return DEFAULT_PAGINATION_START_INDEX;
    }
    return $value;
}

function parse_pagination_size($DATA, $key = 'size'): ?int {
    if (!isset($DATA[$key])){
        return DEFAULT_PAGINATION_PAGE_SIZE;
    }
    if (!ctype_digit($DATA[$key])) {
        return NULL;
    }
    $value = (int)$DATA[$key];
    if ($value < MINIMUM_PAGINATION_PAGE_SIZE) {
        return MINIMUM_PAGINATION_PAGE_SIZE;
    }
    if ($value > MAXIMUM_PAGINATION_PAGE_SIZE) {
        return MAXIMUM_PAGINATION_PAGE_SIZE;
    }
    return $value;
}

function encrypt_message_content($text) {
    return base64_encode($text); // base64 is a weak encoding, not a encryption (it was choosed only to demo the functionality)
}

function decrypt_message_content($text) {
    return base64_decode($text);
} 

function unpack_message_data($message_data) {
    $message_data['email_address'] = trim($message_data['email_address'], "'");
    $message_data['subject'] = decrypt_message_content($message_data['subject']);
    $message_data['body'] = decrypt_message_content($message_data['body']);
    return $message_data;
}

function extend_message_with_user_detail($message_data): array {
    if (!array_key_exists('sender_id', $message_data)) {
        throw new Exception("[" . __FUNCTION__ . "] - Missing sender_id key from message data");
    }

    $user_detail_key = 'user_detail';
    if ($message_data['sender_id'] === NULL) {
        $message_data[$user_detail_key] = 'Vendég';
        return $message_data;
    }

    $query_template = "SELECT username, surname, forename FROM USER_DETAILS WHERE user_id = :user_id;";
    $params = array(':user_id' => $message_data['sender_id']);

    $result = DataAccessLayerSingleton::getInstance()->executeCommand($query_template, $params);
    if (!isset($result['username'])) {
        $result['username'] = 'not_found';
    }
    if (!isset($result['surname'])) {
        $result['surname'] = 'Removed';
    }
    if (!isset($result['forename'])) {
        $result['forename'] = 'User';
    }

    $message_data[$user_detail_key] = $result['surname'] . " " . $result['forename'] . " (" . $result['username'] . ")";
    return $message_data;
}

function get_user_id_by_username($username) {
    $query_template = "SELECT id FROM USERS WHERE username = :username;";
    $params = array(':username' => $username);

    $result = DataAccessLayerSingleton::getInstance()->executeCommand($query_template, $params);
    if (!isset($result['id'])) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'id'!");
    }

    return $result['id'];
}

function save_new_message($sender_id, $email_address, $message_subject, $message_body): string {        
    $insert_new_message_template = "INSERT INTO MESSAGES VALUES (default, default, :sender_id, UNIX_TIMESTAMP(NOW()), :email_address, :message_subject, :message_body);";
    $insert_new_message_params = array(
        ':sender_id' => $sender_id,
        ':email_address' => $email_address, // email address should handled as sensitive data too (left uncrypted for presentation propuses)
        ':message_subject' => encrypt_message_content($message_subject),
        ':message_body' => encrypt_message_content($message_body),
    );

    $new_message_id_query_template = "SELECT msg_id AS new_message_id FROM MESSAGES WHERE id = :new_message_record_id;";
    $new_message_id_params = array(
        ':new_message_record_id' => NULL,
    );

    $data_access_layer = DataAccessLayerSingleton::getInstance();
    try {
        $data_access_layer->beginTransaction();
        
        $data_access_layer->executeCommand($insert_new_message_template, $insert_new_message_params);
        $new_message_record_id = $data_access_layer->lastInsertId();
        $new_message_id_params[':new_message_record_id'] = $new_message_record_id;

        $data_access_layer->commit();
        
        $result = $data_access_layer->executeCommand($new_message_id_query_template, $new_message_id_params);
        if (!isset($result['new_message_id'])) {
            throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'message_id'!");
        }
        return $result['new_message_id'];
    } catch (Exception $e) {
        $data_access_layer->rollBack();
        throw $e;
    }
}

function message_exists($message_id): bool {
    $query_template = "SELECT COUNT(msg_id) AS message_exists FROM MESSAGES WHERE msg_id = :message_id;";
    $params = array(':message_id' => $message_id);

    $result = DataAccessLayerSingleton::getInstance()->executeCommand($query_template, $params);
    if (!isset($result['message_exists'])) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'message_exists'!");
    }
    if ($result['message_exists'] > 1) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result indicates multiple messages by this message_id (" . $message_id . ")!");
    }
    return (bool) $result['message_exists'];
}


function get_message_by_message_id($message_id) {
    $query_template = "SELECT " . GET_MESSAGE_SQL_PROJECTION . " FROM MESSAGES WHERE msg_id = :message_id;";
    $params = array(':message_id' => $message_id);

    $result = DataAccessLayerSingleton::getInstance()->executeCommand($query_template, $params);
    $result = extend_message_with_user_detail($result);
    return unpack_message_data($result);
}

function get_paginated_messages($start_index = DEFAULT_PAGINATION_START_INDEX, $page_size = DEFAULT_PAGINATION_PAGE_SIZE) {
    if ($start_index < DEFAULT_PAGINATION_START_INDEX) {
        $start_index = DEFAULT_PAGINATION_START_INDEX;
    }
    if ($page_size < MINIMUM_PAGINATION_PAGE_SIZE) {
        $page_size = MINIMUM_PAGINATION_PAGE_SIZE;
    }
    if ($page_size > MAXIMUM_PAGINATION_PAGE_SIZE) {
        $page_size = MAXIMUM_PAGINATION_PAGE_SIZE;
    }

    $query_template = "SELECT " . GET_MESSAGE_SQL_PROJECTION . " FROM MESSAGES ORDER BY MESSAGES.sent_at DESC LIMIT :page_size OFFSET :start_index;";
    $prepared_statement = DataAccessLayerSingleton::getInstance()->getPreparedStatement($query_template);
    $prepared_statement->bindValue(':page_size', (int) $page_size, PDO::PARAM_INT);
    $prepared_statement->bindValue(':start_index', (int) $start_index, PDO::PARAM_INT);
    $prepared_statement->execute();
    $results = $prepared_statement->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}


function load_message_viewer_page_on($message_data) { 
    global $page_datas;
    
    $parent_page_key  = '/';
    if (isset($_GET['page'])) {
        $parent_page_key  = $_GET['page'];
    }
    $current_page_data = $page_datas['message_viewer'];
    include('./templates/index.tpl.php');
    exit();
}

?>
