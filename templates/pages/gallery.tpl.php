<div id="gallery">
    <?php foreach ($images as $file => $date): ?>
        <div class="image">
            <a href="<?= $DIR . $file ?>">
            <img src="<?= $URL.$file ?>">
            </a>            
            <p>Név:  <?= $file; ?></p>
            <p>Dátum: <?= date($DATEFORM, $date) ?></p>
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
