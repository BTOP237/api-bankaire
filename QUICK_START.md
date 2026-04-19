# ⚡ Quick Start - Démarrage Rapide

Vous êtes pressé? Voici les 3 commandes pour démarrer:

## 🚀 Démarrage (30 secondes)

```bash
# 1. Naviguer vers le dossier
cd c:\Users\DARKSIDE\Desktop\ICT304

# 2. Installer les dépendances
composer install

# 3. Lancer le serveur
php -S localhost:8000 -t public
```

✅ **C'est prêt!** L'API fonctionne sur: `http://localhost:8000/api/users`

---

## 🧪 Test Rapide (PowerShell)

```powershell
# Créer un utilisateur
$body = @{first_name="Jean"; last_name="Dupont"; email="jean@test.com"; phone="+33600000000"} | ConvertTo-Json
Invoke-RestMethod -Uri "http://localhost:8000/api/users" -Method Post -Headers @{"Content-Type"="application/json"} -Body $body

# Lister les utilisateurs
Invoke-RestMethod -Uri "http://localhost:8000/api/users" -Method Get
```

---

## 📚 Documentation

| Document | Pour Quoi? |
|----------|-----------|
| [README.md](README.md) | Overview complet |
| [DOCUMENTATION.md](DOCUMENTATION.md) | Endpoints détaillés |
| [TEST_EXAMPLES.md](TEST_EXAMPLES.md) | Exemples de test |
| [RENDER_DEPLOYMENT.md](RENDER_DEPLOYMENT.md) | Déployer sur Render |

---

## 🌐 Déployer sur Render (5 minutes)

1. Pousser vers GitHub: `git push`
2. Sur [render.com](https://render.com): New Web Service
3. Connecter votre repository
4. Configurer avec les détails dans **RENDER_DEPLOYMENT.md**
5. C'est live! 🚀

---

**Besoin de plus de détails?** Voir [DOCUMENTATION.md](DOCUMENTATION.md)
