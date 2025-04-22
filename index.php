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
    array_push($extra_headers, custom_header('Loaded-Page', $page_data_key));
    foreach($extra_headers as $extra_header) {
        if (isset($extra_header['key']) && isset($extra_header['value'])) {
            header($extra_header['key'] . ': ' . $extra_header['value']);
        }
    }
    include('./templates/index.tpl.php');
}

function reload_login_page($extra_headers = NULL) {
    load_page('login', $extra_headers);
}

function custom_header($key, $value) {
    global $_HEADER_PREFIX;
    $key = $_HEADER_PREFIX . $key;
    return array(
        'key' => $key,
        'value' => $value,
    );
}

function login_info_header($message) {
    return custom_header('Login-Info', $message);
}

function registration_info_header($message) {
    return custom_header('Register-Info', $message);
}

/// ---------- 

// '?error=' query param for presenting error pages, usage: ?error=418
if (isset($_GET['error'])) {
    $error_code = $_GET['error'];
    if (!isset($errors[$error_code])) {
        load_error_page($errors['501'], 'the [' . $error_code . '] error page is not implemented!');
        return;
    }
    load_error_page($errors[$error_code], 'testing the [' . $error_code . '] error page');
    return;
}

// logout user on '?logout' query param and user logged in
if (isset($_GET['logout']) && is_user_logged_in()) {
    clear_user_login_session();
}

// login user on '?login' query param
if (isset($_GET['login'])) {
    if (is_user_logged_in()) {
        clear_user_login_session();
        load_error_page($errors['403']);
        return;
    }
    try {
        $username = parse_username($_POST);
        if ($username === NULL) {
            reload_login_page([
                login_info_header('username parse error'),
            ]);
            return;
        }
        $password_hash = parse_password_hash($_POST, 'current-password');
        if ($password_hash === NULL) {
            reload_login_page([
                login_info_header('password parse error'),
            ]);
            return;
        }

        if (!is_username_exists($username)) {
            reload_login_page([
                login_info_header('no username found'),
            ]);
            return;
        }

        // password verification
        if (!is_password_correct($username, $password_hash)) {
            reload_login_page([
                login_info_header('incorrect password'),
            ]);
            return;
        }
        
        // log in user (update session)
        $name_details = get_name_details_for_user($username);
        update_last_logged_in_time($username);
        set_user_login_session(
            $name_details['surname'], 
            $name_details['forename'],
            $username
        );
        header('Location: .');
        return;
    } catch (PDOException $e) {
        load_error_page($errors['500'], 'SQL error ' . $e->getMessage());
        return;
    } catch (Exception $e) {
        load_error_page($errors['500'], $e->getMessage());
        return;
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
        return;
    }
    try {
        $username = parse_username($_POST, 'new-username');
        if ($username === NULL) {
            reload_login_page([
                registration_info_header('username parse error'),
            ]);
            return;
        }
        $password_hash = parse_password_hash($_POST, 'new-password');
        if ($password_hash === NULL) {
            reload_login_page([
                registration_info_header('password parse error'),
            ]);
            return;
        }
        $surname = parse_surname($_POST);
        if ($surname === NULL) {
            reload_login_page([
                registration_info_header('surname parse error'),
            ]);
            return;
        }
        $forename = parse_forename($_POST);
        if ($forename === NULL) {
            reload_login_page([
                registration_info_header('forename parse error'),
            ]);
            return;
        }
        
        if (is_username_exists($new_username)) {
            reload_login_page([
                registration_info_header('username already taken'),
            ]);
            return;
        }

        register_new_user($username, $password_hash, $surname, $forename);
        reload_login_page([
            registration_info_header('registration complited'),
            custom_header('New-User-Registered', $username),
        ]);
        return;
    } catch (PDOException $e) {
        load_error_page($errors['500'], 'SQL error ' . $e->getMessage());
        return;
    } catch (Exception $e) {
        load_error_page($errors['500'], $e->getMessage());
        return;
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
    return;
}

// no query param were set, or fall through
$current_page_data = $page_datas['/']; // get main page data
if (!file_exists($current_page_data['html_template'])) {
    load_error_page($errors['500'], 'missing index template'); // main page could not be loaded
    return;
}
include('./templates/index.tpl.php');
?>
