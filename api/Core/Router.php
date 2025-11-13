<?php
namespace Core;

use Core\ApiResponse;

final class Router
{
    public function redirect(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { 
            ApiResponse::success("Requête OPTIONS réussie.", [], 200); 
            exit(); 
        }

        $method = $_SERVER['REQUEST_METHOD'];
        $resource = trim($_GET['resource'] ?? '');
        $action = trim($_GET['action'] ?? '');

        if (!$resource) {
            ApiResponse::error("Aucune ressource spécifiée", [], 400);
        }

        $controllerName = ucfirst($resource) . 'Controller';
        $controllerClass = "\\App\\Controllers\\$controllerName";

        if (!class_exists($controllerClass)) {
            ApiResponse::error("Contrôleur $controllerName introuvable.", [], 404);
        }

        $controller = new $controllerClass();

        if ($action && method_exists($controller, $action)) {
            $controller->$action();
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true) ?? [];

        try {
            switch ($method) {
                case 'GET':
                    if (isset($_GET['id'])) {
                        $controller->show((int) $_GET['id']);
                    } else {
                        $controller->index($_GET);
                    }
                    break;

                case 'POST':
                    $controller->store($input);
                    break;

                case 'PUT':
                case 'PATCH':
                    if (isset($_GET['id'])) {
                        $controller->update((int) $_GET['id'], $input);
                    } else {
                        ApiResponse::error("ID requis pour mise à jour.", [], 400);
                    }
                    break;

                case 'DELETE':
                    if (isset($_GET['id'])) {
                        $controller->delete((int) $_GET['id']);
                    } else {
                        ApiResponse::error("ID requis pour suppression.", [], 400);
                    }
                    break;

                default:
                    ApiResponse::error("Méthode $method non autorisée.", [], 405);
            }
        } catch (\Exception $e) {
            ApiResponse::error("Erreur serveur : " . $e->getMessage(), [], 500);
        }
    }
}
