<?php declare(strict_types=1);
include('config.inc.php');

function load_page($page_data_key, $extra_headers = NULL) {
    global $page_datas;
    global $errors;

    if (!isset($page_datas[$page_data_key])) {
        load_error_page($errors['400'], "unregistered page");
        return;
    }
    if(!file_exists($page_datas[$page_data_key]['html_template'])) {
        load_error_page($errors['404'], "template could not be loaded");
        return;
    }

    $current_page_data = $page_datas[$page_data_key]; // retrieve requested page data
    
    if ($extra_headers === NULL) {
        $extra_headers = array();
    }
    array_push($extra_headers, create_custom_header('Loaded-Page', $page_data_key));
    foreach($extra_headers as $extra_header) {
        header(load_string_from_custom_header($extra_header));
    }
    include('./templates/index.tpl.php');
    exit();
}

function reload_login_page($extra_headers = NULL) {
    load_page('login', $extra_headers);
}

function redirect_to($path) {
    header('Location: ' . $path);
    exit();
}

function redirect_to_main_page() {
    redirect_to('.');
}

function create_custom_header($key, $value) {
    global $_HEADER_PREFIX;

    $key = $_HEADER_PREFIX . $key;
    return array(
        'key' => $key,
        'value' => $value,
    );
}

function load_string_from_custom_header($custom_header) {
    global $errors;

    if (!isset($custom_header['key']) || !isset($custom_header['value'])) {
        load_error_page($errors['500'], 'Custom header cannot be loaded');
    }
    return $custom_header['key'] . ': ' . $custom_header['value'];
}

function login_info_header($message) {
    return create_custom_header('Login-Info', $message);
}

function registration_info_header($message) {
    return create_custom_header('Register-Info', $message);
}

/// ---------- 

// '?error=' query param for presenting error pages, usage: ?error=418
if (isset($_GET['error'])) {
    $error_code = $_GET['error'];
    if (!isset($errors[$error_code])) {
        load_error_page($errors['501'], 'the [' . $error_code . '] error page is not implemented!');
    }
    load_error_page($errors[$error_code], 'testing the [' . $error_code . '] error page');
}

// logout user on '?logout' query param and user logged in
if (isset($_GET['logout']) && is_user_logged_in()) {
    clear_user_login_session();
}

// logout user and load 403 page on '?page=login', if user try to load the login page while logged in 
if (isset($_GET['page']) && $_GET['page'] == 'login' && is_user_logged_in()) {
    clear_user_login_session();
    load_error_page($errors['403']);
}

// login user on '?login' query param
if (isset($_GET['login'])) {
    if (is_user_logged_in()) {
        clear_user_login_session();
        load_error_page($errors['403']);
    }
    try {
        $username = parse_username($_POST);
        if ($username === NULL) {
            reload_login_page([
                login_info_header('username parse error'),
            ]);
        }
        $password_hash = parse_password_hash($_POST, 'current-password');
        if ($password_hash === NULL) {
            reload_login_page([
                login_info_header('password parse error'),
            ]);
        }

        if (!is_username_exists($username)) {
            reload_login_page([
                login_info_header('no registered username found'),
            ]);
        }

        // password verification
        if (!is_password_correct($username, $password_hash)) {
            reload_login_page([
                login_info_header('incorrect password'),
            ]);
        }
        
        // log in user (update session)
        $name_details = get_name_details_for_user($username);
        update_last_logged_in_time($username);
        set_user_login_session(
            $name_details['surname'], 
            $name_details['forename'],
            $username
        );
        redirect_to_main_page();
    } catch (PDOException $e) {
        load_error_page($errors['500'], 'SQL error ' . $e->getMessage());
    } catch (Exception $e) {
        load_error_page($errors['500'], $e->getMessage());
    } finally {
        unset($username);
        unset($password_hash);
        unset($name_details);
    }
}

// register new user on '?register' query param
if (isset($_GET['register'])) {
    if (is_user_logged_in()) {
        clear_user_login_session();
        load_error_page($errors['403']);
    }
    try {
        $username = parse_username($_POST, 'new-username');
        if ($username === NULL) {
            reload_login_page([
                registration_info_header('username parse error'),
            ]);
        }
        $password_hash = parse_password_hash($_POST, 'new-password');
        if ($password_hash === NULL) {
            reload_login_page([
                registration_info_header('password parse error'),
            ]);
        }
        $surname = parse_surname($_POST);
        if ($surname === NULL) {
            reload_login_page([
                registration_info_header('surname parse error'),
            ]);
        }
        $forename = parse_forename($_POST);
        if ($forename === NULL) {
            reload_login_page([
                registration_info_header('forename parse error'),
            ]);
        }
        
        if (is_username_exists($new_username)) {
            reload_login_page([
                registration_info_header('username already registered'),
            ]);
        }

        register_new_user($username, $password_hash, $surname, $forename);
        reload_login_page([
            registration_info_header('registration succeeded'),
            create_custom_header('New-User-Registered', $username),
        ]);
    } catch (PDOException $e) {
        load_error_page($errors['500'], 'SQL error ' . $e->getMessage());
    } catch (Exception $e) {
        load_error_page($errors['500'], $e->getMessage());
    } finally {
        unset($username);
        unset($password_hash);
        unset($surname);
        unset($forename);
    }
}

// retrieve page data by '?page=' query param
if (isset($_GET['page'])) {
    $page_data_key = $_GET['page'];
    load_page($page_data_key);
}

// no query param were set, or fall through
$current_page_data = $page_datas['/']; // get main page data
if (!file_exists($current_page_data['html_template'])) {
    load_error_page($errors['500'], 'missing index template'); // main page could not be loaded
}
include('./templates/index.tpl.php');
?>
