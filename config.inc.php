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
<<<<<<< HEAD
        'title' => 'Galéria',
        'html_template' => './templates/pages/gallery.tpl.php', 
        'style_file' => './styles/pages/gallery.css',
        'script_file' => './scripts/pages/gallery.js',
=======
    'title' => 'Galéria',
    'html_template' => './templates/pages/gallery.tpl.php', 
    'style_file' => './styles/pages/gallery.css',
    'script_file' => './scripts/pages/gallery.js',
    ),
);

$errors = array(
    '404' => array(
        'code' => 404,
        'name' => 'Not Found',
        'title' => 'Az oldal nem található',
        'message' => 'A keresett oldal nem található...',
        'allow_redirect' => true,
    ),
    '500' => array(
        'code' => 500,
        'name' => 'Internal Server Error',
        'title' => 'Hiba',
        'message' => 'Az oldal nem tölthető be...',
        'allow_redirect' => false,
>>>>>>> 6e59a70ebbaeab612c3d400f2b5aa241541e4106
    ),
);
?>
