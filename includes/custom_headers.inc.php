<?php
$_HEADER_PREFIX = 'X-Knives-';

function create_custom_header($key, $value) {
    global $_HEADER_PREFIX;

    $key = $_HEADER_PREFIX . $key;
    return array(
        'key' => $key,
        'value' => $value,
    );
}

function load_string_from_custom_header($custom_header) {
    global $errors;

    if (!isset($custom_header['key']) || !isset($custom_header['value'])) {
        load_error_page($errors['500'], 'Custom header cannot be loaded');
    }
    return $custom_header['key'] . ': ' . $custom_header['value'];
}

function get_error_message_header_value($error_message): string {
    global $_HEADER_PREFIX;

    return $_HEADER_PREFIX . 'Error-Message: ' . $error_message;
}

function login_info_header($message) {
    return create_custom_header('Login-Info', $message);
}

function registration_info_header($message) {
    return create_custom_header('Register-Info', $message);
}

?>
