    <?php if ($parent_page_key === 'messaging') { ?>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading text-center">Köszönjük, hogy felvette velünk a kapcsolatot!</h4>
        <p class="text-center">Amint feldolgoztuk üzenetét, az Ön által megadott e-mail címen fogjuk keresni.</p>
    </div>
    <?php } ?>

    <div class="d-flex justify-content-center">
        <div class="card w-50 p-3">
            <div class="card-body">
                <h4 class="card-title">
                    <?= htmlspecialchars($message_data['subject']); ?>
                </h4>
                <p class="card-subtitle mb-2 text-muted">
                    <?= $message_data['sent_at']; ?>
                </p>
                <p class="mb-1">
                    <?= htmlspecialchars($message_data['user_detail']); ?>
                </p>
                <p class="mb-3">E-mail:
                    <a href="mailto:<?= htmlspecialchars($message_data['email_address']); ?>">
                        <?= htmlspecialchars($message_data['email_address']); ?>
                    </a>
                </p>
                <pre class="bg-light p-3 rounded" 
                    style="white-space: pre-wrap; max-height: 300px; overflow-y: auto;">
                <?= htmlspecialchars($message_data['body']); ?></pre>
                <div class="text-center">
                    <a href="<?= ($parent_page_key === '/') ? '.' : ('?page=' . $parent_page_key); ?>"
                        class="btn btn-dark">
                        Vissza
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
