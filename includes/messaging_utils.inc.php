<?php
const MAXIMUM_MESSAGE_LENGTH = 7495;
const MAXIMUM_SUBJECT_LENGTH = 440;
const MAXIMUM_EMAIL_LENGTH = 250;

const DEFAULT_PAGINATION_START_INDEX = 0;
const MINIMUM_PAGINATION_PAGE_SIZE = 1;
const DEFAULT_PAGINATION_PAGE_SIZE = 10;
const MAXIMUM_PAGINATION_PAGE_SIZE = 100;

// TODO: implement param and data parsing

function parse_email_address($DATA, $key = 'email') {
    if (!isset($DATA[$key])){
        return NULL;
    }
    //TODO: parsing is not implemented yet
    $value = $DATA[$key];
    if (strlen($value) === 0 || strlen($value) > MAXIMUM_EMAIL_LENGTH) {
        return NULL;
    }
    return $value;
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

function parse_message_text($DATA, $key = 'message') {
    if (!isset($DATA[$key])){
        return NULL;
    }
    $value = $DATA[$key];
    if (strlen($value) === 0 || strlen($value) > MAXIMUM_MESSAGE_LENGTH) {
        return NULL;
    }
    return $value;
}

function parse_message_id($DATA, $key = 'message_id') {
    if (!isset($DATA[$key])){
        return NULL;
    }
    $value = $DATA[$key];
    //TODO: parsing is not implemented yet
    return $value;
}

function save_new_message($sender_id = NULL, $email_address, $subject_text, $message_text): ?string {    
    $insert_new_message_template = "INSERT INTO MESSAGES VALUES (default, default, :sender_id, UNIX_TIMESTAMP(NOW()), :email_address, :subject_text, :message_text);";
    $insert_new_message_params = array(
        ':sender_id' => $sender_id,
        ':email_address' => $email_address,
        ':subject_text' => $subject_text,
        ':message_text' => $message_text,
    );

    $new_message_id_query_template = "SELECT msg_id AS new_message_id FROM MESSAGES WHERE id = :new_message_record_id;";
    $new_message_id_params = array(
        ':new_message_record_id' => NULL,
    );

    $data_access_layer = DataAccessLayerSingleton::getInstance();
    try {
        $data_access_layer->beginTransaction();
        $data_access_layer->executeCommand($insert_new_message_template, $insert_new_message_params);
        $data_access_layer->commit();

        $new_message_record_id = $data_access_layer->lastInsertId();
        $new_message_id_params[':new_message_record_id'] = $new_message_record_id;
        
        $result = $data_access_layer->executeCommand($insert_user_record_template, $insert_user_record_params);
        if (!isset($result['new_message_id'])) {
            throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'new_message_id'!");
        }
        return $result['new_message_id'];
    } catch (Exception $e) {
        $data_access_layer->rollBack();
        throw $e;
    }
}

function is_message_exists($message_id): bool {
    $query_template = "SELECT count(username) AS message_exists FROM MESSAGES WHERE msg_id = :message_id;";
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

function get_paginated_messages($start_index = DEFAULT_PAGINATION_START_INDEX, $page_size = DEFAULT_PAGINATION_PAGE_SIZE) {
    if ($start_index < DEFAULT_PAGINATION_START) {
        $start_index = DEFAULT_PAGINATION_START;
    }
    if ($page_size < MINIMUM_PAGINATION_PAGE_SIZE) {
        $page_size = MINIMUM_PAGINATION_PAGE_SIZE;
    }
    if ($page_size > MAXIMUM_PAGINATION_PAGE_SIZE) {
        $page_size = MAXIMUM_PAGINATION_PAGE_SIZE;
    }

    $query_template = "SELECT * FROM MESSAGES ORDER BY MESSAGES.sent_at DESC LIMIT :page_size OFFSET :start_index;";
    $params = array(
        ':page_size' => $page_size,
        ':start_index' => $start_index,
    );

    $result = DataAccessLayerSingleton::getInstance()->executeCommand($query_template, $params);
    die(var_dump($result));
    if (FALSE) {
        return NULL;
    }
    return $result;
}

function extend_message_with_user_detail($message): array {
    if (!isset($message['sender_id'])) {
        throw new Exception("[" . __FUNCTION__ . "] - Missing sender_id from message: " . var_dump($message));
    }

    $user_detail_key = 'user_detail';
    if ($message['sender_id'] === NULL) {
        $message[$user_detail_key] = 'Vendég';
        return $messsage;
    }

    $query_template = "SELECT username, surname, forename FROM USER_DETAILS WHERE user_id = :user_id;";
    $params = array(':user_id' => $message['sender_id']);

    $result = DataAccessLayerSingleton::getInstance()->executeCommand($query_template, $params);
    if (!isset($result['username'])) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'username'!");
    }
    if (!isset($result['surname'])) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'surname'!");
    }
    if (!isset($result['forename'])) {
        throw new Exception("[" . __FUNCTION__ . "] - Query result does not contain 'forename'!");
    }

    $message[$user_detail_key] = $result['surname'] . " " . $result['forename'] . " (" . $result['username'] . ")";

    return $messsage;
}

function load_message_viewer_page_on($message_id) { 
    global $page_datas;
    global $errors;
    
    $current_page_data = $page_datas['message_viewer'];
    if (!is_message_exists($message_id)) {
        load_error_page($errors['404'], "message (" . $message_id . ") not found");
    }
    include('./templates/index.tpl.php');
    exit();
}

?>
