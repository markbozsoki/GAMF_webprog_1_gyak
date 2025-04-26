<?php include('messaging_utils.inc.php');

// allow message sending only from the messaging page, '?page=messaging'
if (is_request_form_page($_GET, 'messaging')) {

    //TODO: parse and validate message data

    //TODO: save new message to database

    //TODO: save message_id to session data

    //TODO: redirect to message viewer

}

// load message viewer page on '?message_id=' param if authorized
if (isset($_GET['message_id'])) {
    $message_id = parse_message_id($_GET);
    if (!is_user_logged_in() && !is_message_auth_session_valid($message_id)) {
        // load 401 error page
    }
    try {
        if (is_message_exists($message_id)) {
            // load 403 error page
        }

        // TODO: get message data from db

        // TODO: load message viewer page

    } catch (PDOException $e) {
        //load_error_page($errors['500'], 'SQL error ' . $e->getMessage());
    } catch (Exception $e) {
        //load_error_page($errors['500'], $e->getMessage());
    }

}

?>
