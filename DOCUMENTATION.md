# 📚 Documentation Complète - API Bancaire

## 📋 Table des matières
1. [Structure du projet](#structure)
2. [Installation locale](#installation)
3. [Endpoints disponibles](#endpoints)
4. [Déploiement sur Render](#render)
5. [Explications détaillées](#explications)

## <a name="structure"></a>🗂️ Structure du Projet

```
ICT304/
│
├── 📁 public/                 # Dossier accessible sur le web
│   ├── index.php              # Point d'entrée principal (routeur)
│   ├── swagger.json           # Documentation Swagger (générée)
│   └── .htaccess              # Configuration pour Apache
│
├── 📁 src/                    # Code source de l'application
│   ├── Database.php           # Gestion de la base de données SQLite
│   ├── UserController.php     # Logique des utilisateurs (avec Swagger)
│   └── swagger.php            # Configuration Swagger (optionnel)
│
├── 📄 composer.json           # Gestion des dépendances PHP
├── 📄 Procfile                # Configuration Heroku/Render
├── 📄 render.yaml             # Configuration spécifique Render
├── 📄 .env.example            # Exemple de variables d'environnement
├── 📄 .gitignore              # Fichiers à ignorer en Git
└── 📄 test-api.php            # Script pour tester l'API
```

## <a name="installation"></a>⚡ Installation & Démarrage Local

### Prérequis
- **PHP 7.4+** (vérifier: `php -v`)
- **Composer** (vérifier: `composer --version`)
- **SQLite3** extension activée
- **cURL** (pour tester l'API)

### Étapes d'installation

**Étape 1 : Naviguer vers le dossier**
```bash
cd c:\Users\DARKSIDE\Desktop\ICT304
```

**Étape 2 : Installer les dépendances**
```bash
composer install
```

**Étape 3 : Lancer le serveur**
```bash
# Option 1 : Serveur PHP intégré (recommandé pour développement)
php -S localhost:8000 -t public

# Option 2 : Avec Apache/XAMPP
# Copier le dossier dans htdocs/ et accéder via http://localhost/ICT304/public
```

**Étape 4 : Vérifier que ça fonctionne**
```bash
curl http://localhost:8000/
```

Vous devriez voir une réponse JSON de bienvenue.

## <a name="endpoints"></a>🔌 Endpoints Disponibles

### 1️⃣ **GET /api/users** - Lister tous les utilisateurs

**Description:** Récupère la liste de tous les utilisateurs

**Requête:**
```bash
curl http://localhost:8000/api/users
```

**Réponse (200 OK):**
```json
{
  "success": true,
  "count": 2,
  "data": [
    {
      "id": 1,
      "first_name": "Jean",
      "last_name": "Dupont",
      "email": "jean@example.com",
      "phone": "+33612345678",
      "account_number": "ACC123456",
      "balance": 1500.50,
      "account_type": "standard",
      "created_at": "2026-04-19 10:30:00",
      "updated_at": "2026-04-19 11:00:00"
    }
  ]
}
```

---

### 2️⃣ **POST /api/users** - Créer un nouvel utilisateur

**Description:** Crée un nouvel utilisateur dans le système

**Champs requis:**
- `first_name` (string) : Prénom
- `last_name` (string) : Nom
- `email` (string) : Email unique
- `phone` (string) : Numéro de téléphone

**Champs optionnels:**
- `account_type` (string) : "standard" ou "premium" (défaut: "standard")
- `balance` (number) : Solde initial (défaut: 0.0)

**Requête:**
```bash
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "Alice",
    "last_name": "Bernard",
    "email": "alice@example.com",
    "phone": "+33645678901",
    "account_type": "premium",
    "balance": 5000.00
  }'
```

**Réponse (201 Created):**
```json
{
  "success": true,
  "message": "Utilisateur créé avec succès",
  "data": {
    "id": 2,
    "first_name": "Alice",
    "last_name": "Bernard",
    "email": "alice@example.com",
    "phone": "+33645678901",
    "account_number": "ACC654321",
    "balance": 5000.0,
    "account_type": "premium",
    "created_at": "2026-04-19 14:30:00"
  }
}
```

**Erreurs possibles:**
- `400` : Email invalide ou champ manquant
- `400` : Email déjà utilisé

---

### 3️⃣ **GET /api/users/{id}** - Obtenir un utilisateur

**Description:** Récupère les détails d'un utilisateur spécifique

**Paramètre:**
- `id` (integer) : ID de l'utilisateur

**Requête:**
```bash
curl http://localhost:8000/api/users/1
```

**Réponse (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "first_name": "Jean",
    "last_name": "Dupont",
    "email": "jean@example.com",
    "phone": "+33612345678",
    "account_number": "ACC123456",
    "balance": 1500.50,
    "account_type": "standard",
    "created_at": "2026-04-19 10:30:00"
  }
}
```

---

### 4️⃣ **PUT /api/users/{id}** - Mettre à jour un utilisateur

**Description:** Modifie les informations d'un utilisateur

**Paramètre:**
- `id` (integer) : ID de l'utilisateur

**Corps (JSON) - Tous les champs optionnels:**
- `first_name` : Nouveau prénom
- `last_name` : Nouveau nom
- `phone` : Nouveau téléphone
- `balance` : Nouveau solde

**Requête:**
```bash
curl -X PUT http://localhost:8000/api/users/1 \
  -H "Content-Type: application/json" \
  -d '{
    "balance": 3000.00,
    "phone": "+33611223344"
  }'
```

**Réponse (200 OK):**
```json
{
  "success": true,
  "message": "Utilisateur mis à jour avec succès",
  "data": {
    "id": 1,
    "first_name": "Jean",
    "last_name": "Dupont",
    "email": "jean@example.com",
    "phone": "+33611223344",
    "account_number": "ACC123456",
    "balance": 3000.0,
    "account_type": "standard",
    "created_at": "2026-04-19 10:30:00",
    "updated_at": "2026-04-19 15:45:00"
  }
}
```

---

### 5️⃣ **DELETE /api/users/{id}** - Supprimer un utilisateur

**Description:** Supprime un utilisateur du système

**Paramètre:**
- `id` (integer) : ID de l'utilisateur

**Requête:**
```bash
curl -X DELETE http://localhost:8000/api/users/1
```

**Réponse (200 OK):**
```json
{
  "success": true,
  "message": "Utilisateur supprimé avec succès"
}
```

---

## <a name="render"></a>🚀 Déploiement Détaillé sur Render

### Étape 1: Préparer le Code
1. Créer un dossier `.render` à la racine du projet
2. Créer un fichier `build.sh` dedans:

```bash
#!/usr/bin/env bash
set -o errexit

composer install --no-dev
```

### Étape 2: Créer un Repository GitHub

```bash
# Initialiser Git
git init
git add .
git commit -m "Initial commit: API Bancaire"
git branch -M main

# Ajouter le remote (remplacer par votre repo)
git remote add origin https://github.com/YOUR_USERNAME/banking-api.git
git push -u origin main
```

### Étape 3: Créer un Service sur Render

1. **Aller sur [render.com](https://render.com)**
2. **Cliquer sur "New +" → "Web Service"**
3. **Connecter votre compte GitHub**
4. **Sélectionner le repository `banking-api`**

### Étape 4: Configurer le Service

| Paramètre | Valeur |
|-----------|--------|
| **Name** | banking-api |
| **Region** | Frankfurt (EU Central) |
| **Branch** | main |
| **Runtime** | PHP |
| **Build Command** | `composer install --no-dev` |
| **Start Command** | `vendor/bin/heroku-php-apache2 public/` |
| **Plan** | Free (gratuit) |

### Étape 5: Ajouter les Variables d'Environnement (Optionnel)

Dans Render:
1. Aller à **"Environment"**
2. Ajouter les variables:

```
APP_ENV=production
APP_DEBUG=false
```

### Étape 6: Déployer

1. Cliquer sur **"Create Web Service"**
2. Attendre le déploiement (2-3 minutes)
3. Vous obtenez une URL: `https://banking-api-xxxxx.onrender.com`

### Étape 7: Tester après Déploiement

```bash
# Tester l'API
curl https://banking-api-xxxxx.onrender.com/api/users

# Créer un utilisateur
curl -X POST https://banking-api-xxxxx.onrender.com/api/users \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "Test",
    "last_name": "User",
    "email": "test@example.com",
    "phone": "+33600000000"
  }'
```

---

## <a name="explications"></a>🎓 Explications Détaillées du Code

### 📄 public/index.php - Routeur Principal

Ce fichier est le point d'entrée de toute l'API. Il:

```php
// 1. Initialise la base de données
Database::init();

// 2. Configure les headers CORS et JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 3. Parse la requête HTTP
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_method = $_SERVER['REQUEST_METHOD'];

// 4. Route vers le bon contrôleur
if (preg_match('/^\/api\/users$/', $request_uri)) {
    // Gère POST et GET /api/users
}
```

### 📄 src/Database.php - Gestion de SQLite

Permet d'interagir avec la base de données:

```php
// Exécuter une requête
$users = Database::query("SELECT * FROM users");

// Récupérer une seule ligne
$user = Database::getOne("SELECT * FROM users WHERE id = :id", [':id' => 1]);

// Insérer/Modifier/Supprimer
Database::execute("INSERT INTO users ...", $params);
```

### 📄 src/UserController.php - Logique Métier

Contient la logique pour:
- Valider les données
- Vérifier les doublons d'email
- Générer des numéros de compte
- Gérer les erreurs avec les bons codes HTTP

### 🏷️ Commentaires Swagger

Les commentaires Swagger ressemblent à:

```php
/**
 * @OA\Get(
 *     path="/api/users",
 *     summary="Lister tous les utilisateurs",
 *     @OA\Response(response=200, description="Succès")
 * )
 */
```

Ils décrivent automatiquement votre API dans une documentation interactive.

---

## 🔑 Points Clés à Retenir

| Concept | Explication |
|---------|-------------|
| **SQLite** | Base de données fichier (pas de serveur) |
| **Commentaires Swagger** | Documentation automatique de l'API |
| **CORS** | Permet l'accès depuis n'importe quel domaine |
| **Numéro de compte** | Généré automatiquement au format `ACC000000` |
| **Validation** | Email unique, format email vérifié |
| **Codes HTTP** | 200 (OK), 201 (Créé), 400 (Erreur), 404 (Non trouvé), 500 (Erreur serveur) |

---

**Questions?** Consultez le README.md ou testez avec `php test-api.php` 🧪
