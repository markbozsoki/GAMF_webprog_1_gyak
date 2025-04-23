<?php
function load_main_page() {
    global $errors;

    $current_page_data = $page_datas['/']; // get main page data
    if (!file_exists($current_page_data['html_template'])) {
        load_error_page($errors['500'], 'missing index template'); // main page could not be loaded
    }
    include('./templates/index.tpl.php');
    exit();
}

function load_page($page_data_key, $extra_headers = NULL) {
    global $page_datas;
    global $errors;

    if (!isset($page_datas[$page_data_key])) {
        load_error_page($errors['400'], "unregistered page");
    }
    if(!file_exists($page_datas[$page_data_key]['html_template'])) {
        load_error_page($errors['404'], "template could not be loaded");
    }

    $current_page_data = $page_datas[$page_data_key]; // retrieve requested page data
    
    if ($extra_headers === NULL) {
        $extra_headers = array();
    }
    array_push($extra_headers, create_custom_header('Loaded-Page', $page_data_key));
    foreach($extra_headers as $extra_header) {
        header(load_string_from_custom_header($extra_header));
    }
    include('./templates/index.tpl.php');
    exit();
}

function reload_login_page($extra_headers = NULL) {
    load_page('login', $extra_headers);
}

function redirect_to($path) {
    header('Location: ' . $path);
    exit();
}

function redirect_to_main_page() {
    redirect_to('.');
}

?>
