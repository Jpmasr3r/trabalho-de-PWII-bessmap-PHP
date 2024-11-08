<?php
echo $this->layout("_theme");
?>

<link rel="stylesheet" href="<?= url("themes/app/assets/css/styles-profile.css") ?>">
<script type="module" src="<?= url("themes/app/assets/js/script-profile.js") ?>" async></script>

<div id="div-area">
    <div id="div-profile">
        <img src="<?= url("themes/_assets/imgs/bee-white.png") ?>" alt="Foto de Perfil">
        <div id="div-profile-info">
            <h1>Nome do usuario</h1>
            <p>Não Pertence a nenhuma equipe</p>
        </div>
    </div>
</div>