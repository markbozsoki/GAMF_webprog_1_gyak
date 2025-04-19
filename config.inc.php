<?php
// list of used includes
include('./includes/error.inc.php');
include('./includes/gallery/image_gallery.inc.php');


// collection of available page templates, styles and page spacific values
$page_datas = array(
    '/' => array(
        'title' => 'Főoldal',
        'html_template' => './templates/pages/main_page.tpl.php', 
        'style_file' => './styles/pages/main_page.css', // optional
        'script_file' => './scripts/pages/main_page.js', // optional
    ),
    'knifes' => array(
        'title' => 'Kések',
        'html_template' => './templates/pages/knifes.tpl.php', 
        'style_file' => './styles/pages/knifes.css',
        'script_file' => './scripts/pages/knifes.js',
    ),
    'gallery' => array(
        'title' => 'Galéria',
        'html_template' => './templates/pages/gallery.tpl.php', 
        'style_file' => './styles/pages/gallery.css',
        'script_file' => './scripts/pages/gallery.js',
    ),
);
?>
