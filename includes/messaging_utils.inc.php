<?php
const MAXIMUM_MESSAGE_LENGTH = 7495;

const DEFAULT_PAGINATION_START_INDEX = 0;
const MINIMUM_PAGINATION_PAGE_SIZE = 1;
const DEFAULT_PAGINATION_PAGE_SIZE = 10;
const MAXIMUM_PAGINATION_PAGE_SIZE = 100;

// TODO: implement param and data parsing

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

function parse_email_address($DATA, $key = 'email') {
    if (!isset($DATA[$key])){
        return NULL;
    }
    //TODO: parsing is not implemented yet
    $value = $DATA[$key];
}

function parse_message_id($DATA, $key = 'message_id') {
    if (!isset($DATA[$key])){
        return NULL;
    }
    $value = $DATA[$key];
    //TODO: parsing is not implemented yet
    return $value
}

// TODO: implement db commonication

function save_new_message($sender_id = NULL, $message_text): ?string {
    throw new Exception("[" . __FUNCTION__ . "] - Is Not Implemented Yet");
    
    $insert_new_message_template = "INSERT INTO MESSAGES  VALUES (default, default, :sender_id, UNIX_TIMESTAMP(NOW()), :message_text);"
    $insert_new_message_params = array(
        ':sender_id' => $sender_id,
        ':message_text' => $message_text,
    );

    $new_message_id_query_template = "SELECT "

    $data_access_layer = DataAccessLayerSingleton::getInstance();
    try {
        $data_access_layer->beginTransaction();
        
        $data_access_layer->executeCommand($insert_new_message_template, $insert_new_message_params);
        $data_access_layer->commit();

        $new_message_record_id = $data_access_layer->lastInsertId();
        
        $result = $data_access_layer->executeCommand($insert_user_record_template, $insert_user_record_params);
        
    } catch (Exception $e) {
        $data_access_layer->rollBack();
        throw $e;
    }
}

function is_message_exists($message_id) {
    throw new Exception("[" . __FUNCTION__ . "] - Is Not Implemented Yet");

}

function get_paginated_messages($start_index = DEFAULT_PAGINATION_START_INDEX, $page_size = DEFAULT_PAGINATION_PAGE_SIZE) {
    throw new Exception("[" . __FUNCTION__ . "] - Is Not Implemented Yet");
    if ($start_index < DEFAULT_PAGINATION_START) {
        $start_index = DEFAULT_PAGINATION_START;
    }
    if ($page_size < MINIMUM_PAGINATION_PAGE_SIZE) {
        $page_size = MINIMUM_PAGINATION_PAGE_SIZE
    }
    if ($page_size > MAXIMUM_PAGINATION_PAGE_SIZE) {
        $page_size = MAXIMUM_PAGINATION_PAGE_SIZE
    }

    $query_template = "SELECT msg_id, sender_id, from_unixtime(sent_at), msg_text FROM MESSAGES ORDER BY MESSAGES.sent_at DESC LIMIT :page_size OFFSET :start_index;";
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
    throw new Exception("[" . __FUNCTION__ . "] - Is Not Implemented Yet");

    if (!isset($message['sender_id'])) {
        throw new Exception("[" . __FUNCTION__ . "] - Missing sender_id from message: " . var_dump($message));
    }

    $user_detail_key = 'user_detail';
    if ($message['sender_id'] === NULL) {
        $message[$user_detail_key] = 'Vendég';
        return $messsage;
    }

    $query_template = "SELECT surname, forename FROM DETAILS WHERE id IN (SELECT detail_id FROM USERS WHERE id = :user_id);";
    $params = array(':user_id' => $message['sender_id']);

    $result = DataAccessLayerSingleton::getInstance()->executeCommand($query_template, $params);

    $message[$user_detail_key] = $result[''] . " " . $result[''] . " (" . $result[''] . ")";
    return $messsage;
}

?>
