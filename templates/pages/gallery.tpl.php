<?php
    include(__DIR__ . '/../../include/gallery/image_gallery.inc.php');    
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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $current_page_data['title']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/gallery.css">
    <?php if(isset($current_page_data['style_file']) && file_exists($current_page_data['style_file'])) { ?>
    <?php echo '<link rel="stylesheet" href="' . $current_page_data['style_file'] . '">'; ?>
    <?php } ?>
</head>
<body>
    <div id="gallery">
    <?php
    arsort($images);
    
    foreach($images as $file => $date)
    {
    ?>
        <div class="image">
            <a href="<?= $DIR.$file ?>">
                <img src="<?= $DIR.$file ?>">
            </a>            
            <p>Név:  <?= $file; ?></p>
            <p>Dátum:  <?= date($DATEFORM, $date); ?></p>
        </div>
    <?php
    }
    ?>
    </div>
<div class="gallery-upload">
        <form action="include/gallery/upload.inc.php" method="post" enctype="multipart/form-data">
        <input type="text" name="filename" placeholder="Fájl neve...">
        <input type="text" name="filetitle" placeholder="Kép címe...">
        <input type="text" name="filedescription" placeholder="Leírás...">
        <input type="file" name="file" required>
        <input type="hidden" name="MAX_FILE_SIZE" value="512000">
        <button type="submit" name="submit">Feltöltés</button>
        </form>
    </div>
</body>
</html>