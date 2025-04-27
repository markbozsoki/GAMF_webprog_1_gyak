<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title><?= $current_page_data['title']; ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./styles/style.css">
    <?php if(isset($current_page_data['style_file']) && file_exists($current_page_data['style_file'])) { ?>
    <?php echo '<link rel="stylesheet" href="' . $current_page_data['style_file'] . '">'; ?>
    <?php } ?>
</head>

<body>
    <header>
        <h1><?= $current_page_data['title']; ?></h1>
        <?php if(is_user_logged_in()) { ?>
        <?php echo "<p>Bejelentkezett: " . htmlspecialchars($_SESSION['surname']) . " " . htmlspecialchars($_SESSION['forename']) . " (" . htmlspecialchars($_SESSION['username']) . ")</p>"; ?>
        <?php } ?>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php foreach($page_datas as $page_data_key => $page_data_value) { ?>
                    <?php $menu_accessibility = $page_data_value['accessibility']; ?>
                    <?php $on_logged_in_allowed = is_user_logged_in() && $menu_accessibility['show_when_logged_in'] ?>
                    <?php $on_logged_out_allowed = !is_user_logged_in() && $menu_accessibility['show_when_logged_out'] ?>
                    <?php $should_show_menu = $on_logged_in_allowed || $on_logged_out_allowed ?>
                    <?php if($should_show_menu) { ?>
                    <li class="nav-item<?= (($page_data_value === $current_page_data) ? ' active' : ''); ?>"> 
                        <a class="nav-link" href="<?= ($page_data_key === '/') ? '.' : ('?page=' . $page_data_key); ?>">
                            <?php echo $page_data_value['title']; ?>
                        </a>
                    </li>
                    <?php } ?>
                <?php } ?>
                <?php if(is_user_logged_in()) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="?logout">Kijelentkezés</a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <section>
        <?php include($current_page_data['html_template']); ?>
    </section>

    <footer class="fixed-bottom text-center">
        <a href="https://vaszilijedc.hu/" target="_blank">vaszilijedc.hu</a>
    </footer>

    <!-- Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    <!-- Custom JS -->
    <script src="./scripts/script.js"></script>
    <?php if(isset($current_page_data['script_file']) && file_exists($current_page_data['script_file'])) { ?>
    <?php echo '<script src="' . $current_page_data['script_file'] . '"></script>'; ?>
    <?php } ?>

    <?php if (isset($current_page_data['popup'])) { ?>
    <!-- Popup -->
    <script>
        <?php if (isset($current_page_data['popup']['alert'])) { ?>
        <?php // wait for the page to load and then make the popup appeare ?>
        <?php echo 'onload = (event) => { alert("'. $current_page_data['popup']['alert'] . '") };'; ?>
        <?php } ?>
    </script>
    <?php } ?>
</body>

</html>
