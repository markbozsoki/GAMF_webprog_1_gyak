<p>Üzenetek listázása</p>

<div>
    <!-- TODO: dinamikus linkek -->
    <a href="?page=messages&start=0&size=10">előző oldal</a>
    <a href="?page=messages&start=10&size=10">következő oldal</a>
</div>

<div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Küldve</th>
                <th>Küldő</th>
                <th>Email</th>
                <th>Tárgy</th>
                <th>Üzenet</th>
                <th>Id</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($PAGINATED_MESSAGE_DATA['data'] as $key => $message_data) { ?>
            <tr>
                <th><?= $PAGINATED_MESSAGE_DATA['start'] + (int)$key + 1 ?></th>
                <th><?= $message_data['sent_at'] ?></th>
                <th><?= $message_data['user_detail'] ?></th>
                <th><?= $message_data['email_address'] ?></th>
                <th><?= substr($message_data['subject'], 0, 20) . '...' ?></th>
                <th><?= substr($message_data['body'], 0, 20) . '...' ?></th>
                <th><a href="?page=messages&message=<?= $message_data['message_id'] ?>">Megtekintés</a></th>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
