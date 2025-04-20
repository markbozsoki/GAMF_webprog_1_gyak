<?php declare(strict_types=1);
include('config.inc.php');

// 'error' query param for presenting error pages, usage: ?error=418
if (isset($_GET['error'])) {
    $error_code = $_GET['error'];
    if (!isset($errors[$error_code])) {
        load_error_page($errors['501'], 'the [' . $error_code . '] error page is not implemented!');
        return;
    }
    load_error_page($errors[$error_code], 'testing the [' . $error_code . '] error page');
    return;
}

// logout user on 'logout' query param and user logged in
if (isset($_GET['logout']) && is_user_logged_in()) {
    logout_user();
}

// login user on 'login' query param
if (isset($_GET['login'])) {
    if (is_user_logged_in()) {
        logout_user();
        load_error_page($errors['403']);
    }

    // check form data

    // check if username exists
    if (is_username_exists($current_username)) {

        // check that password is correct
        
        // get user detail

        // update session data
        set_user_login_session('Dummilton', 'Userling', 'dummy_user');
        //set_user_login_session($current_surname, $current_forename, $current_username);
    }
    unset($current_surname);
    unset($current_forename);
    unset($current_username);
}

// register new user on 'register' query param
if (isset($_GET['register'])) {
    if (is_user_logged_in()) {
        logout_user();
        load_error_page($errors['403']);
    }

    // check and validate form data 
    
    // check if username already exists
    if (!is_username_exists($new_username)) {

        // hash password

        // create new user

    }
    unset($new_surname);
    unset($new_forename);
    unset($new_username);
}

// retrieve page data by 'page' query param
if (isset($_GET['page'])) {
    $page_data_key = $_GET['page'];
    if (!isset($page_datas[$page_data_key])) {
        load_error_page($errors['400'], "unregistered page");
        return;
    }
    if(!file_exists($page_datas[$page_data_key]['html_template'])) {
        load_error_page($errors['404'], "template could not be loaded");
        return;
    }
    $current_page_data = $page_datas[$page_data_key]; // retrieve requested page data
    include('./templates/index.tpl.php');
    return;
}

// load main page
$current_page_data = $page_datas['/']; // get main page data
if (!file_exists($current_page_data['html_template'])) {
    load_error_page($errors['500'], 'missing index template'); // main page could not be loaded
    return;
}
include('./templates/index.tpl.php');

?>
