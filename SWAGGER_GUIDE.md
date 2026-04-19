# 📖 Swagger - Documentation Interactive

## 🎯 Accéder à Swagger

### Sur Render (Production)
```
https://api-bankaire.onrender.com/swagger.html
```

### Localement
```
http://localhost:8000/swagger.html
```

---

## ✨ Qu'est-ce que Swagger?

**Swagger** (maintenant OpenAPI) est une norme pour documenter les APIs REST de manière interactive.

Vous pouvez:
- ✅ **Voir tous les endpoints**
- ✅ **Comprendre les paramètres requis**
- ✅ **Tester directement** les endpoints
- ✅ **Voir les réponses** d'exemple
- ✅ **Générer du code client**

---

## 📋 Endpoints dans Swagger

### 1️⃣ GET /api/users
**Description:** Lister tous les utilisateurs

**Réponse:**
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
      ...
    }
  ]
}
```

### 2️⃣ POST /api/users
**Description:** Créer un nouvel utilisateur

**Corps (JSON):**
```json
{
  "first_name": "Alice",
  "last_name": "Martin",
  "email": "alice@example.com",
  "phone": "+33612345678",
  "account_type": "premium",
  "balance": 5000
}
```

### 3️⃣ GET /api/users/{id}
**Description:** Obtenir un utilisateur par ID

**Paramètre:**
- `id` : ID de l'utilisateur (integer)

### 4️⃣ PUT /api/users/{id}
**Description:** Mettre à jour un utilisateur

**Corps (JSON):**
```json
{
  "balance": 2500.00,
  "phone": "+33611111111"
}
```

### 5️⃣ DELETE /api/users/{id}
**Description:** Supprimer un utilisateur

---

## 🧪 Test dans Swagger UI

### Étape 1: Ouvrir Swagger
```
https://api-bankaire.onrender.com/swagger.html
```

### Étape 2: Tester GET /api/users
1. Cliquer sur **"GET /api/users"**
2. Cliquer sur **"Try it out"**
3. Cliquer sur **"Execute"**
4. Voir la réponse en bas

### Étape 3: Tester POST /api/users
1. Cliquer sur **"POST /api/users"**
2. Cliquer sur **"Try it out"**
3. Remplir le corps JSON:
   ```json
   {
     "first_name": "Test",
     "last_name": "User",
     "email": "test@example.com",
     "phone": "+33600000000"
   }
   ```
4. Cliquer sur **"Execute"**

### Étape 4: Récupérer l'ID de l'utilisateur créé

La réponse contiendra l'ID (ex: `"id": 1`). Noter cet ID.

### Étape 5: Tester GET /api/users/{id}
1. Cliquer sur **"GET /api/users/{id}"**
2. Cliquer sur **"Try it out"**
3. Remplir **id** avec l'ID obtenu (ex: `1`)
4. Cliquer sur **"Execute"**

---

## 🔍 Structure de Swagger

La page `swagger.html` contient:

1. **Spec OpenAPI inline** (toute la doc en JSON)
2. **Swagger UI** (interface interactive)
3. **CDN** (pas besoin d'installation!)

### Avantages:
- ✅ Aucune dépendance à installer
- ✅ Fonctionne offline (après premier chargement)
- ✅ Pas de serveur Swagger externe
- ✅ Facile à mettre à jour

---

## 📝 Schémas de Données

### User (Réponse)
```
id: integer (auto)
first_name: string
last_name: string
email: string
phone: string
account_number: string (auto)
balance: float
account_type: string (standard|premium)
created_at: date-time
updated_at: date-time
```

### UserInput (Pour créer)
```
first_name: string (requis)
last_name: string (requis)
email: string (requis)
phone: string (requis)
account_type: string (optionnel, défaut: standard)
balance: float (optionnel, défaut: 0)
```

### UserUpdate (Pour modifier)
```
first_name: string (optionnel)
last_name: string (optionnel)
phone: string (optionnel)
balance: float (optionnel)
```

---

## 🚀 Utiliser Swagger pour Développer

Swagger est utile pour:

### Pour Tester
- Tester rapidement les endpoints
- Vérifier les réponses
- Valider les schémas

### Pour Documenter
- Générer une doc automatiquement
- Montrer aux clients l'API
- Créer un contrat API

### Pour Générer du Code
- Générer des SDK (JavaScript, Python, Go, etc.)
- Générer des clients API
- Générer des serveurs boilerplate

---

## 💡 Conseils

1. **Garder Swagger à jour** = Garder les commentaires à jour
2. **Tester dans Swagger** avant de déployer
3. **Partager Swagger** avec vos collègues
4. **Utiliser Swagger** pour la documentation client

---

## 🔗 Liens Utiles

- [OpenAPI Specification](https://spec.openapis.org/oas/v3.0.0)
- [Swagger UI](https://swagger.io/tools/swagger-ui/)
- [Swagger Editor](https://editor.swagger.io/)

---

**Swagger est maintenant accessible à:**
```
https://api-bankaire.onrender.com/swagger.html
```

**Amusez-vous à tester l'API!** 🎉
