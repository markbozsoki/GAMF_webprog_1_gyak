<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $current_page_data['title']; ?></title>

    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- custom css -->
    <link rel="stylesheet" href="./styles/style.css">
    <?php if(isset($current_page_data['style_file']) && file_exists($current_page_data['style_file'])) { ?>
    <?php echo '<link rel="stylesheet" href="' . $current_page_data['style_file'] . '">'; ?>
    <?php } ?>
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
