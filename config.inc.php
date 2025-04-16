<?php
$page_datas = array( // collection of available page templates, styles and page spacific values
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
);
?>
