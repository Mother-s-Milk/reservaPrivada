<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        require_once "includes/head.php";
        foreach ($this->scripts as $script) {
            echo '<script defer type"text/javascript" src="' . $script . '?v=<?php echo time();?>"></script>';
        }
    ?>
</head>
<body>
    <div id="grid-body-container">
        <header>
            <?php
                require_once "includes/nav.php";
                //require_once "includes/bread_crumbs.php";
            ?>
        </header>
        <main>
            <?php
                require_once APP_VIEWS . $this->view;
            ?>
        </main>
        <footer>
            <?php
                require_once "includes/footer.php";
            ?>
        </footer>
    </div>
</body>
</html>