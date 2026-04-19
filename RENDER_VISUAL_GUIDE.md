# 🎨 RENDER - Formulaire Visuel

Voici ce que vous allez voir sur Render et ce qu'il faut mettre:

## 📝 Étape 1: Informations Générales

```
┌─────────────────────────────────────────────────────┐
│ Name                                  │ banking-api │
├─────────────────────────────────────────────────────┤
│ Environment                           │   Docker   │
├─────────────────────────────────────────────────────┤
│ Region                                │ Frankfurt  │
├─────────────────────────────────────────────────────┤
│ Branch                                │    main    │
└─────────────────────────────────────────────────────┘
```

---

## 📂 Étape 2: Docker (REMPLIR CES CHAMPS)

```
┌─────────────────────────────────────────────────────┐
│ Root Directory                        │      .      │
│ (Répertoire racine)                   │             │
├─────────────────────────────────────────────────────┤
│ Dockerfile Path                       │ ./Dockerfile│
│ (Chemin du Dockerfile)                │             │
└─────────────────────────────────────────────────────┘
```

### 📌 Explications

- **Root Directory (`.`)**: Racine de votre projet GitHub
  - Ne mettez pas: `public/`, `src/`, etc.
  - Juste: `.` ou laisser vide

- **Dockerfile Path (`./Dockerfile`)**: Chemin vers votre Dockerfile
  - Le fichier doit être à: `c:\Users\DARKSIDE\Desktop\ICT304\Dockerfile`
  - La valeur à mettre: `./Dockerfile`
  - Alternatives acceptées: `Dockerfile` ou `./Dockerfile`

---

## 🔐 Étape 3: Variables d'Environnement

```
┌─────────────────────────────────────────────────────┐
│ Environment Variables                               │
├─────────────────────────────────────────────────────┤
│ Clé              │ Valeur                          │
├──────────────────┼─────────────────────────────────┤
│ APP_ENV          │ production                      │
├──────────────────┼─────────────────────────────────┤
│ APP_DEBUG        │ false                           │
└─────────────────────────────────────────────────────┘
```

### 📌 Comment Ajouter

1. Cliquer sur **"+ Add"** (ou similaire)
2. Remplir **Clé**: `APP_ENV`
3. Remplir **Valeur**: `production`
4. Cliquer **+** pour ajouter la suivante
5. Remplir **Clé**: `APP_DEBUG`
6. Remplir **Valeur**: `false`

---

## 💾 Étape 4: Plan

```
┌─────────────────────────────────────────────────────┐
│ Plan                          │     Free (Gratuit)  │
│                               │                     │
│ ✅ Recommandé pour tester     │                     │
└─────────────────────────────────────────────────────┘
```

---

## 🟢 Étape 5: Créer le Service

```
┌──────────────────────────────┐
│   Create Web Service         │
│        (Bouton Bleu)         │
└──────────────────────────────┘
```

### ⏳ Après avoir cliqué

- Render va afficher les **Logs de construction**
- Ça prend **2-3 minutes**
- Chercher des messages comme:
  - ✅ `Build successfully completed`
  - ✅ `Service is live`

---

## 📋 Checklist Avant de Soumettre

```
☐ Répertoire racine: .
☐ Chemin Dockerfile: ./Dockerfile  
☐ APP_ENV: production
☐ APP_DEBUG: false
☐ Plan: Free
☐ Fichier Dockerfile existe sur GitHub
☐ composer.json existe
☐ public/index.php existe
```

---

## ✅ Résultat

Si tout est correct, vous verrez:

```
✅ Live
   Banking API
   https://banking-api-xxxxx.onrender.com

   Status: Active
   Last deployed: 2 minutes ago
```

---

## 🔗 L'API sera accessible à

```
https://banking-api-xxxxx.onrender.com/api/users
                    ^^^^^ Render génère cet ID
```

---

## 🆘 Troubleshooting

| Problème | Solution |
|----------|----------|
| Build failed | Vérifier que `Dockerfile` est à la racine |
| Files not found | Vérifier que `./Dockerfile` est correct |
| Port error | Le Dockerfile expose déjà le port 8080 |
| SQLite error | Le dossier `/var/www/html/data` est créé automatiquement |

---

## 📸 Réaction des Fichiers

Render va créer:

```
GitHub (votre repo)
    ↓
Render détecte Dockerfile
    ↓
Construit l'image Docker
    ↓
Lance le conteneur
    ↓
Apache démarre sur le port 8080
    ↓
API accessible! 🚀
```

---

**C'est aussi simple que ça!** Juste ces trois champs. 🎯
