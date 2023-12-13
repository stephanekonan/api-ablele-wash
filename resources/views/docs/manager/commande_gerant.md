# Documentation API - Gestion de commandes

## <li>Liste des commandes du gérant connecté</li> 


La méthode utilisée est ``GET``

**Enpoint**: 
```
/api/gerant/commandes
```

Retourne la liste de toutes les commandes.

**Paramètres Requis:**

Soyez connecté comme gerant 

**Réponse:**


```json
{
  "message": "Toutes mes commandes",
  "data": [
    {
      "id": 1,
      "status": "En cours",
      "employe_id": 2,
      "user_id": 123,
      "created_at": "2023-01-01T12:00:00Z",
      "updated_at": "2023-01-01T12:00:00Z"
    },
    // Other commandes...
  ]
}
```

## <li> Obtenez les détails d'une commande</li> 

La méthode utilisée est ``GET``

**Enpoint**: 
```
/api/gerant/commande/show/{id}
```

Retourne le détail de la commande.

**Paramètres Requis:**

Soyez connecté comme gerant
ID de la commande doit être ajouté en paramètre

**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation et les données mises à jour :

```json
{
  "message": "Détails de la commande 1",
  "data": {
    "id": 1,
    "status": "En cours",
    "employe_id": 2,
    "user_id": 123,
    "created_at": "2023-01-01T12:00:00Z",
    "updated_at": "2023-01-01T12:00:00Z"
  }
}
```
Si une <b style="color: red">erreur</b> se produit, le code de statut HTTP fournira plus de détails sur l'erreur :

```json
{
  "message": "Commande non trouvée"
}
```


## <li> Edition d'une commande</li> 

La méthode utilisée est ``GET``

**Enpoint**: 
```
/api/gerant/commande/edit/{id}
```

**Paramètres Requis:**

Soyez connecté comme gerant

L'ID de la commande à modifier doit être fourni en tant que paramètre dans l'URL.


**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation et les données mises à jour :

```json
{
  "message": "Edition de la commande 1",
  "data": {
    "commande": {
      "id": 1,
      "status": "En cours",
      "employe_id": 2,
      "user_id": 123,
      "created_at": "2023-01-01T12:00:00Z",
      "updated_at": "2023-01-01T12:00:00Z"
    },
    "employe": {
      // Employe details...
    },
    "employes": [
      {
        // Employe details...
      },
      // Other employes...
    ]
  }
}
```
Si une <b style="color: red">erreur</b> se produit, le code de statut HTTP fournira plus de détails sur l'erreur :

```json
{
  "message": "Vous n'avez pas les droits pour éditer cette commande"
}
```

## <li> Update d'une commande</li> 

La méthode utilisée est ``PUT``

**Enpoint**: 
```
/api/gerant/commande/update/{id}
```

|Paramètre	| Type	| Description|
|-----------|--------|---------------------|
|commande_id| (integer)| : ID de la commande à mettre à |
| status |(string) |: Nouveau statut de la commande. |
| employe_id |(integer) |: Nouvel ID de l'employé associé.|

**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation et les données mises à jour :

```json
{
  "message": "Edition de la commande 1",
  "data": {
    "id": 1,
    "status": "En cours",
    "employe_id": 2,
    "user_id": 123,
    "created_at": "2023-01-01T12:00:00Z",
    "updated_at": "2023-01-01T12:00:00Z"
  }
}
```

Si une <b style="color: red">erreur</b> se produit, le code de statut HTTP fournira plus de détails sur l'erreur :

```json
{
  "message": "La commande introuvable"
}
```

## <li> Suppression d'une commande</li> 

La méthode utilisée est ``DELETE``

**Enpoint**: 
```
/api/gerant/commande/delete/{id}
```
```json
{
  "message": "La commande supprimée"
}
```
