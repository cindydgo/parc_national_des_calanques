<?php
namespace App\Controllers;

use App\Models\UserModel;
use Core\ApiResponse;
use Utils\JWT;
use Utils\Auth;
use Utils\Validator;

class AuthController {
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    /**
     * Register testable
     * @param string $username
     * @param string $password
     * @param string $email
     * @return array Newly created user data
     */
    public function register(string $username, string $email, string $password, string $role = 'user'): array
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => $role
        ];

        $newUserId = $this->model->createUser($data);
        $newUser = $this->model->getUser($newUserId);

        return $newUser;
    }

    /**
     * Login testable
     * @param string $username
     * @param string $email
     * @param string $password
     * @return array|null Payload if successful, otherwise null
     */
    public function login(string $username, string $email, string $password): ?array
    {
        $user = $this->model->getUserByUsernameOrEmail($username, $email);
        
        if ($user && password_verify($password, $user['password'])) {
            $jwt = new JWT();
            $payload = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];

            $token = $jwt->generateToken(
                ['alg' => 'HS256', 'typ' => 'JWT'],
                $payload,
                $_ENV['SECRET_KEY'],
                3600
            );

            return ['token' => $token, 'payload' => $payload];
        }

        return null;
    }
    

    /**
     * Logout testable
     * @return void
     */
    public function logout(): void
    {
        setcookie('jwt_token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'none'
        ]);
    }

    /**
     * API REST
     */

    /**
     * POST /api/register
     * Register API endpoint
     * @return void
     */
    public function registerApi(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $username = htmlspecialchars(trim($data['username'] ?? ''));
        $email    = htmlspecialchars(trim($data['email'] ?? ''));
        $password = $data['password'] ?? '';

        if (!Validator::isValidEmail($email)) {
            ApiResponse::error("Email invalide", [], 400);
        }

        if (!Validator::isValidUsername($username)) {
            ApiResponse::error("Nom d'utilisateur invalide", [], 400);
        }
        
        if (!Validator::isValidPassword($password)) {
            ApiResponse::error("Mot de passe trop invalide", [], 400);
        }

        $existingUser = $this->model->isUserAlreadyExist($username, $email);
        if ($existingUser) {
            ApiResponse::error("Nom d'utilisateur ou email déjà pris", [], 400);
        }

        $newUser = $this->register($username, $email, $password);

        ApiResponse::success("Utilisateur enregistré avec succès", $newUser, 201);
    }


    /**
     * POST /api/loginApi
     * Login API endpoint
     * @return void
     */
    public function loginApi(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $username = $data['username'] ?? '';
        $email    = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $result = $this->login($username, $email, $password);

        if ($result) {
            setcookie('jwt_token', $result['token'], [
                'expires' => time() + 3600,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'none'
            ]);
            ApiResponse::success("Connexion réussie", ['user' => $result['payload']], 200);
        } else {
            ApiResponse::error("Identifiants invalides", [], 401);
        }
    }

    
    /**
     * POST /api/logoutApi
     * Logout API endpoint
     * @return void
     */
    public function logoutApi(): void
    {
        $jwtToken = $_COOKIE['jwt_token'] ?? null;
        $this->logout($jwtToken);

        ApiResponse::success("Déconnexion réussie", [], 200);
    }

    public function checkAuthApi(): void
    {
        $payload = Auth::checkAuth();

        if ($payload) {
            ApiResponse::success("Authentification réussie", ['user' => $payload], 200);
        } else {
            ApiResponse::error("Non autorisé", [], 401);
        }
    }
}
