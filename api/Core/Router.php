<?php

namespace Core;

use App\Controllers\AuthController;
use App\Models\UserModel;
use Utils\JWT;
use Utils\Auth;
use Core\ApiResponse;

final class Router
{
    private array $middlewares = []; // Stocke les middlewares pour chaque route

    /**
     * Add middlewares to a specific route.
     *
     * @param string $resource resource name (ex: "auth").
     * @param string $action action name (ex: "login").
     * @param array $middlewares Array of middleware callables.
     */
    public function middleware(string $resource, string $action, array $middlewares): void
    {
        $key = "$resource:$action";
        $this->middlewares[$key] = $middlewares;
    }

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
            return;
        }

        $controllerName = ucfirst($resource) . 'Controller';
        $controllerClass = "App\\Controllers\\$controllerName";

        if (!class_exists($controllerClass)) {
            ApiResponse::error("Contrôleur $controllerName introuvable.", [], 404);
            return;
        }

        if ($controllerClass === AuthController::class) {

            $model = new UserModel();

            $jwt = new JWT();

            $secret = $_ENV['SECRET_KEY'] ?? '';

            $auth = new Auth($jwt, $secret);

            $controller = new AuthController(
                $model,
                $jwt,
                $auth
            );
        } else {
            $controller = new $controllerClass();
        }

        $key = "$resource:$action";

        // Vérifie si des middlewares sont définis pour cette route
        if (isset($this->middlewares[$key])) {
            $this->applyMiddlewares($this->middlewares[$key], $controller, $method, $resource, $action);
            return;
        }

        // Si aucun middleware, exécute directement le contrôleur
        $this->executeControllerAction($controller, $method, $resource, $action);
    }

    /**
     * Applique les middlewares à une route.
     */
    private function applyMiddlewares(array $middlewares, $controller, string $method, string $resource, string $action): void
    {
        // Crée une fonction qui exécute le contrôleur à la fin
        $next = function ($payload = null) use ($controller, $method, $resource, $action) {
            $this->executeControllerAction($controller, $method, $resource, $action, $payload);
        };

        // Applique les middlewares dans l'ordre inverse
        foreach (array_reverse($middlewares) as $middleware) {
            $next = function ($payload = null) use ($middleware, $next) {
                $middleware($next, $payload);
            };
        }

        // Démarre la pile de middlewares
        $next();
    }

    /**
     * Execute the controller action based on the HTTP method and action.
     * @param mixed $controller The controller instance.
     * @param string $method The HTTP method.
     * @param string $resource The resource name.
     * @param string $action The action name.
     * @param array|null $payload The payload from middlewares (if any).
     */
    private function executeControllerAction($controller, string $method, string $resource, string $action, ?array $payload = null): void
    {
        if ($action && method_exists($controller, $action)) {
            $controller->$action($payload);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true) ?? [];

        try {
            switch ($method) {
                case 'GET':
                    if (isset($_GET['id'])) {
                        $controller->show((int) $_GET['id'], $payload);
                    } else {
                        $controller->index($_GET, $payload);
                    }
                    break;
                case 'POST':
                    $controller->store($input, $payload);
                    break;
                case 'PUT':
                case 'PATCH':
                    if (isset($_GET['id'])) {
                        $controller->update((int) $_GET['id'], $input, $payload);
                    } else {
                        ApiResponse::error("ID requis pour mise à jour.", [], 400);
                    }
                    break;
                case 'DELETE':
                    if (isset($_GET['id'])) {
                        $controller->delete((int) $_GET['id'], $payload);
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
