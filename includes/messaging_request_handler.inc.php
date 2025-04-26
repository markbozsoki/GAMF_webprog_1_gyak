<?php include('messaging_utils.inc.php');

// allow message sending only from the messaging page, '?page=messaging'
if (is_request_form_page($_GET, 'messaging')) {

    //TODO: parse and validate message data

    //TODO: save new message to database

    //TODO: save message_id to session data

    //TODO: redirect to message viewer

}

// load message viewer page on '?message=' param if authorized
if (isset($_GET['message'])) {
    $message_id = parse_message_id($_GET);
    if (!is_user_logged_in() && !is_message_auth_session_valid($message_id)) {
        load_error_page($errors['401'], 'not authorized to view messages');
    }
    try {
        if (!message_exists($message_id)) {
            load_error_page($errors['404'], 'no message found with id ' . $message_id);
        }

        $message_data = get_message_by_message_id($message_id);
        $message_data = extend_message_with_user_detail($message_data);

        load_message_viewer_page_on($message_data);
    } catch (PDOException $e) {
        load_error_page($errors['500'], 'SQL error ' . $e->getMessage());
    } catch (Exception $e) {
        load_error_page($errors['500'], $e->getMessage());
    }
}

?>
