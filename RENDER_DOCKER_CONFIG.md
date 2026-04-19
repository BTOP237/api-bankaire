# 🚀 Configurer Render avec Dockerfile

## 📋 Configuration Render - Remplissage des Champs

Quand vous êtes sur la page de création du service Render, voici **EXACTEMENT** ce qu'il faut mettre:

### 🔧 Champs de Configuration

#### 1️⃣ Répertoire racine (Root Directory)
```
.
```
**Explication:** Le point (.) signifie le répertoire courant (racine du projet)

---

#### 2️⃣ Chemin du Dockerfile (Dockerfile Path)
```
./Dockerfile
```
**Explication:** Render va chercher le fichier `Dockerfile` à la racine du projet

---

#### 3️⃣ Variables Environnementales

Cliquer sur **"Environment"** et ajouter ces variables:

| Clé | Valeur | Optionnel? |
|-----|--------|----------|
| `APP_ENV` | `production` | ✅ Oui |
| `APP_DEBUG` | `false` | ✅ Oui |

**Comment les ajouter:**
1. Cliquer sur **"+ Add Environment Variable"**
2. Mettre la clé dans le premier champ
3. Mettre la valeur dans le deuxième champ
4. Cliquer sur le "+" pour ajouter la suivante

---

## 🎯 Résumé Complet des Champs

```
Name:                      banking-api
Environment:               Docker
Region:                    Frankfurt (EU Central)
Branch:                    main
Root Directory:            .
Dockerfile Path:           ./Dockerfile
Plan:                      Free
```

### Variables d'Environnement (Environment)
```
APP_ENV = production
APP_DEBUG = false
```

---

## ✅ Points Importants

✅ **N'oubliez pas:**
- Le `Dockerfile` est à la racine du projet
- Le répertoire racine est `.` (point)
- Les variables d'environnement sont optionnelles mais recommandées

❌ **Ne mettez PAS:**
- `Procfile` (inutile avec Docker)
- Build Command (Dockerfile s'en charge)
- Start Command (Dockerfile s'en charge)

---

## 🔍 Vérifier votre Structure

Votre projet doit ressembler à ceci:

```
ICT304/
├── Dockerfile              ← Render va le chercher ici
├── composer.json
├── public/
│   ├── index.php
│   ├── .htaccess
│   └── apache-config.conf
├── src/
│   ├── Database.php
│   └── UserController.php
└── ... autres fichiers
```

---

## 🚀 Étapes Finales

1. **Pousser le code** vers GitHub avec le Dockerfile:
   ```bash
   git add .
   git commit -m "Add Dockerfile for Render"
   git push
   ```

2. **Sur Render**, créer un nouveau **Web Service**

3. **Remplir les champs** avec les valeurs ci-dessus

4. **Cliquer "Create Web Service"**

5. **Attendre le déploiement** (2-3 minutes)

---

## 📊 Qu'est-ce que le Dockerfile?

Le `Dockerfile` c'est une liste d'instructions pour construire l'environnement:

```dockerfile
# Chaque ligne = une étape

# 1. Commencer avec une image PHP+Apache
FROM php:7.4-apache

# 2. Installer les extensions nécessaires
RUN docker-php-ext-install sqlite3 pdo_sqlite

# 3. Activer mod_rewrite
RUN a2enmod rewrite

# 4. Copier nos fichiers
COPY . /var/www/html

# 5. Installer les dépendances Composer
RUN composer install --no-dev

# 6. Exposer le port 8080
EXPOSE 8080

# 7. Lancer Apache
CMD ["apache2-foreground"]
```

**Avantage:** Plus léger et plus simple que Procfile pour Render!

---

## ❓ FAQ

**Q: Et si je vois "Port"?**  
R: Ne mettez rien. Le Dockerfile expose le port 8080 automatiquement.

**Q: Et si Render me demande "Build Command"?**  
R: Laissez vide. Docker s'en charge.

**Q: Et si le déploiement échoue?**  
R: Vérifier les **Logs** dans Render. C'est généralement un problème de permissions ou de Composer.

---

**C'est tout!** Suivez simplement les champs du tableau récapitulatif. 🎉
