<?php
include('image_gallery.inc.php');
$DIR = realpath(__DIR__ . '/../../assets/images/') . '/';
$message = [];

if (isset($_FILES['file'])) {
    $file = $_FILES['file'];

    if ($file['error'] == 4) {
        $message[] = "Nem töltöttél fel fájlt.";
    } elseif (
        $file['error'] == 1 ||
        $file['error'] == 2 ||
        $file['size'] > $MAXSIZE
    ) {
        $message[] = "Túl nagy állomány: " . $file['name'];
    } elseif (!in_array($file['type'], $MEDIATYPE)) {
        $message[] = "Nem megfelelő típus: " . $file['name'];
    } else {
        $final = $DIR . strtolower($file['name']);

        if (file_exists($final)) {
            $message[] = "Már létezik: " . $file['name'];
        } else {
            if (move_uploaded_file($file['tmp_name'], $final)) {
                $message[] = "Sikeres feltöltés: " . $file['name'];
            } else {
                $message[] = "Hiba történt a feltöltéskor.";
            }
        }
    }
}