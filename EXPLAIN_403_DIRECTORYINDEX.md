# 🔍 Explication de l'Erreur 403 - DirectoryIndex

## ❌ L'Erreur que vous aviez

```
AH01276: Cannot serve directory /var/www/html/: 
No matching DirectoryIndex (index.php,index.html) found
```

## 🎯 Ce que ça signifie

Apache cherche:
```
/var/www/html/index.php
    ou
/var/www/html/index.html
```

Mais il ne les trouve **PAS** car ils sont dans:
```
/var/www/html/public/index.php  ← ICI!
```

## ✅ La Solution

**Le DocumentRoot doit pointer vers `/var/www/html/public/`**

Avant (❌ FAUX):
```apache
DocumentRoot /var/www/html
└── public/
    └── index.php  ← Apache ne la trouve pas!
```

Après (✅ CORRECT):
```apache
DocumentRoot /var/www/html/public
└── index.php  ← Apache la trouve!
```

## 📝 Dockerfile Corrigé

La clé c'est cette partie du Dockerfile:

```dockerfile
RUN cat > /etc/apache2/sites-available/000-default.conf <<'EOF'
<VirtualHost *:80>
    ServerAdmin admin@localhost
    DocumentRoot /var/www/html/public    ← C'EST LA LIGNE IMPORTANTE!

    <Directory /var/www/html/public>
        Options FollowSymLinks
        AllowOverride All
        Require all granted

        RewriteEngine On
        RewriteBase /
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php [QSA,L]
    </Directory>
</VirtualHost>
EOF
```

## 🚀 Redéployer

```bash
# Commit et push
git add Dockerfile
git commit -m "Fix: DocumentRoot pointe maintenant vers public/"
git push
```

Render redéploiera automatiquement. Attendre 3-5 minutes.

## ✅ Test Après

```bash
curl https://api-bankaire.onrender.com/api/users
```

Vous devriez voir du JSON:
```json
{
  "success": true,
  "count": 0,
  "data": []
}
```

Au lieu de:
```html
<h1>403 Forbidden</h1>
```

---

## 📚 Explications Apache

| Directive | Explication |
|-----------|-------------|
| `DocumentRoot` | Le dossier d'où Apache sert les fichiers |
| `DirectoryIndex` | Le fichier par défaut à chercher (index.php, index.html) |
| `RewriteEngine` | Active la réécriture d'URLs |
| `RewriteRule` | Redirige les requêtes vers index.php |

---

**Besoin d'aide?** Partager les nouveaux logs Render après le git push! 👍
