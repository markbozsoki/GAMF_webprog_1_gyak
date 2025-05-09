<div class="container my-5">
    <div class="row justify-content-center" id="gallery">
        <?php foreach($images as $file => $date) { ?>
        <div class="col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch">
            <div class="card bg-dark shadow-sm w-100">
                <a href="<?= $URL . $file ?>" target="_blank">
                    <img src="<?= $URL . $file ?>" class="card-img-top img-fluid custom-img" alt="<?= $file ?>">
                </a>
                <div class="card-body d-flex flex-column">
                    <p class="card-text small text-muted mb-2">
                        <?= htmlspecialchars($file) ?>
                    </p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php if (is_user_logged_in()): ?>
<form id="imageUploadForm" enctype="multipart/form-data">
    <div class="form-group">
        <label for="filetitle">Kép címe</label>
        <input type="text" class="form-control" id="filetitle" name="filetitle" placeholder="Add meg a kép címét">
    </div>

    <div class="form-group">
        <label for="filedescription" class="form-label">Leírás</label>
        <input type="text" class="form-control" id="filedescription" name="filedescription"
            placeholder="Add meg a leírást">
    </div>

    <div class="form-group">
        <label for="file" class="form-label">Válassz képet</label>
        <input type="file" class="form-control" id="file" name="file" required>
    </div>

    <input type="hidden" name="MAX_FILE_SIZE" value="512000">

    <button type="submit" class="btn btn-primary btn-block btn-dark">Feltöltés</button>
</form>
<?php endif; ?>
