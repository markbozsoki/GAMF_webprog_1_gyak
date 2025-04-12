<?php
include('config.inc.php');

// retrieve page data by 'page' query param
if (isset($_GET['page'])) {
    if (isset($pages[$_GET['page']]) && file_exists($pages[$_GET['page']]['html_template'])) {
        $current_page_data = $pages[$_GET['page']]; // retrieve requested page data
        include('./templates/index.tpl.php');
    }
    else {
        header("HTTP/1.0 404 Not Found");
        include('./templates/404.tpl.php'); // load 404 template
    }
}
else {
    $current_page_data = current($pages); // retrieve main page data on load or current page by internal pointer
    include('./templates/index.tpl.php');
}
?>
