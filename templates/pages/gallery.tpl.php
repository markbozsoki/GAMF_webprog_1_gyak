<?php
    include('./include/gallery/image_gallery.inc.php');    
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
<DOCTYPE! html>
<html>
<head>
    <meta charset="utf-8">
    <title>Galéria</title>
    <style >
 
    </style>
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
        <form action="logicals/gallery/upload.inc.php" method="post" enctype="multipart/form-data">
        <input type="text" name="filename" placeholder="Fájl neve...">
        <input type="text" name="filetitle" placeholder="Kép címe...">
        <input type="text" name="filedescription" placeholder="Leírás...">
        <input type="file" name="file">
        <button type="submit" name="submit">Feltöltés</button>
        </form>
    </div>
</body>
</html>