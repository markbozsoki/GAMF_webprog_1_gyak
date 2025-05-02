<?php include('messaging_utils.inc.php');

// disallow the direct loading of the message viewer page, ?page=message_viewer
if (is_request_form_page($_GET, 'message_viewer')) {
    load_error_page(404, 'message viewer page should not be loaded directly');
}

// allow message sending only from the messaging page, '?page=messaging&new'
if (is_request_form_page($_GET, 'messaging') && isset($_GET['new'])) {
    try {
        $email_address = parse_email_address($_POST);
        if ($email_address === NULL) {
            load_page('messaging', 
                extra_headers: [
                    messaging_info_header('email address parse error'),
                ],
                alert_message: 'Az email cím formátuma nem megfelelő!',
            );
        }

        $message_subject = parse_message_subject($_POST);
        if ($message_subject === NULL) {
            load_page('messaging', 
                extra_headers: [
                    messaging_info_header('subject parse error'),
                ],
                alert_message: 'A tárgy formátuma nem megfelelő!',
            );
        }

        $message_body = parse_message_body($_POST);
        if ($message_body === NULL) {
            load_page('messaging', 
                extra_headers: [
                    messaging_info_header('body parse error'),
                ],
                alert_message: 'A szövegtörzs formátuma nem megfelelő!',
            );
        }

        $user_id = NULL;
        if (isset($_POST['username'])) {
            $username = parse_username($_POST);
            if ($username === NULL) {
                load_error_page(500, 'username parse error');
            }

            if (!is_username_exists($username)) {
                load_error_page(500, 'no user found with this username ' . $username);
            }
            $user_id = get_user_id_by_username($username);
        }

        $new_message_id = save_new_message($user_id, $email_address, $message_subject, $message_body);
        set_message_auth_session($new_message_id);
        redirect_to('?page=messaging&message=' . $new_message_id);
    } catch (PDOException $e) {
        load_error_page(500, 'SQL error ' . $e->getMessage());
    } catch (Exception $e) {
        load_error_page(500, $e->getMessage());
    }
}

// load messages with paginations
if (is_request_form_page($_GET, 'messages')) {
    if (!is_user_logged_in()) {
        clear_user_login_session();
        load_error_page(403, 'unauthorized access attempt to messages page');
    }
    try {
        $pagination_start = parse_pagination_start($_GET);
        $pagination_size = parse_pagination_size($_GET);
        if ($pagination_start === NULL || $pagination_size === NULL) {
            load_error_page(500, 'unable to parse pagination query params');
        }
        
        $message_datas = get_paginated_messages($pagination_start, $pagination_size);
        $paginated_message_data = array(
            'start' => $pagination_start,
            'size' => $pagination_size,
            'link' => array(
                'next' => get_next_link_for_pagination($pagination_start, $pagination_size),
                'prev' => get_previous_link_for_pagination($pagination_start, $pagination_size),
            ),
            'data' => $message_datas,
        );
        die(var_dump($paginated_message_data));

    } catch (PDOException $e) {
        load_error_page(500, 'SQL error ' . $e->getMessage());
    } catch (Exception $e) {
        load_error_page(500, $e->getMessage());
    }
}

// load message viewer page on '?message=' param if authorized
if (isset($_GET['message'])) {
    $message_id = parse_message_id($_GET);
    if (!is_user_logged_in() && !is_message_auth_session_valid($message_id)) {
        load_error_page(401, 'not authorized to view messages');
    }
    try {
        if (!message_exists($message_id)) {
            load_error_page(404, 'no message found with id ' . $message_id);
        }

        $message_data = get_message_by_message_id($message_id);
        load_message_viewer_page_on($message_data);
    } catch (PDOException $e) {
        load_error_page(500, 'SQL error ' . $e->getMessage());
    } catch (Exception $e) {
        load_error_page(500, $e->getMessage());
    }
}

?>
