# 🧪 Guide de Test de l'API Bancaire

Ce guide contient des exemples prêts à utiliser pour tester chaque endpoint.

## 📝 Avant de Commencer

1. Démarrer le serveur:
```bash
php -S localhost:8000 -t public
```

2. L'API sera accessible à: `http://localhost:8000/api/users`

---

## 🧪 Exemples cURL (Terminal/PowerShell)

### 1. Lister tous les utilisateurs

**Terminal (Bash):**
```bash
curl -X GET http://localhost:8000/api/users
```

**PowerShell (Windows):**
```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/users" -Method Get
```

---

### 2. Créer un utilisateur

**Terminal (Bash):**
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

**PowerShell (Windows):**
```powershell
$body = @{
    first_name = "Jean"
    last_name = "Dupont"
    email = "jean@example.com"
    phone = "+33612345678"
    account_type = "standard"
    balance = 1000.00
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/users" `
    -Method Post `
    -Headers @{"Content-Type"="application/json"} `
    -Body $body
```

---

### 3. Obtenir un utilisateur (ID 1)

**Terminal (Bash):**
```bash
curl -X GET http://localhost:8000/api/users/1
```

**PowerShell:**
```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/users/1" -Method Get
```

---

### 4. Mettre à jour un utilisateur (ID 1)

**Terminal (Bash):**
```bash
curl -X PUT http://localhost:8000/api/users/1 \
  -H "Content-Type: application/json" \
  -d '{
    "balance": 2500.00,
    "phone": "+33611111111"
  }'
```

**PowerShell:**
```powershell
$body = @{
    balance = 2500.00
    phone = "+33611111111"
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/users/1" `
    -Method Put `
    -Headers @{"Content-Type"="application/json"} `
    -Body $body
```

---

### 5. Supprimer un utilisateur (ID 1)

**Terminal (Bash):**
```bash
curl -X DELETE http://localhost:8000/api/users/1
```

**PowerShell:**
```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/users/1" -Method Delete
```

---

## 📊 Exemples Complets de Flux

### Flux Complet (Bash)

```bash
#!/bin/bash

API="http://localhost:8000/api"

echo "=== Créer 2 utilisateurs ==="
curl -X POST $API/users \
  -H "Content-Type: application/json" \
  -d '{"first_name":"Alice","last_name":"Martin","email":"alice@test.com","phone":"+33612345678","balance":1000}'

curl -X POST $API/users \
  -H "Content-Type: application/json" \
  -d '{"first_name":"Bob","last_name":"Smith","email":"bob@test.com","phone":"+33687654321","account_type":"premium","balance":5000}'

echo -e "\n=== Lister tous les utilisateurs ==="
curl -X GET $API/users

echo -e "\n=== Obtenir l'utilisateur 1 ==="
curl -X GET $API/users/1

echo -e "\n=== Mettre à jour l'utilisateur 1 ==="
curl -X PUT $API/users/1 \
  -H "Content-Type: application/json" \
  -d '{"balance":3000}'

echo -e "\n=== Supprimer l'utilisateur 1 ==="
curl -X DELETE $API/users/1

echo -e "\n\n✅ Tests terminés!"
```

### Flux Complet (PowerShell)

```powershell
$API = "http://localhost:8000/api"

Write-Host "=== Créer 2 utilisateurs ===" -ForegroundColor Cyan

$user1 = @{
    first_name = "Alice"
    last_name = "Martin"
    email = "alice@test.com"
    phone = "+33612345678"
    balance = 1000
} | ConvertTo-Json

Invoke-RestMethod -Uri "$API/users" -Method Post `
    -Headers @{"Content-Type"="application/json"} -Body $user1

$user2 = @{
    first_name = "Bob"
    last_name = "Smith"
    email = "bob@test.com"
    phone = "+33687654321"
    account_type = "premium"
    balance = 5000
} | ConvertTo-Json

Invoke-RestMethod -Uri "$API/users" -Method Post `
    -Headers @{"Content-Type"="application/json"} -Body $user2

Write-Host "`n=== Lister tous les utilisateurs ===" -ForegroundColor Cyan
Invoke-RestMethod -Uri "$API/users" -Method Get

Write-Host "`n=== Obtenir l'utilisateur 1 ===" -ForegroundColor Cyan
Invoke-RestMethod -Uri "$API/users/1" -Method Get

Write-Host "`n=== Mettre à jour l'utilisateur 1 ===" -ForegroundColor Cyan
$update = @{ balance = 3000 } | ConvertTo-Json
Invoke-RestMethod -Uri "$API/users/1" -Method Put `
    -Headers @{"Content-Type"="application/json"} -Body $update

Write-Host "`n=== Supprimer l'utilisateur 1 ===" -ForegroundColor Cyan
Invoke-RestMethod -Uri "$API/users/1" -Method Delete

Write-Host "`n✅ Tests terminés!" -ForegroundColor Green
```

---

## 🎯 Scénarios de Test

### ✅ Test: Email Unique
```bash
# Première requête (devrait réussir)
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{"first_name":"Test","last_name":"User","email":"test@unique.com","phone":"+33600000000"}'

# Deuxième requête avec le même email (devrait échouer)
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{"first_name":"Test2","last_name":"User2","email":"test@unique.com","phone":"+33611111111"}'
```

### ✅ Test: Validation Email
```bash
# Email invalide (devrait échouer)
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{"first_name":"Test","last_name":"User","email":"invalid-email","phone":"+33600000000"}'
```

### ✅ Test: Champs Obligatoires
```bash
# Manque le champ "email" (devrait échouer)
curl -X POST http://localhost:8000/api/users \
  -H "Content-Type: application/json" \
  -d '{"first_name":"Test","last_name":"User","phone":"+33600000000"}'
```

### ✅ Test: Utilisateur Non Trouvé
```bash
# Obtenir un utilisateur qui n'existe pas
curl -X GET http://localhost:8000/api/users/99999
```

---

## 📌 Notes Importantes

1. **IDs Auto-incrémentés**: Chaque utilisateur reçoit un ID unique
2. **Numéros de Compte**: Générés automatiquement au format `ACC000000` à `ACC999999`
3. **Horodatages**: Automatiquement définis à la création et la mise à jour
4. **CORS Activé**: L'API accepte les requêtes depuis n'importe quel domaine

---

## 🐛 Dépannage

| Problème | Solution |
|----------|----------|
| `Connection refused` | Vérifier que le serveur PHP est lancé (`php -S localhost:8000 -t public`) |
| `404 Not Found` | Vérifier l'URL et que les routes sont correctes |
| `400 Bad Request` | Vérifier le format JSON et les champs requis |
| `500 Internal Server Error` | Consulter les logs PHP |

---

## 🔗 Ressources Utiles

- [Documentation complète](DOCUMENTATION.md)
- [README.md](README.md)
- [Endpoints Swagger](http://localhost:8000/swagger/index.html) (après génération)

---

**Version:** 1.0.0  
**Dernier mise à jour:** 19 avril 2026
