<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?= url("themes/_assets/imgs/bee-white.png") ?>"/>
    <link rel="stylesheet" href="<?= url("themes/adm/assets/css/styles-theme.css"); ?>">
    <title>BeesMap</title>
</head>

<body>

    <nav id="navBar">
        <label id="lblLogo">
            <a href="<?= url("adm") ?>">
                <h1>BeesMap</h1>
                <img src="<?= url("themes/_assets/imgs/bee-white.png") ?>" alt="bee">
            </a>
        </label>
        <h1>|</h1>
        <label>
            <a href="<?= url("adm") ?>">
                <h1>Inicio</h1>
            </a>
        </label>
        <h1>|</h1>
        <label>
            <a href="<?= url("adm/registros") ?>">
                <h1>Registros</h1>
            </a>
        </label>
        <h1>|</h1>
        <label>
            <a href="<?= url("adm/usuarios") ?>">
                <h1>Usuarios</h1>
            </a>
        </label>
        <h1>|</h1>
        <label>
            <a href="<?= url("app") ?>">
                <h1>Voltar</h1>
            </a>
        </label>
    </nav>
    <?php
    echo $this->section("content");
    ?>
    <footer>
        <h1>2024 - João Pedro Anjolim Soares</h1>
    </footer>
</body>

</html>