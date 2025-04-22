<?php
$DIR = realpath('assets/images/') . '/';
$URL = '/assets/images/';
$SUPPORTED_EXTENSIONS = array ('.jpg', '.png');
$images = array();
$reader = opendir($DIR);

while (($file = readdir($reader)) !== false) {
    if (is_file($DIR.$file)) {
        $end = strtolower(substr($file, strlen($file)-4));
        if (in_array($end, $SUPPORTED_EXTENSIONS)) {
            $images[$file] = filemtime($DIR.$file);
        }
    }
}
closedir($reader);
arsort($images); 
?>
