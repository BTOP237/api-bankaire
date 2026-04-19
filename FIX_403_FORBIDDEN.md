# 🔧 Correction de l'Erreur 403 Forbidden

Vous avez l'erreur:
```
403 Forbidden
You don't have permission to access this resource.
```

## ❌ Cause du Problème

L'erreur 403 vient généralement de:
1. **Permissions insuffisantes** sur les fichiers/dossiers
2. **Configuration Apache** qui pointe mal vers `public/`
3. **Port de communication** mal configuré

## ✅ Solutions (dans l'ordre)

### Solution 1: Utiliser le Dockerfile Simplifié

J'ai créé un **Dockerfile.alt** plus simple et robuste.

**Sur votre ordinateur:**
```bash
# Remplacer le Dockerfile par la version simplifié
move Dockerfile Dockerfile.old
move Dockerfile.alt Dockerfile

# Commit et push
git add Dockerfile Dockerfile.old
git commit -m "Fix: Utiliser Dockerfile simplifié pour 403 Forbidden"
git push
```

**Sur Render:**
1. Le service va redéployer automatiquement
2. Attendre les logs → chercher "Build successfully completed"
3. Puis tester: `curl https://api-bankaire.onrender.com/`

### Solution 2: Vérifier les Logs Render

Si ça ne fonctionne pas:

1. **Aller sur Render Dashboard**
2. **Cliquer sur votre service**
3. **Aller à "Logs"**
4. **Chercher les erreurs**

Erreurs courantes:
```
# ❌ Si vous voyez ceci
Permission denied while trying to connect to Docker daemon

# ❌ Si vous voyez ceci
php: command not found

# ❌ Si vous voyez ceci
Module not found: pdo_sqlite
```

### Solution 3: Vérifier les Permissions (Localement)

Vérifier que votre structure est correcte:

```bash
# Sur Windows, vérifier que les fichiers existent
dir c:\Users\DARKSIDE\Desktop\ICT304\public\index.php
dir c:\Users\DARKSIDE\Desktop\ICT304\public\.htaccess
dir c:\Users\DARKSIDE\Desktop\ICT304\composer.json
```

### Solution 4: Vérifier le Port

Render peut utiliser un port différent. Essayer:

```bash
# Port 80 (par défaut)
curl https://api-bankaire.onrender.com/

# Port 8080
curl https://api-bankaire.onrender.com:8080/

# Port 3000
curl https://api-bankaire.onrender.com:3000/
```

---

## 🎯 Quelle Solution Essayer?

| Situation | Solution |
|-----------|----------|
| Premier déploiement échoue | Solution 1 (Dockerfile.alt) |
| Ça compile mais 403 Forbidden | Solution 1 + 2 (vérifier logs) |
| Doute sur les fichiers | Solution 3 (vérifier structure) |
| Port introuvable | Solution 4 (tester différents ports) |

---

## 🚀 Déploiement avec Dockerfile.alt

### Étape 1: Sur votre ordi

```bash
cd c:\Users\DARKSIDE\Desktop\ICT304

# Option A: Simplement utiliser le .alt
move Dockerfile Dockerfile.bak
move Dockerfile.alt Dockerfile

# Option B: Ou directement sur Render
# Cliquer Settings → Source → Dockerfile Path
# Mettre: ./Dockerfile.alt
```

### Étape 2: Push vers GitHub

```bash
git add Dockerfile
git commit -m "Fix 403: Utiliser Dockerfile simplifié"
git push
```

### Étape 3: Render redéploie automatiquement

- Attendre 3-5 minutes
- Vérifier les logs
- Tester: `curl https://api-bankaire.onrender.com/api/users`

---

## ✅ Résultat Attendu

Si ça fonctionne, vous verrez:

```json
{
  "message": "Bienvenue dans l'API Bancaire",
  "version": "1.0.0",
  "documentation": "/swagger/index.html"
}
```

Au lieu de:
```html
<h1>403 Forbidden</h1>
```

---

## 🆘 Si Ça Toujours Ne Fonctionne Pas

1. **Vérifier les logs Render** (message d'erreur exact)
2. **Vérifier que composer.json existe**
3. **Vérifier que public/index.php existe**
4. **Attendre 5 minutes** (Render peut avoir besoin de temps)

---

**Quelle erreur voyez-vous dans les logs Render?** Partager-les pour debug plus précis! 🔍
