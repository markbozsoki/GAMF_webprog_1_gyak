<?php include('config.inc.php');

// feature level includes
include('./includes/image_gallery.inc.php');
include('./includes/login_request_handler.inc.php');
include('./includes/messaging_request_handler.inc.php');

// '?error=' query param for presenting error pages, usage: ?error=418
if (isset($_GET['error']) && ctype_digit($_GET['error']) && count($_GET) == 1) {
    global $errors;

    $error_code = (int)$_GET['error'];
    if (!isset($errors[$error_code])) {
        load_error_page(501, 'the [' . $error_code . '] error page is not implemented!');
    }
    load_error_page($error_code, 'testing the [' . $error_code . '] error page');
}

// retrieve page data by '?page=' query param
if (isset($_GET['page'])) {
    $page_data_key = $_GET['page'];
    load_page($page_data_key);
}

// no query param were set, or fall through
load_main_page();
?>
