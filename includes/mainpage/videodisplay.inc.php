<div class="container mt-5">
  <div class="row">
    <div class="col-md-6 mb-4">
      <h4 class="text-center"><?= $videos['local']['title'] ?></h4>
      <div class="ratio ratio-16x9 custom-video">
        <video controls class="w-100 rounded">
          <source src="<?= $videos['local']['src'] ?>" type="video/mp4">
          A böngésző nem támogatja a videó lejátszását.
        </video>
      </div>
    </div>

    <div class="col-md-6 mb-4">
      <h4 class="text-center"><?= $videos['youtube']['title'] ?></h4>
      <div class="ratio ratio-16x9 custom-video">
        <iframe src="<?= $videos['youtube']['src'] ?>" class="w-100 rounded" allowfullscreen></iframe>
      </div>
    </div>
</div>