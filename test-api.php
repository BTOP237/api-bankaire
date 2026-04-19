#!/usr/bin/env php
<?php
/**
 * Script de test de l'API Bancaire
 * Utilisation: php test-api.php
 */

define('API_URL', 'http://localhost:8000/api');

class APITester {
    private $base_url;

    public function __construct($base_url) {
        $this->base_url = $base_url;
    }

    /**
     * Faire une requête HTTP
     */
    private function request($method, $endpoint, $data = null) {
        $url = $this->base_url . $endpoint;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'status' => $http_code,
            'body' => json_decode($response, true)
        ];
    }

    /**
     * Afficher une réponse formatée
     */
    private function printResponse($title, $response) {
        echo "\n" . str_repeat("=", 60) . "\n";
        echo "📌 " . $title . "\n";
        echo str_repeat("=", 60) . "\n";
        echo "Status: " . $response['status'] . "\n";
        echo json_encode($response['body'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    }

    /**
     * Lancer les tests
     */
    public function runTests() {
        echo "\n🏦 Démarrage des tests de l'API Bancaire\n";

        // Test 1: Créer un utilisateur
        $user_data = [
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'email' => 'jean@example.com',
            'phone' => '+33612345678',
            'account_type' => 'standard',
            'balance' => 1000.00
        ];

        $response = $this->request('POST', '/users', $user_data);
        $this->printResponse('Test 1: Créer un utilisateur', $response);
        
        $user_id = $response['body']['data']['id'] ?? null;
        $created_user = $response['body']['data'] ?? null;

        if (!$user_id) {
            echo "❌ Erreur: Impossible de créer l'utilisateur\n";
            return;
        }

        echo "✅ Utilisateur créé avec succès (ID: $user_id)\n";

        // Test 2: Créer un deuxième utilisateur
        $user_data2 = [
            'first_name' => 'Marie',
            'last_name' => 'Martin',
            'email' => 'marie@example.com',
            'phone' => '+33687654321',
            'account_type' => 'premium',
            'balance' => 5000.00
        ];

        $response = $this->request('POST', '/users', $user_data2);
        $this->printResponse('Test 2: Créer un deuxième utilisateur', $response);

        // Test 3: Lister tous les utilisateurs
        $response = $this->request('GET', '/users');
        $this->printResponse('Test 3: Lister tous les utilisateurs', $response);
        echo "✅ Nombre d'utilisateurs: " . $response['body']['count'] . "\n";

        // Test 4: Obtenir un utilisateur par ID
        $response = $this->request('GET', "/users/$user_id");
        $this->printResponse('Test 4: Obtenir l\'utilisateur par ID', $response);

        // Test 5: Mettre à jour l'utilisateur
        $update_data = [
            'balance' => 2500.00,
            'phone' => '+33611111111'
        ];

        $response = $this->request('PUT', "/users/$user_id", $update_data);
        $this->printResponse('Test 5: Mettre à jour l\'utilisateur', $response);

        // Test 6: Erreur - Email déjà utilisé
        $duplicate_email = [
            'first_name' => 'Pierre',
            'last_name' => 'Dupont',
            'email' => 'jean@example.com', // Email déjà utilisé
            'phone' => '+33699999999'
        ];

        $response = $this->request('POST', '/users', $duplicate_email);
        $this->printResponse('Test 6: Erreur - Email déjà utilisé', $response);

        // Test 7: Erreur - Email invalide
        $invalid_email = [
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'invalid-email',
            'phone' => '+33688888888'
        ];

        $response = $this->request('POST', '/users', $invalid_email);
        $this->printResponse('Test 7: Erreur - Email invalide', $response);

        // Test 8: Supprimer l'utilisateur
        $response = $this->request('DELETE', "/users/$user_id");
        $this->printResponse('Test 8: Supprimer l\'utilisateur', $response);

        // Test 9: Utilisateur non trouvé
        $response = $this->request('GET', "/users/$user_id");
        $this->printResponse('Test 9: Utilisateur non trouvé (après suppression)', $response);

        echo "\n✅ Tests terminés!\n\n";
    }
}

// Lancer les tests
if (php_sapi_name() !== 'cli') {
    die("Ce script doit être lancé en ligne de commande (CLI)\n");
}

$tester = new APITester(API_URL);
$tester->runTests();
?>
