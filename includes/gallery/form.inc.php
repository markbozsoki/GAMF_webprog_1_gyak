<div class="gallery-upload container">
    <form action="includes/gallery/upload.inc.php" method="post" enctype="multipart/form-data" class="row g-3 gallery-upload-form">
        <div class="col-12">
            <input type="text" name="filename" class="form-control" placeholder="Fájl neve...">
        </div>
        <div class="col-12">
            <input type="text" name="filetitle" class="form-control" placeholder="Kép címe...">
        </div>
        <div class="col-12">
            <input type="text" name="filedescription" class="form-control" placeholder="Leírás...">
        </div>
        <div class="col-12">
            <input type="file" name="file" class="form-control" required>
        </div>
        <input type="hidden" name="MAX_FILE_SIZE" value="512000">
        <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary w-100">Feltöltés</button>
        </div>
    </form>
</div>
