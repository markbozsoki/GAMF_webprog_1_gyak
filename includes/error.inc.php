<?php
function load_error_page($error) {
    header('HTTP/1.0 ' . $error['code'] . ' ' . $error['name']);
    include('./templates/error.tpl.php');
}

$errors = array(
    '404' => array(
        'code' => 404,
        'name' => 'Not Found',
        'title' => 'Az oldal nem található',
        'message' => 'A keresett oldal nem található...',
        'allow_redirect' => true,
    ),
    '500' => array(
        'code' => 500,
        'name' => 'Internal Server Error',
        'title' => 'Hiba',
        'message' => 'Az oldal nem tölthető be...',
        'allow_redirect' => false,
    ),
);
?>