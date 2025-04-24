<?php

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

ob_start();

$route = new Router(url(), ":");

$route->namespace("Source\App");

// Rotas amigáveis da área pública
$route->get("/", "Web:home");
$route->get("/login", "Web:loginRegister");
$route->get("/register", "Web:loginRegister");
$route->get("/sobre", "Web:about");
$route->get("/contato", "Web:contact");
$route->get("/faqs", "Web:faqs");

// Rotas amigáveis da área app
$route->group("/app");

$route->get("/", "App:team");
$route->get("/perfil", "App:profile");
$route->get("/equipe", "App:team");
$route->get("/equipe/criar", "App:createTeam");

// Rotas amigáveis da área admin
$route->group(null);

$route->group("/adm");

$route->get("/", "Admin:home");
$route->get("/registros", "Admin:registers");
$route->get("/usuarios", "Admin:users");

$route->group(null);

$route->get("/ops/{errcode}", "Web:error");

$route->group(null);

$route->dispatch();

if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();