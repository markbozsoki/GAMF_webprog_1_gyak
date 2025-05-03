<p>Üzenetek listázása</p>

<div>
    <nav>
        <ul class="pagination">
            <li class="page-item <?= $PAGINATED_MESSAGE_DATA['start'] === 0 ? ' disabled' : '' ?>">
                <?php $prev_page_link = $PAGINATED_MESSAGE_DATA['link']['previous']; ?>
                <a class="page-link" href="<?= $prev_page_link ?>">
                    Előző oldal
                </a>
            </li>
            <li class="page-item <?= count($PAGINATED_MESSAGE_DATA['data']) < $PAGINATED_MESSAGE_DATA['size'] ? ' disabled' : '' ?>">
                <?php $next_page_link = $PAGINATED_MESSAGE_DATA['link']['next']; ?>
                <a class="page-link" href="<?= $next_page_link ?>">
                    Következő oldal
                </a>
            </li>
        </ul>
    </nav>
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
