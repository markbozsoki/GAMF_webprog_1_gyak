<div class="container">
    <?php $prev_page_button_disabled = $PAGINATED_MESSAGE_DATA['start'] === 0 ?>
    <?php $next_page_button_disabled = count($PAGINATED_MESSAGE_DATA['data']) < $PAGINATED_MESSAGE_DATA['size'] ?>

    <nav>
        <ul class="pagination">
            <li class="page-item <?= $prev_page_button_disabled ? ' disabled' : '' ?>">
                <?php $prev_page_link = $PAGINATED_MESSAGE_DATA['link']['previous']; ?>
                <a class="page-link" href="<?= $prev_page_link ?>">
                    Előző oldal
                </a>
            </li>
            <li class="page-item <?= $next_page_button_disabled ? ' disabled' : '' ?>">
                <?php $next_page_link = $PAGINATED_MESSAGE_DATA['link']['next']; ?>
                <a class="page-link" href="<?= $next_page_link ?>">
                    Következő oldal
                </a>
            </li>
        </ul>
    </nav>

    <table class="table table- m-1">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Küldve</th>
                <th scope="col">Küldő</th>
                <th scope="col">Email</th>
                <th scope="col">Tárgy</th>
                <th scope="col">Üzenet</th>
                <th scope="col">Link</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($PAGINATED_MESSAGE_DATA['data'] as $key => $message_data) { ?>
            <tr>
                <th scope="row">
                    <?php echo $PAGINATED_MESSAGE_DATA['start'] + (int)$key + 1 ?>
                </th>
                <td>
                    <?php echo $message_data['sent_at'] ?>
                </td>
                <td>
                    <?php echo $message_data['user_detail'] ?>
                </td>
                <td>
                    <?php echo $message_data['email_address'] ?>
                </td>
                <td>
                    <?php $visible_subject_text_length = 20 ?>
                    <?php echo substr($message_data['subject'], 0, $visible_subject_text_length) . (strlen($message_data['subject']) < $visible_subject_text_length ? '' : '...') ?>
                </td>
                <td>
                    <?php $visible_body_text_length = 25 ?>
                    <?php echo substr($message_data['body'], 0, $visible_body_text_length) . (strlen($message_data['body']) < $visible_body_text_length ? '' : '...') ?>
                </td>
                <td>
                    <a href="<?= $PAGINATED_MESSAGE_DATA['link']['current'] ?>&message=<?= $message_data['message_id'] ?>">
                        Megtekintés
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <nav class="md-3">
        <ul class="pagination">
            <li class="page-item <?= $prev_page_button_disabled ? ' disabled' : '' ?>">
                <?php $prev_page_link = $PAGINATED_MESSAGE_DATA['link']['previous']; ?>
                <a class="page-link" href="<?= $prev_page_link ?>">
                    Előző oldal
                </a>
            </li>
            <li class="page-item <?= $next_page_button_disabled ? ' disabled' : '' ?>">
                <?php $next_page_link = $PAGINATED_MESSAGE_DATA['link']['next']; ?>
                <a class="page-link" href="<?= $next_page_link ?>">
                    Következő oldal
                </a>
            </li>
        </ul>
    </nav>
</div>

