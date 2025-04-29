<?php
function load_error_page(int $error_code, string $extra_message = NULL) {
    global $errors;

    $error = $errors[501]; // present 501 if requested error template not implemented
    if (isset($errors[$error_code])) {
        $error = $errors[$error_code];
    }

    if ($extra_message) { // send header with extra message
        header(get_error_message_header_value($extra_message));
    }
    header($_SERVER['SERVER_PROTOCOL'] . $error['code'] . ' ' . $error['name']);
    include('./templates/error.tpl.php');
    exit();
}

$errors = array(
    400 => array(
        'code' => 400,
        'name' => 'Bad Request',
        'title' => 'Hibás kérés',
        'message' => 'A megadott kérés nem teljesíthető..',
        'redirect_to_main_page' => TRUE,
    ),
    401 => array(
        'code' => 401,
        'name' => 'Unauthorized',
        'title' => 'Illetéktelen hozzáférés',
        'message' => 'Nem jogosult a tartalom megtekintésére..',
        'redirect_to_main_page' => TRUE,
    ),
    403 => array(
        'code' => 403,
        'name' => 'Forbidden',
        'title' => 'Hozzáférés megtagadva',
        'message' => 'Az esemény jelentve lett az oldal karbantartójának..',
        'redirect_to_main_page' => TRUE,
    ),
    404 => array(
        'code' => 404,
        'name' => 'Not Found',
        'title' => 'Az oldal nem található',
        'message' => 'A keresett oldal nem található...',
        'redirect_to_main_page' => TRUE,
    ),
    418 => array(
        'code' => 418,
        'name' => 'I\'m a teapot',
        'title' => 'Tea time!',
        'message' => 'Én egy teáskanna vagyok..',
        'redirect_to_main_page' => TRUE,
    ),
    500 => array(
        'code' => 500,
        'name' => 'Internal Server Error',
        'title' => 'Szerver hiba',
        'message' => 'Az oldal nem tölthető be...',
        'redirect_to_main_page' => FALSE,
    ),
    501 => array(
        'code' => 501,
        'name' => "Not Implemented",
        'title' => 'Oldal nem létezik',
        'message' => 'Ez az oldal nem áll rendelkezésre..',
        'redirect_to_main_page' => TRUE,
    ),
);
?>
