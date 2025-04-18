<?php
$DIR = realpath(__DIR__ . '/../../assets/images/') . '/';
$URL = '/assets/images/';
$TYPES = array ('.jpg', '.png');
$DATEFORM = "Y.m.d. H:i";
$MEDIATYPE = array('image/jpeg', 'image/png');
$MAXSIZE = 500*1024;

$images = array();
$reader = opendir($DIR);
while (($file = readdir($reader)) !== false) {
    if (is_file($DIR.$file)) {
        $end = strtolower(substr($file, strlen($file)-4));
        if (in_array($end, $TYPES)) {
            $images[$file] = filemtime($DIR.$file);
        }
    }
}
closedir($reader);
arsort($images); 
?>