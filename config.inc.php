<?php declare(strict_types=1);
session_start();

// global variables
$_HEADER_PREFIX = 'X-Knives-';

// system level includes
include('./includes/environment.inc.php');
include('./includes/error.inc.php');
include('./includes/image_gallery.inc.php');
include('./includes/session.inc.php');
include('./includes/data_access_layer.inc.php');

// feature level includes
include('./includes/gallery/image_gallery.inc.php');
include('./includes/user_mgt.inc.php');


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
