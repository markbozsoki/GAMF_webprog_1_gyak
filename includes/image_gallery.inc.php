<?php
$DIR = realpath('assets/images/') . '/';
$URL = '/assets/images/';
$SUPPORTED_EXTENSIONS = array ('.jpg', '.png', '.jpeg');
$images = array();
$reader = opendir($DIR);

while (($file = readdir($reader)) !== false) {
    if (is_file($DIR.$file)) {
        $extension = '.' . strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($extension, $SUPPORTED_EXTENSIONS)) {
            $images[$file] = filemtime($DIR.$file);
        }
    }
}
closedir($reader);
arsort($images); 
?>
