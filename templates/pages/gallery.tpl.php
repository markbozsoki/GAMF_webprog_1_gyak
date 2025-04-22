<div class="container my-5">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4" id="gallery">
        <?php foreach($images as $file => $date) { ?>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <a href="<?= $URL . $file ?>" target="_blank">
                <img src="<?= $URL . $file ?>" class="card-img-top img-fluid" alt="<?= $file ?>"
                style="height: 300px; object-fit: cover; object-position: center;">
                </a>
                <div class="card-body">
                    <h6 class="card-title mb-1"><?= htmlspecialchars($file) ?></h6>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>


<form id="uploadForm" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-light" style="max-width: 500px; margin: auto;">
    <div class="mb-3">
        <label for="filetitle" class="form-label">Kép címe</label>
        <input type="text" class="form-control" id="filetitle" name="filetitle" placeholder="Add meg a kép címét">
    </div>

    <div class="mb-3">
        <label for="filedescription" class="form-label">Leírás</label>
        <input type="text" class="form-control" id="filedescription" name="filedescription" placeholder="Add meg a leírást">
    </div>

    <div class="mb-3">
        <label for="file" class="form-label">Válassz képet /.jpg vagy .png</label>
        <input type="file" class="form-control" id="file" name="file" required>
    </div>

    <input type="hidden" name="MAX_FILE_SIZE" value="512000">

    <button type="submit" class="btn btn-primary w-100">Feltöltés</button>
</form>
