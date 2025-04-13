<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
    <title><?= $current_page_data['title']; ?></title>
	<link rel="stylesheet" href="styles/style.css">
</head>

<body>
	<header>
        <h1><?= $current_page_data['title']; ?></h1>
    </header>

    <nav>
        <ul>
            <?php foreach($page_datas as $page_data_key => $page_data_value) { ?>
                <li <?= (($page_data_value == $current_page_data) ? 'class="active"' : ''); ?>> 
                    <a href="<?=($page_data_key == '/') ? '.' : ('?page=' . $page_data_key);?>">
                        <?= $page_data_value['title']; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>

    <section>
        <?php include($current_page_data['html_template']); ?>
    </section>

    <footer>
        <p>placeholder</p>
    </footer>

    <script src="scripts/script.js"></script>
</body>

</html>
