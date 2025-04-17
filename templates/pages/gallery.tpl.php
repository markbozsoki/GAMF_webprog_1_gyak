<div id="gallery">
    <?php foreach ($images as $file => $date): ?>
        <div class="image">
            <a href="<?= $DIR . $file ?>">
            <img src="<?= $URL.$file ?>">
            </a>            
            <p>Név:  <?= $file; ?></p>
            <p>Dátum: <?= date($DATEFORM, $date) ?></p>
        </div>
    <?php endforeach; ?>
</div>
<?php
if (isset($_SESSION[''])) {
    include 'includes/gallery/form.inc.php';
}
?>
