<?php
// system level includes
include('./includes/error.inc.php');
include('./includes/image_gallery.inc.php');
include('./includes/session.inc.php');

// feature level includes
include('./includes/gallery/image_gallery.inc.php');


// collection of available page templates, styles and page spacific values
$page_datas = array(
    '/' => array(
        'title' => 'Főoldal',
        'html_template' => './templates/pages/main_page.tpl.php', 
        'style_file' => './styles/pages/main_page.css', // optional
        'script_file' => './scripts/pages/main_page.js', // optional
    ),
    'knives' => array(
        'title' => 'Kések',
        'html_template' => './templates/pages/knives.tpl.php', 
        'style_file' => './styles/pages/knives.css',
        'script_file' => './scripts/pages/knives.js',
    ),
    'gallery' => array(
        'title' => 'Galéria',
        'html_template' => './templates/pages/gallery.tpl.php', 
        'style_file' => './styles/pages/gallery.css',
        'script_file' => './scripts/pages/gallery.js',
    ),
    'login' => array( // this should be the last item
        'title' => 'Bejelentkezés',
        'html_template' => './templates/pages/login.tpl.php',
        'style_file' => './styles/pages/login.css',
        'script_file' => './scripts/pages/login.js',
    ),
);
?>
