<?php declare(strict_types=1);
session_start();

// system level includes
include('./includes/environment.inc.php');
include('./includes/error.inc.php');
include('./includes/custom_headers.inc.php');
include('./includes/session.inc.php');
include('./includes/page_controls.inc.php');
include('./includes/data_access_layer.inc.php');


// collection of available page templates, styles and page spacific values
$page_datas = array(
    '/' => array(
        'title' => 'Főoldal',
        'html_template' => './templates/pages/main_page.tpl.php', 
        'style_file' => './styles/pages/main_page.css', // optional
        'script_file' => './scripts/pages/main_page.js', // optional
        'accessibility' => array(
            'show_when_logged_in' => TRUE,
            'show_when_logged_out' => TRUE,
        ),
    ),
    'knives' => array(
        'title' => 'Kések',
        'html_template' => './templates/pages/knives.tpl.php', 
        'style_file' => './styles/pages/knives.css',
        'script_file' => './scripts/pages/knives.js',
        'accessibility' => array(
            'show_when_logged_in' => TRUE,
            'show_when_logged_out' => TRUE,
        ),
    ),
    'gallery' => array(
        'title' => 'Galéria',
        'html_template' => './templates/pages/gallery.tpl.php', 
        'style_file' => './styles/pages/gallery.css',
        'script_file' => './scripts/pages/gallery.js',
        'accessibility' => array(
            'show_when_logged_in' => TRUE,
            'show_when_logged_out' => TRUE,
        ),
    ),
    'messaging' => array(
        'title' => 'Kapcsolat',
        'html_template' => './templates/pages/message_composer.tpl.php', 
        'style_file' => './styles/pages/message_composer.css',
        'script_file' => './scripts/pages/message_composer.js',
        'accessibility' => array(
            'show_when_logged_in' => TRUE,
            'show_when_logged_out' => TRUE,
        ),
    ),
    'message_viewer' => array(
        'title' => 'Üzenet',
        'html_template' => './templates/pages/message_viewer.tpl.php', 
        'style_file' => './styles/pages/message_viewer.css',
        'script_file' => './scripts/pages/message_viewer.js',
        'accessibility' => array(
            'show_when_logged_in' => FALSE,
            'show_when_logged_out' => FALSE,
        ),
    ),
    'messages' => array(
        'title' => 'Üzenetek',
        'html_template' => './templates/pages/messages.tpl.php', 
        'style_file' => './styles/pages/messages.css',
        'script_file' => './scripts/pages/messages.js',
        'accessibility' => array(
            'show_when_logged_in' => TRUE,
            'show_when_logged_out' => FALSE,
        ),
    ),
    'login' => array( // this should be the last item
        'title' => 'Bejelentkezés',
        'html_template' => './templates/pages/login.tpl.php',
        'style_file' => './styles/pages/login.css',
        'script_file' => './scripts/pages/login.js',
        'accessibility' => array(
            'show_when_logged_in' => FALSE,
            'show_when_logged_out' => TRUE,
        ),
    ),
);
?>
