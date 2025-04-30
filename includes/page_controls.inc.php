<?php

function is_request_form_page($GET_DATA, $page_name): bool {
    return isset($_GET['page']) && $_GET['page'] === $page_name;
}

function load_main_page() {
    global $page_datas;
    global $errors;

    $current_page_data = $page_datas['/']; // get main page data
    if (!file_exists($current_page_data['html_template'])) {
        load_error_page(500, 'missing index template'); // main page could not be loaded
    }
    include('./templates/index.tpl.php');
    exit();
}

function load_page($page_data_key, $extra_headers = NULL, $alert_message = NULL) {
    global $page_datas;
    global $errors;

    global $images;
    global $URL;

    if (!isset($page_datas[$page_data_key])) {
        load_error_page(400, 'unregistered page');
    }
    if(!file_exists($page_datas[$page_data_key]['html_template'])) {
        load_error_page(404, 'template could not be loaded');
    }

    // appends additional headers for page load
    if ($extra_headers === NULL) {
        $extra_headers = array();
    }
    array_push($extra_headers, create_custom_header('Loaded-Page', $page_data_key));
    foreach($extra_headers as $extra_header) {
        header(load_string_from_custom_header($extra_header));
    }

    $current_page_data = $page_datas[$page_data_key]; // retrieve requested page data
    
    // disable page specific JS to test server side validations, &js=disabled
    if (isset($_GET['js']) && $_GET['js'] === 'disabled') {
        unset($current_page_data['script_file']);
    }

    if ($alert_message) {
        $current_page_data['popup']['alert'] = $alert_message;
    }
    
    include('./templates/index.tpl.php');
    exit();
}

function redirect_to($path) {
    header('Location: ' . $path);
    exit();
}

function redirect_to_main_page() {
    redirect_to('.');
}

?>
