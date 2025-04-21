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
    clear_user_login_session();
}

// login user on 'login' query param
if (isset($_GET['login'])) {
    if (is_user_logged_in()) {
        clear_user_login_session();
        load_error_page($errors['403']);
        return;
    }
    try {
        if (!isset($_POST['username'])){
            // send back notification (reload login page)
        }
        if (!isset($_POST['current-password'])){
            // send back notification (reload login page)
        }
        
        $username = $_POST['username'];
        if (!is_username_exists($username)) {
            // send back notification (reload login page)
        }

        // password verification
        if (!is_password_correct($username, $_POST['current-password'])) {
            // send back notification (reload login page)
        }
        
        // log in user (update session)
        $name_details = get_name_details_for_user($username);
        update_last_logged_in_time($user);
        set_user_login_session(
            $name_details['surname'], 
            $name_details['forename'],
            $username
        );
    } catch (Exception $e) {
        load_error_page($errors['500'], $e->getMessage());
        return;
    } finally {
        unset($username);
        unset($name_details);
    }
}

// register new user on 'register' query param
if (isset($_GET['register'])) {
    if (is_user_logged_in()) {
        clear_user_login_session();
        load_error_page($errors['403']);
        return;
    }
    try {
        // check and validate form data
        
        // check if username already exists
        if (is_username_exists($new_username)) {

        }

        // hash password

        // create new user
    } catch (Exception $e) {
        load_error_page($errors['500'], $e->getMessage());
        return;
    } finally {
        unset($new_surname);
        unset($new_forename);
        unset($new_username);
    }
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
