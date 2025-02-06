## The District Symfony Dev-App

<img src="public/assets/img/the_district_brand/twitter_header_photo_2.png" width="500">

### Base de données :

- [x] Création de la base de données
- [x] Ajout des données avec fixtures

### Structure du site et gestion des accès :

- [x] Mise en place de la structure du site
- [x] Gestion de l'authentification
- [x] Gestion des rôles et de l'accès aux pages
- [x] Page de gestion des plats et des commandes pour le `ROLE_CHEF` et `ROLE_ADMIN`

### Mise en place de l'API avec Api Platform :

- [x] Installation d'Api Platform
- [x] Rendre visibles les entités Catégories et Plats
- [x] Utilisation de l'API dans l'application
- [x] Rendre disponible la documentation de l'API via OpenAPI (ex. Swagger) (-- Désactiver asset_mapper --)

### Panier et gestion des commandes :

- [x] Mise en place du panier (list, add, remove) dans un `service`
- [x] Validation de la commande
- [x] Gestion des mails via un `EventSubscriber` ([MailHog](https://github.com/mailhog/MailHog))

### Gestion du profil utilisateur :

- [x] Modification des informations personnelles du compte
- [x] Modification de l'adresse email et du mot de passe du comtpe
- [ ] Suppression du compte
- [x] Historique des commandes

### Design et responsivité :

- [x] Utilisation de [Bootstrap](https://getbootstrap.com/) (5.3.3)
- [x] Site entièrement responsive

### Sécurité :

- [x] Jeton CSRF sur les formulaires personnalisés
- [ ] Gestion des permissions de l'API

---

### Exercices :

Liens vers les exercices du module Dev-App

- [Symfony](https://github.com/MickaelMd/AFPA_MS_Dev_App/tree/1.-Symfony)
- [React](https://github.com/MickaelMd/AFPA_MS_Dev_App/tree/2.-React)

Pour cloner une seule branche du dépôt :

The District

```bash
git clone --single-branch --branch main https://github.com/MickaelMd/AFPA_MS_Dev_App.git
```

Exercices Symfony

```bash
bashgit clone --single-branch --branch 1.-Symfony https://github.com/MickaelMd/AFPA_MS_Dev_App.git
```

Exercices React

```bash
git clone --single-branch --branch 2.-React https://github.com/MickaelMd/AFPA_MS_Dev_App.git
```
