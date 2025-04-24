<?php
echo $this->layout("_theme");
?>

<link rel="stylesheet" href="<?= url("themes/app/assets/css/styles-team.css") ?>">
<script src="<?= url("themes/app/assets/js/script-team.js") ?>" async type="module"></script>

<div id="div-area">
    <div class="team-focus">
        <div class="div-team-info">
            <h1>Nome da Equipe</h1>
        </div>
        <div class="div-team-members">
            <h1>Membros da Equipe</h1>
        </div>
        <button id="btn-exit-team">Sair da equipe</button>
        <button id="btn-delete-team">Deletar Equipe</button>
        <button id="btn-insert-area">Inserir Area</button>
        <div id="div-areas">
            <h1>Areas</h1>
            <div class="area">
                <h1>Nome da area</h1>
                <div class="div-boxes">
                    <div class="box">
                        <h1>Indentificador 1</h1>
                        <h1>Collectado</h1>
                    </div>

                    <div class="box">
                        <h1>Indentificador 2</h1>
                        <h1>Não Collectado</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>