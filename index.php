<?php declare(strict_types=1);
include('config.inc.php');

// autologin for debugging
$_SESSION["surname"] = 'Dummilton';
$_SESSION["forename"] = 'Userling';
$_SESSION["username"] = 'dummy_user';
$_SESSION['logged_in'] = TRUE;

// logout user on 'logout' query param and user logged in
if (isset($_GET['logout']) && is_user_logged_in()) {
    logout_user();
}

// login user on 'login' query param
if (isset($_GET['login'])) {
    if (is_user_logged_in()) {
        logout_user();
    }

    // check form data

    // check if username exists

    // check that password is correct
    
    // get user detail

    // update session data
    set_user_login_session($surname, $forename, $username);
}

// register new user on 'register' query param
if (isset($_GET['register'])) {
    if (is_user_logged_in()) {
        logout_user();
    }

    // check and validate form data 
    
    // check if username already exists

    // hash password

    // create new user

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
