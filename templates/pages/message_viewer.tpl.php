<?php if ($parent_page_key === 'messaging') { ?>
<div>
    <h2>Köszönjük, hogy felvette velünk a kapcsolatot!</h2>
    <h3>Amint feldolgoztuk üzenetét, az ön által megadott e-mail címen fogjuk keresni.</h3>
</div>
<?php } ?>

<div>
    <h4><?= htmlspecialchars($message_data['subject']); ?></h4>
    <div>
        <p><?= $message_data['sent_at']; ?></p>
        <p><?= htmlspecialchars($message_data['user_detail']); ?></p>
        <p>E-mail: <a href="mailto:<?= htmlspecialchars($message_data['email_address']); ?>"><?= htmlspecialchars($message_data['email_address']); ?></a></p>
    </div>
    <pre><?= $message_data['body']; ?></pre>
</div>

<a href="<?= ($parent_page_key === '/') ? '.' : ('?page=' . $parent_page_key); ?>">Vissza</a>
