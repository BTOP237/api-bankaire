# 🚀 Guide Détaillé: Déploiement sur Render

Ce guide explique étape par étape comment déployer votre API Bancaire sur **Render.com** (gratuitement).

## 📋 Prérequis

- ✅ Un compte **GitHub** (gratuit sur github.com)
- ✅ Un compte **Render** (gratuit sur render.com)
- ✅ Votre code API dans un repository GitHub

## 🎯 Étape 1: Créer un Repository GitHub

### 1.1 Sur Votre Ordinateur (PowerShell ou Terminal)

```bash
# Naviguer vers votre dossier de projet
cd c:\Users\DARKSIDE\Desktop\ICT304

# Initialiser Git
git init

# Ajouter tous les fichiers
git add .

# Premier commit
git commit -m "Initial commit: API Bancaire"

# Renommer la branche (optionnel, pour compatibilité)
git branch -M main
```

### 1.2 Sur GitHub (Site Web)

1. **Aller sur [github.com](https://github.com)**
2. **Cliquer sur le "+" en haut à droite → "New repository"**
3. **Remplir les détails:**
   - Repository name: `banking-api`
   - Description: `API Bancaire PHP avec Swagger`
   - Public ou Private (les deux fonctionnent)
   - Cliquer sur "Create repository"

### 1.3 Connecter votre Repository Local

GitHub va vous afficher des commandes. Exécuter celles-ci dans votre terminal:

```bash
git remote add origin https://github.com/YOUR_USERNAME/banking-api.git
git push -u origin main
```

**Remplacer `YOUR_USERNAME` par votre nom d'utilisateur GitHub.**

✅ **Vérifier**: Rafraîchir la page GitHub - vos fichiers doivent être visibles.

---

## 🎯 Étape 2: Créer un Compte Render

1. **Aller sur [render.com](https://render.com)**
2. **Cliquer sur "Sign Up"**
3. **S'inscrire avec GitHub** (recommandé - plus simple)
4. **Autoriser Render à accéder à GitHub**

---

## 🎯 Étape 3: Créer un Web Service sur Render

### 3.1 Créer le Service

1. **Dans le Dashboard Render, cliquer sur "New +"**
2. **Sélectionner "Web Service"**

### 3.2 Connecter votre Repository

1. **Cliquer sur "Connect account"** (si nécessaire)
2. **Autoriser Render à accéder à GitHub**
3. **Sélectionner votre repository `banking-api`**
4. **Cliquer sur "Connect"**

---

## 🎯 Étape 4: Configurer le Service

Sur la page de création du Web Service, remplir:

| Champ | Valeur | Explication |
|-------|--------|-------------|
| **Name** | `banking-api` | Nom du service (visible dans l'URL) |
| **Environment** | `PHP` | Langage (important!) |
| **Region** | `Frankfurt (EU Central)` | Région la plus proche de vous |
| **Branch** | `main` | La branche à déployer |
| **Build Command** | `composer install --no-dev` | Installer les dépendances |
| **Start Command** | `vendor/bin/heroku-php-apache2 public/` | Comment lancer l'API |
| **Plan** | `Free` | Plan gratuit |

**Important:** Descendre et cliquer sur **"Create Web Service"**

---

## 🎯 Étape 5: Vérifier le Déploiement

1. **Render va afficher un écran avec les logs**
2. **Attendre que le statut passe de "In Progress" à "Live"** (2-3 minutes)
3. **Vous recevrez une URL comme: `https://banking-api-xxxxx.onrender.com`**

📌 **Si le déploiement échoue:**
- Cliquer sur "Logs" pour voir les erreurs
- Vérifier que `Procfile` existe et est correct
- Vérifier que `public/index.php` est valide

---

## 🎯 Étape 6: Tester votre API en Ligne

### 6.1 Tester avec cURL

```bash
# Remplacer "banking-api-xxxxx" par votre URL réelle
curl https://banking-api-xxxxx.onrender.com/api/users
```

### 6.2 Tester la Création d'Utilisateur

**PowerShell:**
```powershell
$url = "https://banking-api-xxxxx.onrender.com/api/users"
$body = @{
    first_name = "Jean"
    last_name = "Dupont"
    email = "jean@example.com"
    phone = "+33612345678"
    account_type = "standard"
    balance = 1000.00
} | ConvertTo-Json

Invoke-RestMethod -Uri $url -Method Post `
    -Headers @{"Content-Type"="application/json"} -Body $body
```

**Bash:**
```bash
curl -X POST https://banking-api-xxxxx.onrender.com/api/users \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "Jean",
    "last_name": "Dupont",
    "email": "jean@example.com",
    "phone": "+33612345678"
  }'
```

---

## 🔄 Étape 7: Mettre à Jour votre API

Une fois en ligne, chaque fois que vous faites un `git push`:

```bash
# Faire vos modifications
# ...

# Ajouter et committer
git add .
git commit -m "Description des changements"

# Pousser vers GitHub
git push
```

**Render déploiera automatiquement** la nouvelle version! ✨

---

## 📊 Vérifier l'État du Service

### Sur Render Dashboard:

1. **Aller sur Render Dashboard**
2. **Cliquer sur votre service `banking-api`**
3. **Voir:**
   - **Status**: Actif/En cours/Erreur
   - **Logs**: Messages de déploiement et erreurs
   - **Environment**: Variables d'environnement
   - **Health Checks**: Santé du service

---

## ⚙️ Variables d'Environnement (Optionnel)

Si vous voulez ajouter des variables d'environnement:

1. **Dans le Dashboard du service**
2. **Aller à "Environment"**
3. **Ajouter des variables:**

```
APP_ENV=production
APP_DEBUG=false
DB_FILE=/tmp/database.sqlite
```

---

## 🆘 Troubleshooting

### ❌ Erreur: "Build failed"

**Solution:**
1. Vérifier que `composer.json` est valide
2. Consulter les logs Render
3. Vérifier que `Procfile` existe

```bash
# Tester localement d'abord
php -S localhost:8000 -t public
```

### ❌ Erreur: "Cannot find database.sqlite"

**Raison:** SQLite est créé dynamiquement au premier lancement.
- Faire une première requête POST
- La base de données se créera automatiquement

### ❌ Erreur: "Connection refused"

**Vérifier:**
1. L'URL est correcte
2. Attendre 2-3 minutes après le déploiement
3. Vérifier sur Render que le service est "Live"

### ❌ Erreur: 404 Not Found

**Vérifier:**
1. L'URL de l'endpoint est correcte
2. Exemple correct: `https://banking-api-xxxxx.onrender.com/api/users`

---

## 📌 Notes Importantes

### Espace Disque sur Render

- **Plan Free:** 400 MB au total
- **SQLite** utilisera quelques MB
- **Uploads** sont limités

### Mise à l'Arrêt Automatique

- Les services Free s'arrêtent après **15 minutes** d'inactivité
- **Redémarrage automatique** à la première requête (prend 30 secondes)

### Sauvegardes de Base de Données

Render n'accorde **pas de stockage persistant** sur le plan Free. Pour éviter les pertes:

1. **Utiliser une base de données externe** (MongoDB Atlas, PostgRES, etc.)
2. **Ou exporter les données régulièrement:**

```bash
# Télécharger la base de données
curl -o backup.sqlite https://banking-api-xxxxx.onrender.com/database.sqlite
```

---

## ✅ Checklist Finale

- [ ] Repository GitHub créé
- [ ] Code pousse sur GitHub
- [ ] Compte Render créé
- [ ] Web Service créé et configuré
- [ ] Déploiement réussi (Status = "Live")
- [ ] Test de l'API réussi
- [ ] URL notée quelque part 📝

---

## 🎉 Résumé

Votre API est maintenant **en ligne et accessible** à:

```
https://banking-api-xxxxx.onrender.com/api/users
```

**Points clés:**
- ✅ Gratuit (plan Free)
- ✅ Déploiement automatique via GitHub
- ✅ Base de données SQLite intégrée
- ✅ Accessible de partout
- ✅ Peut gérer plusieurs utilisateurs simultanés

---

## 📚 Ressources

- [Documentation Render](https://render.com/docs)
- [GitHub Docs](https://docs.github.com)
- [PHP Buildpack (Render)](https://render.com/docs/deploy-php)

---

**Besoin d'aide?** Consultez les logs Render ou les fichiers de documentation du projet! 🤝

**Version:** 1.0.0  
**Date:** 19 avril 2026
