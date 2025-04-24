<?php
echo $this->layout("_theme");
?>

<link rel="stylesheet" href="<?= url("themes/app/assets/css/styles-create-team.css") ?>">
<script type="module" src="<?= url("themes/app/assets/js/script-create-team.js") ?>" async></script>

<div id="div-create-team">
    <h1>Criar Equipe</h1>
    <form id="team-form">
        <div id="team-members">
            <label>
                <b>Membro 1</b>
                <input type="text" class="member-name" placeholder="Nome do membro">
            </label>
        </div>
        <button type="button" id="btn-add-member">Adicionar Membro</button>
        <button type="submit" id="btn-submit-team">Criar Equipe</button>
    </form>
</div>
