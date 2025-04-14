<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $current_page_data['title']; ?></title>

    <?php if(isset($current_page_data['style_file']) && file_exists($current_page_data['style_file'])) { ?>
    <?php echo '<link rel="stylesheet" href="' . $current_page_data['style_file'] . '">'; ?>
    <?php } ?>
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <header>
        <h1><?= $current_page_data['title']; ?></h1>
    </header>

    <nav>
        <ul>
            <?php foreach($page_datas as $page_data_key => $page_data_value) { ?>
            <li <?= (($page_data_value == $current_page_data) ? 'class="active"' : ''); ?>> 
                <a href="<?= ($page_data_key == '/') ? '.' : ('?page=' . $page_data_key); ?>">
                    <?php echo $page_data_value['title']; ?>
                </a>
            </li>
            <?php } ?>
        </ul>
    </nav>

    <section>
        <?php include($current_page_data['html_template']); ?>
    </section>

    <footer>
        <a href="https://vaszilijedc.hu/" target="_blank">vaszilijedc.hu</a>
    </footer>

    <script src="./scripts/script.js"></script>
    <?php if(isset($current_page_data['script_file']) && file_exists($current_page_data['script_file'])) { ?>
    <?php echo '<script src="' . $current_page_data['script_file'] . '"></script>'; ?>
    <?php } ?>
</body>

</html>
