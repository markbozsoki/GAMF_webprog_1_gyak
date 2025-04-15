<?php
include('config.inc.php');

// retrieve page data by 'page' query param
if (isset($_GET['page'])) {
    $page_data_key = $_GET['page'];
    if (isset($page_datas[$page_data_key]) && file_exists($page_datas[$page_data_key]['html_template'])) {
        $current_page_data = $page_datas[$page_data_key]; // retrieve requested page data
        include('./templates/index.tpl.php');
    }
    else {
        header("HTTP/1.0 404 Not Found");
        include('./templates/404.tpl.php'); // load 404 template
    }
}
else {
    $current_page_data = current($page_datas); // retrieve main page data on load or current page by internal pointer ('/')
    if (file_exists($current_page_data['html_template'])) {
        include('./templates/index.tpl.php');
    }
    else {
        header("HTTP/1.0 500 Internal Server Error");
        include('./templates/500.tpl.php');
    }
}
?>
