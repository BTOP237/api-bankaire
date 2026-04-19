<?php

/**
 * Contrôleur pour gérer les utilisateurs bancaires
 */
class UserController {

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Lister tous les utilisateurs",
     *     description="Récupère la liste de tous les utilisateurs enregistrés dans le système bancaire",
     *     operationId="listUsers",
     *     tags={"Utilisateurs"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des utilisateurs récupérée avec succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="first_name", type="string", example="Jean"),
     *                 @OA\Property(property="last_name", type="string", example="Dupont"),
     *                 @OA\Property(property="email", type="string", format="email", example="jean@example.com"),
     *                 @OA\Property(property="phone", type="string", example="+33612345678"),
     *                 @OA\Property(property="account_number", type="string", example="ACC001"),
     *                 @OA\Property(property="balance", type="number", format="float", example=1500.50),
     *                 @OA\Property(property="account_type", type="string", example="standard"),
     *                 @OA\Property(property="created_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur serveur"
     *     )
     * )
     */
    public static function listUsers() {
        try {
            $sql = "SELECT * FROM users ORDER BY created_at DESC";
            $users = Database::query($sql);
            
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'count' => count($users),
                'data' => $users
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la récupération des utilisateurs: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Obtenir un utilisateur par ID",
     *     description="Récupère les détails d'un utilisateur spécifique",
     *     operationId="getUser",
     *     tags={"Utilisateurs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de l'utilisateur",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur trouvé",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="first_name", type="string", example="Jean"),
     *             @OA\Property(property="last_name", type="string", example="Dupont"),
     *             @OA\Property(property="email", type="string", format="email", example="jean@example.com"),
     *             @OA\Property(property="phone", type="string", example="+33612345678"),
     *             @OA\Property(property="account_number", type="string", example="ACC001"),
     *             @OA\Property(property="balance", type="number", format="float", example=1500.50),
     *             @OA\Property(property="account_type", type="string", example="standard"),
     *             @OA\Property(property="created_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     )
     * )
     */
    public static function getUser($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $user = Database::getOne($sql, [':id' => $id]);
            
            if (!$user) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé'
                ]);
                return;
            }
            
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'data' => $user
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Créer un nouvel utilisateur",
     *     description="Enregistre un nouvel utilisateur dans le système bancaire",
     *     operationId="createUser",
     *     tags={"Utilisateurs"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données du nouvel utilisateur",
     *         @OA\JsonContent(
     *             required={"first_name","last_name","email","phone"},
     *             @OA\Property(property="first_name", type="string", example="Jean", description="Prénom"),
     *             @OA\Property(property="last_name", type="string", example="Dupont", description="Nom"),
     *             @OA\Property(property="email", type="string", format="email", example="jean@example.com", description="Adresse email"),
     *             @OA\Property(property="phone", type="string", example="+33612345678", description="Numéro de téléphone"),
     *             @OA\Property(property="account_type", type="string", enum={"standard","premium"}, example="standard", description="Type de compte"),
     *             @OA\Property(property="balance", type="number", format="float", example=0.0, description="Solde initial")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Utilisateur créé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Utilisateur créé avec succès"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="first_name", type="string", example="Jean"),
     *                 @OA\Property(property="last_name", type="string", example="Dupont"),
     *                 @OA\Property(property="email", type="string", example="jean@example.com"),
     *                 @OA\Property(property="phone", type="string", example="+33612345678"),
     *                 @OA\Property(property="account_number", type="string", example="ACC001"),
     *                 @OA\Property(property="balance", type="number", example=0.0),
     *                 @OA\Property(property="account_type", type="string", example="standard"),
     *                 @OA\Property(property="created_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides ou manquantes"
     *     )
     * )
     */
    public static function createUser($data) {
        try {
            // Valider les données obligatoires
            $required_fields = ['first_name', 'last_name', 'email', 'phone'];
            foreach ($required_fields as $field) {
                if (empty($data[$field])) {
                    http_response_code(400);
                    echo json_encode([
                        'success' => false,
                        'message' => "Le champ '$field' est obligatoire"
                    ]);
                    return;
                }
            }

            // Valider l'email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Email invalide'
                ]);
                return;
            }

            // Vérifier si l'email existe déjà
            $existing = Database::getOne("SELECT id FROM users WHERE email = :email", [':email' => $data['email']]);
            if ($existing) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Cet email est déjà enregistré'
                ]);
                return;
            }

            // Générer un numéro de compte unique
            $account_number = 'ACC' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);

            // Insérer l'utilisateur
            $sql = "INSERT INTO users (first_name, last_name, email, phone, account_number, account_type, balance) 
                    VALUES (:first_name, :last_name, :email, :phone, :account_number, :account_type, :balance)";
            
            $params = [
                ':first_name' => $data['first_name'],
                ':last_name' => $data['last_name'],
                ':email' => $data['email'],
                ':phone' => $data['phone'],
                ':account_number' => $account_number,
                ':account_type' => $data['account_type'] ?? 'standard',
                ':balance' => floatval($data['balance'] ?? 0.0)
            ];

            $user_id = Database::execute($sql, $params);

            // Récupérer l'utilisateur créé
            $created_user = Database::getOne("SELECT * FROM users WHERE id = :id", [':id' => $user_id]);

            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Utilisateur créé avec succès',
                'data' => $created_user
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Mettre à jour un utilisateur",
     *     description="Modifie les informations d'un utilisateur existant",
     *     operationId="updateUser",
     *     tags={"Utilisateurs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de l'utilisateur",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="Jean"),
     *             @OA\Property(property="last_name", type="string", example="Dupont"),
     *             @OA\Property(property="phone", type="string", example="+33612345678"),
     *             @OA\Property(property="balance", type="number", format="float", example=1500.50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur modifié avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     )
     * )
     */
    public static function updateUser($id, $data) {
        try {
            $user = Database::getOne("SELECT * FROM users WHERE id = :id", [':id' => $id]);
            
            if (!$user) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé'
                ]);
                return;
            }

            $updates = [];
            $params = [':id' => $id];

            if (!empty($data['first_name'])) {
                $updates[] = 'first_name = :first_name';
                $params[':first_name'] = $data['first_name'];
            }
            if (!empty($data['last_name'])) {
                $updates[] = 'last_name = :last_name';
                $params[':last_name'] = $data['last_name'];
            }
            if (!empty($data['phone'])) {
                $updates[] = 'phone = :phone';
                $params[':phone'] = $data['phone'];
            }
            if (isset($data['balance'])) {
                $updates[] = 'balance = :balance';
                $params[':balance'] = floatval($data['balance']);
            }

            if (empty($updates)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Aucune donnée à mettre à jour'
                ]);
                return;
            }

            $updates[] = 'updated_at = CURRENT_TIMESTAMP';
            $sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = :id";
            Database::execute($sql, $params);

            $updated_user = Database::getOne("SELECT * FROM users WHERE id = :id", [':id' => $id]);

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Utilisateur mis à jour avec succès',
                'data' => $updated_user
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Supprimer un utilisateur",
     *     description="Supprime un utilisateur du système",
     *     operationId="deleteUser",
     *     tags={"Utilisateurs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de l'utilisateur à supprimer",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     )
     * )
     */
    public static function deleteUser($id) {
        try {
            $user = Database::getOne("SELECT * FROM users WHERE id = :id", [':id' => $id]);
            
            if (!$user) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé'
                ]);
                return;
            }

            Database::execute("DELETE FROM users WHERE id = :id", [':id' => $id]);

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Utilisateur supprimé avec succès'
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    }
}
?>
