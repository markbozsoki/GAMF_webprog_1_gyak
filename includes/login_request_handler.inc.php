<?php include('login_utils.inc.php');

// load 403 page on '?logout', if user try to the logout while logged out
if (isset($_GET['logout']) && !is_user_logged_in()) {
    load_error_page(403, 'unauthorized logout request');
}

// logout user on '?logout' query param, if user logged in
if (isset($_GET['logout']) && is_user_logged_in()) {
    clear_user_login_session();
    redirect_to_main_page();
}

// logout user and load 403 page on '?page=login', if user try to load the login page while logged in 
if (is_request_form_page($_GET, 'login') && is_user_logged_in()) {
    clear_user_login_session();
    load_error_page(403, 'unauthorized access attempt to login page');
}

// login user on '?login' query param
if (isset($_GET['login'])) {
    if (is_user_logged_in()) {
        clear_user_login_session();
        load_error_page(403, 'unauthorized login request');
    }
    try {
        $username = parse_username($_POST);
        $password_hash = parse_password_hash($_POST, 'current-password');

        if ($username === NULL || $password_hash === NULL) {
            $parse_error_headers = [];
            if (!$password_hash) {
                $parse_error_headers[] = login_info_header('password parse error');
            }
            if (!$username) {
                $parse_error_headers[] = login_info_header('username parse error');
            }
            load_page('login', 
                extra_headers: $parse_error_headers,
                alert_message: 'A bejelnkezési adatok formátuma nem megfelelő!',
            );
        }

        if (!is_username_exists($username)) {
            load_page('login', 
                extra_headers: [
                    login_info_header('no registered username found'),
                ],
                alert_message: 'A megadott felhasználónév helytelen!',
            );
        }

        // password verification
        if (!is_password_correct($username, $password_hash)) {
            load_page('login', 
                extra_headers: [
                    login_info_header('incorrect password'),
                ],
                alert_message: 'A megadott jelszó helytelen!',
            );
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
        load_error_page(500, 'SQL error ' . $e->getMessage());
    } catch (Exception $e) {
        load_error_page(500, $e->getMessage());
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
        load_error_page(403, 'unauthorized registration request');
    }
    try {
        $username = parse_username($_POST);
        if ($username === NULL) {
            load_page('login', 
                extra_headers: [
                    registration_info_header('username parse error'),
                ],
                alert_message: 'A felhasználónév formátuma nem megfelelő!',
            );
        }
        $password_hash = parse_password_hash($_POST, 'new-password');
        if ($password_hash === NULL) {
            load_page('login', 
                extra_headers: [
                    registration_info_header('password parse error'),
                ],
                alert_message: 'A jelszó formátuma nem megfelelő!',
            );
        }
        $surname = parse_surname($_POST);
        if ($surname === NULL) {
            load_page('login', 
                extra_headers: [
                    registration_info_header('surname parse error'),
                ],
                alert_message: 'A vezetéknév formátuma nem megfelelő!',
            );
        }
        $forename = parse_forename($_POST);
        if ($forename === NULL) {
            load_page('login', 
                extra_headers: [
                    registration_info_header('forename parse error'),
                ],
                alert_message: 'Az utónév formátuma nem megfelelő!',
            );
        }
        
        if (is_username_exists($username)) {
            load_page('login', 
                extra_headers: [
                    registration_info_header('username already registered'),
                ],
                alert_message: 'Felhasználónév \"' . $username . '\" már foglalt!',
            );
        }

        register_new_user($username, $password_hash, $surname, $forename);
        load_page('login', 
            extra_headers: [
                registration_info_header('registration succeeded'),
                create_custom_header('New-User-Registered', $username),
            ],
            alert_message: 'Sikeres regisztráció!',
        );
    } catch (PDOException $e) {
        load_error_page(500, 'SQL error ' . $e->getMessage());
    } catch (Exception $e) {
        load_error_page(500, $e->getMessage());
    } finally {
        unset($username);
        unset($password_hash);
        unset($surname);
        unset($forename);
    }
}

?>
