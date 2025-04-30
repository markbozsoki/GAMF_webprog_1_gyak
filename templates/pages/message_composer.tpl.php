<div class="container">
    <p>Üzenet küldés</p>
    <form id="messageComposerForm" class="needs-validation" action="?page=messaging&new" method="POST" novalidate>
        <?php if (is_user_logged_in()) { ?>
        <div class="form-group">
            <input type="hidden" name="username" value="<?= htmlspecialchars($_SESSION['username']) ?>">
        </div>
        <?php }?>

        <div class="form-group">

            <input type="text" class="form-control" id="email" name="email" placeholder="Email cím">
            <div class="invalid-feedback">
                Kérlek adj meg egy érvényes email címet!
            </div>
        </div>

        <div class="form-group">

            <input type="text" class="form-control" id="subject" name="subject" placeholder="Tárgy">
            <div class="invalid-feedback">
                Kérlek add meg a tárgyat!
            </div>
        </div>

        <div class="form-group">

            <textarea class="form-control" id="body" name="body" placeholder="Üzenet..." rows="12"></textarea>
            <div class="invalid-feedback">
                Kérlek írj egy rövid üzenetet!
            </div>
        </div>

        <button type="submit" class="btn btn-dark" name="send" value="1">Küldés</button>
    </form>
</div>
