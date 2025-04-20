<?php
function load_error_page($error, $extra_message = '') {
    $header_message = $error['name'];
    if ($extra_message) {
        $header_message = $header_message . ': ' . $extra_message;
    }
    header('HTTP/1.0 ' . $error['code'] . ' ' . $header_message);
    include('./templates/error.tpl.php');
}

$errors = array(
    '400' => array(
        'code' => 400,
        'name' => 'Bad Request',
        'title' => 'Hibás kérés',
        'message' => 'A megadott kérés nem teljesíthető..',
        'redirect_to_main_page' => TRUE,
    ),
    '403' => array(
        'code' => 403,
        'name' => 'Forbidden',
        'title' => 'Hozzáférés megtagadva',
        'message' => 'Az esemény jelentve lett az oldal karbantartójának..',
        'redirect_to_main_page' => FALSE,
    ),
    '404' => array(
        'code' => 404,
        'name' => 'Not Found',
        'title' => 'Az oldal nem található',
        'message' => 'A keresett oldal nem található...',
        'redirect_to_main_page' => TRUE,
    ),
    '418' = array(
        'code' => 418
        'name' => "I'm a teapot",
        'title' => 'Tea time!',
        'message' => 'Én egy teáskanna vagyok..',
        'redirect_to_main_page' => TRUE,
    )
    '500' => array(
        'code' => 500,
        'name' => 'Internal Server Error',
        'title' => 'Hiba',
        'message' => 'Az oldal nem tölthető be...',
        'redirect_to_main_page' => FALSE,
    ),
);
?>
