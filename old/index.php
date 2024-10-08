<?php

session_start();

//var_dump($_SESSION);

// charge l'autoload de composer
require "vendor/autoload.php";

// charge le contenu du .env dans $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require('services/Router.php');
$router = new Router();

$router->handleRequest($_GET);