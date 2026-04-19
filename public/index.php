<?php
/**
 * @OA\OpenApi(
 *     openapi="3.0.0",
 *     info=@OA\Info(
 *         version="1.0.0",
 *         title="API Bancaire",
 *         description="API pour gérer les utilisateurs bancaires",
 *         contact=@OA\Contact(
 *             email="support@bank.com"
 *         )
 *     ),
 *     servers={
 *         @OA\Server(
 *             url="http://localhost:8000",
 *             description="Serveur local"
 *         ),
 *         @OA\Server(
 *             url="https://your-app.onrender.com",
 *             description="Serveur Render (production)"
 *         )
 *     }
 * )
 */

// Constantes de l'application
define('DB_FILE', __DIR__ . '/../database.sqlite');

// Inclure les contrôleurs
require_once __DIR__ . '/../src/UserController.php';
require_once __DIR__ . '/../src/Database.php';

// Initialiser la base de données
Database::init();

// Headers pour CORS et JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Gérer les requêtes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Router simple
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_method = $_SERVER['REQUEST_METHOD'];
$request_data = json_decode(file_get_contents('php://input'), true) ?? $_GET;

// Définir les routes
if (preg_match('/^\/api\/users$/', $request_uri)) {
    if ($request_method === 'GET') {
        UserController::listUsers();
    } elseif ($request_method === 'POST') {
        UserController::createUser($request_data);
    } else {
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
    }
} elseif (preg_match('/^\/api\/users\/(\d+)$/', $request_uri, $matches)) {
    $user_id = $matches[1];
    if ($request_method === 'GET') {
        UserController::getUser($user_id);
    } elseif ($request_method === 'PUT') {
        UserController::updateUser($user_id, $request_data);
    } elseif ($request_method === 'DELETE') {
        UserController::deleteUser($user_id);
    } else {
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
    }
} elseif ($request_uri === '/' || $request_uri === '/index.php') {
    echo json_encode([
        'message' => 'Bienvenue dans l\'API Bancaire',
        'version' => '1.0.0',
        'documentation' => '/swagger/index.html'
    ]);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint non trouvé']);
}
?>
