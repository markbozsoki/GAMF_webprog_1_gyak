<?php
$IMAGE_DIR_PATH = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/';
$IMG_MAX_SIZE = 500 * 1024;
$ALLOWED_MIME_TYPES = array('image/jpeg', 'image/jpg','image/png');
$message = ""; 

if (isset($_FILES['file'])) {
    $file = $_FILES['file'];

    if ($file['error'] == 4) {
        $message = "Nem töltöttél fel fájlt.";
    } elseif (
        $file['error'] == 1 ||
        $file['error'] == 2 ||
        $file['size'] > $IMG_MAX_SIZE
    ) {
        $message = "Túl nagy állomány: " . $file['name'];
    } elseif (!in_array($file['type'], $ALLOWED_MIME_TYPES)) {
        $message = "Nem megfelelő típus: " . $file['name'];
    } else {
        $new_image_file_path = $IMAGE_DIR_PATH . strtolower($file['name']);

        if (file_exists($new_image_file_path)) {
            $message = "Már létezik: " . $file['name'];
        } else {
            if (move_uploaded_file($file['tmp_name'], $new_image_file_path)) {
                $message = "Sikeres feltöltés: " . $file['name'] . " A kép megtekintéséhez frissítse az oldalt!";
            } else {
                $message = "Hiba történt a feltöltéskor.";
            }
        }
    }
}

echo $message; 
?>
