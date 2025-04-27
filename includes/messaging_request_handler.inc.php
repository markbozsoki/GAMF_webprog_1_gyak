<?php include('messaging_utils.inc.php');

// allow message sending only from the messaging page, '?page=messaging&new'
if (is_request_form_page($_GET, 'messaging') && isset($_GET['new'])) {
    try {
        $email_address = parse_email_address($_POST);
        if ($email_address === NULL) {
            load_page('messaging', 
                extra_headers: [
                    messaging_info_header('email address parse error'),
                ],
            );
        }

        $message_subject = parse_message_subject($_POST);
        if ($message_subject === NULL) {
            load_page('messaging', 
                extra_headers: [
                    messaging_info_header('subject parse error'),
                ],
            );
        }

        $message_body = parse_message_body($_POST);
        if ($message_body === NULL) {
            load_page('messaging', 
                extra_headers: [
                    messaging_info_header('body parse error'),
                ],
            );
        }

        $user_id = NULL;
        if (isset($_POST['username'])) {
            $username = parse_username($_POST);
            if ($username === NULL) {
                load_page('messaging', 
                    extra_headers: [
                        messaging_info_header('username parse error'),
                    ],
                );
            }

            if (!is_username_exists($username)) {
                load_error_page(500, 'no user found with this username ' . $username);
            }
            $user_id = get_user_id_by_username($username);
        }

        $new_message_meta_data = save_new_message($user_id, $email_address, $message_subject, $message_body);

        set_message_auth_session($new_message_meta_data['message_id']);

        //TODO: redirect to message viewer
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
        $message_data = extend_message_with_user_detail($message_data);

        load_message_viewer_page_on($message_data);
    } catch (PDOException $e) {
        load_error_page(500, 'SQL error ' . $e->getMessage());
    } catch (Exception $e) {
        load_error_page(500, $e->getMessage());
    }
}

?>
