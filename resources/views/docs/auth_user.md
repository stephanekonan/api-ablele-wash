# AUTHENTIFICATION

## <li>Créer un nouvel Utilisateur</li>

Pour créer un nouvel utilisateur, utilise la méthode POST sur l'endpoint.
```
/api/client/auth/register
```
### Données Requises
Pour créer un nouvel utilisateur, tu dois fournir les données suivantes dans le corps de la requête :
```json
{
  "username": "string (obligatoire)",
  "email": "string (obligatoire, doit être unique)",
  "password": "string (obligatoire, minimum 6 caractères)",
  "cni": "string (obligatoire)",
  "phone": "string (obligatoire)"
}
```

## <li>Connexion de l'Utilisateur</li>

Pour se connecter, utilise la méthode POST sur l'endpoint.
```
/api/client/auth/login
```
### Données Requises

Pour la connexion, tu dois fournir les données suivantes dans le corps de la requête :

```json
{
  "email": "string (obligatoire, doit être une adresse e-mail valide et existante)",
  "password": "string (obligatoire)"
}
```

## <li>Déconnecter un utilisateur</li>
Pour se déconnecter, vous devrez être d'abord connecter. Utilisez la méthode DELETE sur l'enpoint.
```
 /api/client/auth/logout
```

# OBTENIR LES DONNÉES DES UTILISATEURS

## <li>Obtention des données de l'utilisateur connecté</li>

Pour obtenir les informations du profil de l'utilisateur actuellement connecté, utilisez la méthode `GET` sur l'enpoint
```
 /api/client/user
```
La réponse à cette requête est envoyée au format JSON.
Pour accéder aux informations de l'utilisateur connecté,
La réponse à cette requête est envoyée au format JSON. Si l'utilisateur est authentifié, tu obtiendras ses informations personnelles. Sinon, tu recevras un message indiquant que l'utilisateur n'est pas authentras ses informations personnelles. Sinon, tu recevras un message d'erreur indiquant qu'il faut s'authentifier pour continuer. La structure de la réponse est la suivante:
```json
|_ id: String, //Identifiant unique du client
|_ username: String, // Nom d'utilisation choisi par le client
|_ email: String, // Adresse mail du client
|_ cni: String, // Numéro CNI du client
|_ phone: String // Télèphe portable du client
```
## <li>Obtention des données de tous les utilisateurs</li>
Cette route renvoie toutes les informations des clients stockés dans la base de données.
La méthode à utiliser est `GET` sur l'enpoint

```
/api/admin/users
```
La réponse à cette requête est envoyée au format `JSON` des données de tous les utilisateurs de la base données.

