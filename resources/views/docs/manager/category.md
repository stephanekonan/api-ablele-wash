# Documentation API - Gestion des catégories
## <li>Liste des Catégories</li> 

La méthode utilisée est ``GET``

**Enpoint**: 
```
/api/gerant/categories
```

Retourne la liste de toutes les catégories.

**Paramètres Requis:**
Soyez connecté comme gerant 

**Réponse:**

```json
{
  "message": "Toutes mes catégories",
  "data": [
    {
      "id": 1,
      "libelle": "Nom de la catégorie",
      "slug": "nom-de-la-categorie",
      "user_id": 123,
      "created_at": "2023-01-01T12:00:00Z",
      "updated_at": "2023-01-01T12:00:00Z"
    },
    // Autres catégories...
  ]
}
```

## <li>Ajout d'une Catégorie </li>

La méthode utilisée est ``GET``

**Endpoint:**

```
/api/gerant/categorie/store
```

**Paramètres Requis:**

Soyez connecté comme gerant
|Paramètre	| Type	| Description|
|-----------|--------|---------------------|
|libelle |string | Libellé de la catégorie.|
|slug |string | Slug de la catégorie. |

**Réponse:**

```json
{
  "message": "Catégorie enregistrée avec succès",
  "data": {
    "id": 1,
    "libelle": "Nouvelle Catégorie",
    "slug": "nouvelle-categorie",
    "user_id": 123,
    "created_at": "2023-01-01T12:00:00Z",
    "updated_at": "2023-01-01T12:00:00Z"
  }
}
```

## <li>Mise à jour d'une Catégorie</li>

La méthode utilisée est ``PUT``

**Endpoint:**
```
/api/gerant/categorie/update/{id}
```
**Paramètres Requis:**

Soyez connecté comme gerant
|Paramètre	| Type	| Description|
|-----------|--------|---------------------|
|libelle |string | Libellé de la catégorie.|
|sllug |string | Slug de la catégorie. |

Le paramètre `id` correspond à l'identifiant de la catégorie que vous souhaitez modifier.

**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation et les données mises à jour :
```json
{
  "message": "Catégorie mise à jour avec succès",
  "data": {
    "id": 1,
    "libelle": "Nouveau Libellé",
    "slug": "nouveau-libelle",
    "user_id": 123,
    "created_at": "2023-01-01T12:00:00Z",
    "updated_at": "2023-01-02T12:30:00Z"
  }
}
```
Si une <b style="color: red">erreur</b> se produit, le code de statut HTTP fournira plus de détails sur l'erreur :

```json
{
  "message": "Catégorie non trouvée"
}
```

## <li>Suppression d'une Catégorie </li>

La méthode utilisée est ``DELETE``

**Endpoint:**
```
/api/gerant/categorie/update/{id}
```
**Paramètres Requis:**

Soyez connecté comme gerant

**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation et les données mises à jour :

```json
{
  "message": "Catégorie supprimée avec succès"
}
```
Si une <b style="color: red">erreur</b> se produit, le code de statut HTTP fournira plus de détails sur l'erreur.</s>

```json
{
  "message": "Catégorie introuvable"
}
```
