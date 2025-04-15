<?php declare(strict_types=1);
include('config.inc.php');

function load_error_page($error) {
    header('HTTP/1.0 ' . $error['code'] . ' ' . $error['name']);
    include('./templates/error.tpl.php');
}

// retrieve page data by 'page' query param
if (isset($_GET['page'])) {
    $page_data_key = $_GET['page'];
    if (isset($page_datas[$page_data_key]) && file_exists($page_datas[$page_data_key]['html_template'])) {
        $current_page_data = $page_datas[$page_data_key]; // retrieve requested page data
        include('./templates/index.tpl.php');
    }
    else {
        load_error_page($errors['404']); // requested page not found
    }
}
else {
    $current_page_data = $page_datas['/']; // retrieve main page data (no query param)
    if (file_exists($current_page_data['html_template'])) {
        include('./templates/index.tpl.php');
    }
    else {
        load_error_page($errors['500']); // main page could not be loaded
    }
}
?>