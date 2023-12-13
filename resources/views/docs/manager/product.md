# Documentation API - Gestion des Produits

## <li>Liste des produits du gérant connecté</li>
Obtenez la liste de tous les produits du gérant connecté en utilisant la méthode `GET` sur l'endpoint.

**Endpoint:**
```
/api/gerant/products
```


## <li>Détails d'un produit spécifique</li>
Obtenez les détails d'un produit spécifique en utilisant la méthode `GET` sur l'endpoint.

**Endpoint:**
```
/api/gerant/product/show/{product_id}
```


**Résultat:**
```json
{
  "message": "Informations sur le produit Titre du Produit",
  "data": {
    "product": {
      "id": 1,
      "title": "Titre du Produit",
      "description": "Description du Produit",
      "original_price": 19.99,
      "image": "nom_de_l_image.jpg",
      "instock": 10,
      "user_id": 3,
      "status": "actif",
      "created_at": "2023-12-11T12:34:56Z",
      "updated_at": "2023-12-11T12:34:56Z"
    },
    "albums": [
      {
        "id": 1,
        "photos": "image1.jpg|image2.jpg",
        "product_id": 1,
        "lavage_id": 2,
        "created_at": "2023-12-11T12:34:56Z",
        "updated_at": "2023-12-11T12:34:56Z"
      }
    ]
  }
}
```

## <li>Création d'un nouveau produit</li>

Créez un nouveau produit en utilisant la méthode POST sur l'endpoint.

Endpoint:

```
/api/gerant/product/store
```

Paramètres de Requête:
|Paramètre	| Type	| Description|
|-----------|--------|---------------------|
title	| string	|Titre du produit|
description	|string	|Description du produit|
original_price	|float	|Prix original du produit|
|image	|file	|Image du produit|
|instock	|int	|Stock disponible du produit|
lavage_id	|int	|ID du lavage associé|
category_id|	int	|ID de la catégorie associée|
|photos (array)	|files	|Tableau d'images additionnelles du produit|


Exemple de Corps de Requête JSON:
```json
{
  "title": "Nouveau Produit",
  "description": "Description du Nouveau Produit",
  "original_price": 29.99,
  "image": "nom_de_l_image.jpg",
  "instock": 20,
  "lavage_id": 2,
  "category_id": 1,
  "photos": ["image1.jpg", "image2.jpg"]
}
```
Réponse JSON:

```json
{
  "message": "Produit créé avec succès",
  "data": {
    "product": {
      "id": 2,
      "title": "Nouveau Produit",
      "description": "Description du Nouveau Produit",
      "original_price": 29.99,
      "image": "nom_de_l_image.jpg",
      "instock": 20,
      "user_id": 3,
      "status": "actif",
      "created_at": "2023-12-11T12:34:56Z",
      "updated_at": "2023-12-11T12:34:56Z"
    },
    "album": {
      "id": 2,
      "photos": "image1.jpg|image2.jpg",
      "product_id": 2,
      "lavage_id": 2,
      "created_at": "2023-12-11T12:34:56Z",
      "updated_at": "2023-12-11T12:34:56Z"
    }
  }
}

```

## <li>Édition d'un produit</li>

Obtenez les détails d'un produit spécifique pour édition en utilisant la méthode ``GET`` sur l'endpoint.

Endpoint:

```
/api/gerant/product/edit/{product_id}
```

Résultat:

```json
{
  "message": "Édition de Titre du Produit",
  "data": {
    "product": {
      "id": 1,
      "title": "Titre du Produit",
      "description": "Description du Produit",
      "original_price": 19.99,
      "image": "nom_de_l_image.jpg",
      "instock": 10,
      "user_id": 3,
      "status": "actif",
      "created_at": "2023-12-11T12:34:56Z",
      "updated_at": "2023-12-11T12:34:56Z"
    },
    "lavages": [
      // Tableau des lavages disponibles
    ],
    "categories": [
      // Tableau des catégories disponibles
    ],
    "lavagesAssocies": [
      // Tableau des lavages associés au produit
    ],
    "categoriesAssocies": [
      // Tableau des catégories associées au produit
    ]
  }
}

```

## <li>Mise à jour d'un produit</li>
Effectuez la mise à jour d'un produit en utilisant la méthode `PUT` sur l'endpoint.

**Endpoint:**
```
/api/gerant/product/update/{product_id}
```

**Paramètres de Requête:**
| Paramètre         | Type    | Description                 |
|-------------------|---------|-----------------------------|
| title             | string  | Nouveau titre du produit     |
| description       | string  | Nouvelle description du produit |
| original_price    | float   | Nouveau prix original du produit |
| image             | file    | Nouvelle image du produit    |
| instock           | int     | Nouveau stock disponible du produit |
| lavage_id         | int     | Nouvel ID du lavage associé  |
| category_id       | int     | Nouvel ID de la catégorie associée |

**Exemple de Corps de Requête JSON:**
```json
{
  "title": "Nouveau Titre",
  "description": "Nouvelle Description",
  "original_price": 39.99,
  "image": "nouvelle_image.jpg",
  "instock": 15,
  "lavage_id": 3,
  "category_id": 2
}

```

Réponse JSON:

```json
{
  "message": "Mise à jour effectuée avec succès",
  "data": {
    "id": 1,
    "title": "Nouveau Titre",
    "description": "Nouvelle Description",
    "original_price": 39.99,
    "image": "nouvelle_image.jpg",
    "instock": 15,
    "user_id": 3,
    "status": "actif",
    "created_at": "2023-12-11T12:34:56Z",
    "updated_at": "2023-12-11T12:34:56Z"
  }
}
```

## <li>Suppression d'un produit</li>

Supprimez un produit spécifique en utilisant la méthode DELETE sur l'endpoint.

**Endpoint:**
```
/api/gerant/product/delete/{product_id}
```
Réponse JSON:
```json
{
  "message": "Produit supprimé avec succès"
}
```
