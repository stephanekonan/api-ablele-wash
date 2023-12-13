# LES LAVAGES AUTO GERANT

## <li>Obtention de tous les  lavages auto du gérant connecté</li>
Lorsque l'on veut obtenir tout les lavages auto de la base de données, on utilise la méthode ``GET`` sur l'endpoint
### Tu dois être connecté comme gérant

```
/api/gerant/lavages
```

## <li>Obtention d'un lavage du gérant connecté</li>
Lorsque l'on veut obtenir tout les lavages auto de la base de données, on utilise la méthode ``GET`` sur l'endpoint
### Tu dois être connecté comme gérant

```
/api/gerant/lavage/show/{id}
```
Resultat :

```
/api/gerant/lavage/show/2
```

```json

{
  "id": 2, // ID de lavage
  "lavage_name": "Nom du Lavage", // Nom du lavage
  "status": "actif", // status du lavage actif ou inactif
  "commune_id": 1, // commune associé au lavage
  "photo": "nom_de_l_image.jpg", // photo du lavage
  "user_id": 3 // id du gerant connecté
}

```

## <li>Création de lavage</li>

### Tu dois être connecté comme gérant pour pouvoir créer un nouveau lavage

Ici c'est la méthode ``POST`` qui est utilisée

```
/api/gerant/lavage/store
```

### Paramètres de Requête
| Paramètre | Type   | Description         |
|-----------|--------|---------------------|
| id        | int    | Identifiant de lavage        |
|lavage_name| string | Nom du lavage       |
| status    | string | Statut du lavage    |
| commune_id  | int    | Identifiant de la commune |
| photo        | int    | URL de l'image            |
| user_id        | int    | ID de l'utilisateur |

Le statut est enregistré par defaut ``actif``

```json
{
  "id": "number",
  "created_at": "string (format ISO 8601)",
  "updated_at": "string (format ISO 8601)",
  "lavage_name": "string",
  "photo": "string",
  "user_id": "number",
  "commune_id": "number",
  "status": "string (default: 'actif')"
}
```

## <li>Lecture des données d’un lavage</li>
La méthode utilisée est la ``GET``

```
/api/gerant/lavage/show/{id}
```
Resultat:

```
/api/gerant/lavage/show/2
```

```json
{
  "message": "Données du lavage: Nom du Lavage",
  "data": {
    "lavage": {
      "id": 2,
      "lavage_name": "Nom du Lavage",
      "status": "actif",
      "commune_id": 1,
      "photo": "nom_de_l_image.jpg",
      "user_id": 3
    },
    "typesLavages": [
      // Tableau des types de lavages liés à l'utilisateur connecté
      // Chaque élément du tableau pourrait ressembler à {"id": 1, "name": "Type 1", ...}
    ],
    "associatedTypes": [
      // Tableau des types de lavages associés au lavage spécifique
      // Chaque élément du tableau pourrait être un identifiant de type de lavage (par exemple, [1, 2, 3])
    ]
  }
}
```

## <li>Edition d'un lavage auto</li>
La méthode utilisée est la ``GET``

```
/api/gerant/lavage/edit/{id}
```
Resultat:


```
/api/gerant/lavage/show/2
```
```json
{
  "message": "Données du lavage Nom du Lavage à éditer",
  "data": {
    "lavage": {
      "id": 2,
      "lavage_name": "Nom du Lavage",
      "status": "actif",
      "commune_id": 1,
      "photo": "nom_de_l_image.jpg",
      "user_id": 3
    },
    "typesLavages": [
      // Tableau des types de lavages liés à l'utilisateur connecté
      // Chaque élément du tableau pourrait ressembler à {"id": 1, "name": "Type 1", ...}
    ],
    "associatedTypes": [
      // Tableau des types de lavages associés au lavage spécifique
      // Chaque élément du tableau pourrait être un identifiant de type de lavage (par exemple, [1, 2, 3])
    ]
  }
}
```

## <li>Mise à jour de lavage auto</li>
La méthode utilisée est la ``PUT``

```
/api/gerant/lavage/update/{id}
```
Resultat: 

```
/api/gerant/lavage/update/2
```
```json
{
  "message": "Mise à jour affectuée avec succès",
  "data": {
    "lavage": {
      "id": 2,
      "lavage_name": "Nom du Lavage",
      "status": "actif",
      "commune_id": 1,
      "photo": "nom_de_l_image.jpg",
      "user_id": 3
    },
    "typesLavages": [
      // Tableau des types de lavages liés à l'utilisateur connecté
      // Chaque élément du tableau pourrait ressembler à {"id": 1, "name": "Type 1", ...}
    ],
    "associatedTypes": [
      // Tableau des types de lavages associés au lavage spécifique
      // Chaque élément du tableau pourrait être un identifiant de type de lavage (par exemple, [1, 2, 3])
    ]
  }
}
```

## <li>Supprimer un lavage auto</li>
La méthode utilisée est la ``DELETE``

```
/api/gerant/lavage/delete/{id}
```
Resultat: 

```
/api/gerant/lavage/delete/2
```
```json
{
  "message": "Lavage auto supprimé avec succès",
}
```
