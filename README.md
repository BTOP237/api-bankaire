# 🏦 API Bancaire PHP

Une API RESTful pour gérer les utilisateurs d'une banque, écrite en PHP avec documentation Swagger intégrée.

## ✨ Fonctionnalités

- ✅ Créer des utilisateurs bancaires
- ✅ Lister tous les utilisateurs
- ✅ Obtenir un utilisateur par ID
- ✅ Mettre à jour les informations d'un utilisateur
- ✅ Supprimer un utilisateur
- ✅ Numéros de compte générés automatiquement
- ✅ Documentation Swagger interactive
- ✅ Support CORS
- ✅ Base de données SQLite intégrée

## 📋 Configuration Requise

- PHP 7.4 ou supérieur
- Composer
- Extension SQLite3 activée

## 🚀 Démarrage Rapide (Local)

### 1. Cloner le projet
```bash
cd c:\Users\DARKSIDE\Desktop\ICT304
```

### 2. Installer les dépendances
```bash
composer install
```

### 3. Démarrer le serveur de développement
```bash
php -S localhost:8000 -t public
```

### 4. Accéder à l'API
- **API**: http://localhost:8000/api/users
- **Swagger UI**: http://localhost:8000/swagger/index.html (après génération)

## 📖 Utilisation de l'API

### 1. Créer un utilisateur
```bash
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "Jean",
    "last_name": "Dupont",
    "email": "jean@example.com",
    "phone": "+33612345678",
    "account_type": "standard",
    "balance": 1000.00
  }'
```

**Réponse (201 Created):**
```json
{
  "success": true,
  "message": "Utilisateur créé avec succès",
  "data": {
    "id": 1,
    "first_name": "Jean",
    "last_name": "Dupont",
    "email": "jean@example.com",
    "phone": "+33612345678",
    "account_number": "ACC123456",
    "balance": 1000.0,
    "account_type": "standard",
    "created_at": "2026-04-19 10:30:00"
  }
}
```

### 2. Lister tous les utilisateurs
```bash
curl http://localhost:8000/api/users
```

**Réponse (200 OK):**
```json
{
  "success": true,
  "count": 1,
  "data": [
    {
      "id": 1,
      "first_name": "Jean",
      "last_name": "Dupont",
      "email": "jean@example.com",
      "phone": "+33612345678",
      "account_number": "ACC123456",
      "balance": 1000.0,
      "account_type": "standard",
      "created_at": "2026-04-19 10:30:00"
    }
  ]
}
```

### 3. Obtenir un utilisateur par ID
```bash
curl http://localhost:8000/api/users/1
```

### 4. Mettre à jour un utilisateur
```bash
curl -X PUT http://localhost:8000/api/users/1 \
  -H "Content-Type: application/json" \
  -d '{
    "balance": 1500.00,
    "phone": "+33687654321"
  }'
```

### 5. Supprimer un utilisateur
```bash
curl -X DELETE http://localhost:8000/api/users/1
```

## 🌐 Déploiement sur Render

### Étape 1: Créer un compte Render
1. Aller sur [https://render.com](https://render.com)
2. S'inscrire avec GitHub ou email

### Étape 2: Créer un nouveau service
1. Cliquer sur **"New +"** → **"Web Service"**
2. Connecter votre référentiel GitHub
3. Ou coller l'URL du référentiel public

### Étape 3: Configurer le service

| Champ | Valeur |
|-------|--------|
| **Name** | banking-api |
| **Region** | Frankfurt (EU Central) |
| **Branch** | main |
| **Runtime** | PHP |
| **Build Command** | `composer install --no-interaction --prefer-dist` |
| **Start Command** | `vendor/bin/heroku-php-apache2 public/` |

### Étape 4: Variables d'environnement (Optionnel)
Cliquer sur **"Environment"** et ajouter:
```
APP_ENV=production
APP_DEBUG=false
```

### Étape 5: Déployer
1. Cliquer sur **"Create Web Service"**
2. Render va automatiquement déployer votre API
3. L'URL de votre API sera : `https://your-app.onrender.com`

### Étape 6: Tester après déploiement
```bash
curl https://your-app.onrender.com/api/users
```

## 📊 Structure du Projet

```
ICT304/
├── public/
│   ├── index.php          # Point d'entrée principal
│   ├── .htaccess          # Configuration Apache
│   └── swagger.json       # Docs Swagger générées
├── src/
│   ├── Database.php       # Gestion SQLite
│   └── UserController.php # Contrôleur utilisateurs
├── composer.json          # Dépendances PHP
├── Procfile              # Configuration Heroku/Render
├── render.yaml           # Configuration Render
├── .env.example          # Variables d'environnement
└── README.md             # Ce fichier
```

## 🔒 Points Importants

1. **CORS activé** : Toutes les origines peuvent accéder à l'API
2. **SQLite intégré** : Pas besoin de configuration DB externe
3. **Validation email** : L'API valide les adresses email
4. **Unicité email** : Pas de doublons d'email
5. **Numéros de compte uniques** : Générés automatiquement

## 🐛 Dépannage

### Erreur "Class 'SQLite3' not found"
```bash
# Sur Windows (XAMPP)
# Décommenter dans php.ini : extension=sqlite3

# Sur Linux
sudo apt-get install php-sqlite3
```

### Erreur 404 sur les routes
Vérifier que mod_rewrite est activé dans Apache ou utiliser le serveur intégré PHP:
```bash
php -S localhost:8000 -t public
```

### Database.sqlite pas créée
Le fichier est créé automatiquement au premier démarrage. Vérifier les permissions du répertoire.

## 📝 Paramètres des Utilisateurs

| Champ | Type | Requis | Description |
|-------|------|--------|-------------|
| first_name | string | ✅ | Prénom |
| last_name | string | ✅ | Nom |
| email | string | ✅ | Email unique |
| phone | string | ✅ | Téléphone |
| account_type | string | ❌ | "standard" ou "premium" |
| balance | float | ❌ | Solde initial (défaut: 0.0) |

## 🎯 Codes HTTP

| Code | Signification |
|------|---------------|
| 200 | Succès |
| 201 | Créé avec succès |
| 400 | Requête invalide |
| 404 | Non trouvé |
| 405 | Méthode non autorisée |
| 500 | Erreur serveur |

## 📚 Documentation Swagger

Après déploiement sur Render, accédez à la documentation interactive via l'interface Swagger.

Les commentaires Swagger dans `UserController.php` génèrent automatiquement:
- Descriptions complètes
- Paramètres requis/optionnels
- Exemples de réponse
- Codes d'erreur

## 🤝 Support

Pour toute question ou problème, créer une issue GitHub.

---

**Version:** 1.0.0  
**Dernier mise à jour:** 19 avril 2026
