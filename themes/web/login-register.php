<?php
echo $this->layout("_theme");
?>

<link rel="stylesheet" href="<?= url("themes/web/assets/css/style-login-register.css") ?>">
<script type="module" src="<?= url("themes/web/assets/js/script-login-register.js") ?>" async></script>

<div id="div-login-register">
    <div id="div-login">
        <h1>Login</h1>
        <label>
            <b>Email</b>
            <input id="inp-login-email" type="text" placeholder="Email">
        </label>
        <label>
            <b>Senha</b>
            <input id="inp-login-password" type="password" placeholder="Senha">
        </label>
        <a id="btn-login">
            <label>Fazer login</label>
        </a>
        <!-- <a id="btn-login" href="<?= url("app"); ?>">
            <label>Fazer login</label>
        </a> -->
    </div>
    <img src="<?= url("themes/_assets/imgs/bee-white.png") ?>" alt="bee">
    <div id="div-register" >
        <h1>Registro</h1>
        <label>
            <b>Nome</b>
            <input type="text" id="inp-register-name" placeholder="Nome">
        </label>
        <label>
            <b>Email</b>
            <input type="text" id="inp-register-email" placeholder="Email">
        </label>
        <label>
            <b>Senha</b>
            <input type="text" id="inp-register-password" placeholder="Senha">
        </label>
        <label>
            <b>Confirmar Senha</b>
            <input type="text" id="inp-register-confirm-password" placeholder="Confirmar Senha">
        </label>
        <a id="btn-create">
            <label>
            Criar conta
            </label>
        </a>
        <!-- <a id="btn-create" href="<?= url("app"); ?>">
            <label>
            Criar conta
            </label>
        </a> -->
    </div>
</div>