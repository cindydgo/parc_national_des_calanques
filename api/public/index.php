<?php

require_once dirname(__DIR__)  . '/config/bootstrap.php';

use Core\ApiResponse;
use Core\Router;

// Afficher les erreurs en dev
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Instanciation et redirection via le Router
try {
    $router = new Router();
    $router->redirect();
} catch (\Exception $e) {
    ApiResponse::error("Erreur serveur : " . $e->getMessage(), [], 500);
}
