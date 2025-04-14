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

    <!-- bootstrap scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    <!-- custom scripts -->
    <script src="./scripts/script.js"></script>
    <?php if(isset($current_page_data['script_file']) && file_exists($current_page_data['script_file'])) { ?>
    <?php echo '<script src="' . $current_page_data['script_file'] . '"></script>'; ?>
    <?php } ?>
</body>

</html>
