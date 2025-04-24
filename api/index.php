<?php

ob_start();

require __DIR__ . "/../vendor/autoload.php";

use CoffeeCode\Router\Router;

$route = new Router(url(), ":");

$route->namespace("Source\App\Api");

/* USERS */
$route->group("/users");
$route->get("/", "Users:listUsers");
$route->get("/logged", "Users:logged");
$route->get("/infs", "Users:getInfs");
$route->post("/", "Users:createUser");
$route->post("/login", "Users:loginUser");
$route->post("/update", "Users:updateUser");
$route->post("/update/password", "Users:setPassword");
$route->delete("/delete", "Users:deleteUser");
$route->group("null");

/* TEAMS */
$route->group("/teams");
$route->get("/", "Teams:listTeams");
$route->get("/infs", "Teams:infs");
$route->get("/select/{name}", "Teams:getTeams");
$route->post("/", "Teams:createTeam");
$route->post("/join", "Teams:joinTeam");
$route->post("/exit", "Teams:exitTeam");
$route->post("/update", "Teams:updateTeam");
$route->post("/delete", "Teams:deleteTeam");
$route->group("null");

/* FAQS */
$route->group("/faqs");
$route->get("/", "Faqs:listFaqs");
$route->post("/", "Faqs:insert");
$route->post("/update", "Faqs:update");
$route->post("/delete", "Faqs:delete");
$route->group("null");

/* PRODUTIONS */
$route->group("/produtions");
$route->get("/", "Produtions:listByTeam");
$route->post("/", "Produtions:insert");
$route->post("/delete", "Produtions:delete");
$route->group("null");

/* BOXES */
$route->group("/boxes");
$route->get("/{area_id}", "Boxes:listByArea");
$route->post("/", "Boxes:insert");
$route->post("/update", "Boxes:update");
$route->post("/delete", "Boxes:delete");
$route->group("null");

/* AREAS */
$route->group("/areas");
$route->get("/", "Areas:listByTeam");
$route->post("/", "Areas:insert");
$route->post("/update", "Areas:update");
$route->post("/delete", "Areas:delete");
$route->group("null");

/* SALES */
$route->group("/sales");
$route->get("/", "Sales:listByTeam");
$route->post("/", "Sales:insert");
$route->post("/update", "Sales:update");
$route->post("/delete", "Sales:delete");
$route->group("null");

/* VEHICLES */
$route->group("/vehicles");
$route->get("/", "Vehicles:listByTeam");
$route->post("/", "Vehicles:insert");
$route->post("/update", "Vehicles:update");
$route->post("/delete", "Vehicles:delete");
$route->group("null");

/* Upload */
$route->group("/upload");
$route->post("/image", "Uploads:uploadImage");
$route->group("null");



$route->dispatch();

/** ERROR REDIRECT */
if ($route->error()) {
    header('Content-Type: application/json; charset=UTF-8');
    http_response_code(404);

    echo json_encode([
        "errors" => [
            "type " => "endpoint_not_found",
            "message" => "Não foi possível processar a requisição"
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

ob_end_flush();