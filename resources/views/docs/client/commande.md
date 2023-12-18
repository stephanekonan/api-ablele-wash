# Documentation API pour Commande 

## <li>Liste de toutes les commandes</li> 

**Endpoint:**

La méthode utilisée est ``GET``

**Enpoint**: 
```
/api/client/commandes
```
Retourne la liste de toutes les commandes.

**Paramètres Requis:**

Soyez connecté comme client 

**Réponse:**

```json
{
  "message": "Liste des commandes",
  "data": {
    "id": 1,
    "product_id": 123,
    "vehicule_id": 456,
    "lavage_id": 789,
    "type_lavage_id": 101,
    "status": "En cours",
    "employe_id": 102,
    "user_id": 123,
    "created_at": "2023-01-01T12:00:00Z",
    "updated_at": "2023-01-01T12:00:00Z"
  },
  // Other commandes...
}
```
---

## <li>Obtenez les détails d'une commande</li> 

**Endpoint:**

La méthode utilisée est ``GET``

**Enpoint**: 
```
/api/client/commande/show/{id}
```
**Paramètres Requis:**

Soyez connecté comme client

``id`` (integer) : ID de la commande.

**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation:

```json
{
  "message": "Détails de la commande",
  "data": {
    "id": 1,
    "product_id": 123,
    "vehicule_id": 456,
    "lavage_id": 789,
    "type_lavage_id": 101,
    "status": "En cours",
    "employe_id": 102,
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

---

## <li>Edition des données d'une commande</li> 

**Endpoint:**

La méthode utilisée est ``GET``

**Enpoint**: 
```
/api/client/commande/edit/{id}
```
**Paramètres Requis:**

Soyez connecté comme client

``id`` (integer) : ID de la commande.

**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation:

```json
{
  "message": "Edition de la commande",
  "data": {
    "id": 1,
    "product_id": 123,
    "vehicule_id": 456,
    "lavage_id": 789,
    "type_lavage_id": 101,
    "status": "En cours",
    "employe_id": 102,
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
---

## <li>Création d'une nouvelle commande</li> 
A la création de la commande, point de d=fidélité de l'utilisateur sincremnente (user->point_fidelity +1)
**Endpoint:**

La méthode utilisée est ``POST``

**Enpoint**: 
```
/api/client/commande/store/{id}
```
**Paramètres Requis:**

Soyez connecté comme client
|Paramètre	| Type	| Description|
|-----------|--------|---------------------|
|``id`` |integer|  ID de la commande à mettre à jour.|
|``product_id`` |integer|  Nouvel ID du produit associé. (il peut être null)|
|``vehicule_id``| integer|  Nouvel ID du véhicule associé.|
|``lavage_id`` |integer | Nouvel ID du lavage associé.|
|``type_lavage_id`` |integer | Nouvel ID du type de lavage associé.|
|``status``| string | Nouveau statut de la commande.|
|``employe_id`` |integer|  Nouvel ID de l'employé associé.|


**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation:

```json
{
  "message": "Commande créée avec succès",
  "data": {
    "id": 2,
    "product_id": 124,
    "vehicule_id": 457,
    "lavage_id": 790,
    "type_lavage_id": 102,
    "status": "En attente",
    "employe_id": 103,
    "user_id": 123,
    "created_at": "2023-01-02T10:30:00Z",
    "updated_at": "2023-01-02T10:30:00Z"
  }
}
```
Si une <b style="color: red">erreur</b> se produit, le code de statut HTTP fournira plus de détails sur l'erreur :

```json
{
  "message": "La validation a échoué",
  "errors": {
    "product_id": ["Le champ produit est requis"],
    // Other validation errors...
  }
}
```
---

## <li>Update d'une commande</li> 

**Endpoint:**

La méthode utilisée est ``PUT``

**Enpoint**: 
```
/api/client/commande/update/{id}
```
**Paramètres Requis:**

Soyez connecté comme client
|Paramètre	| Type	| Description|
|-----------|--------|---------------------|
|``id`` |integer|  ID de la commande à mettre à jour.|
|``product_id`` |integer|  Nouvel ID du produit associé. (il peut être null)|
|``vehicule_id``| integer|  Nouvel ID du véhicule associé.|
|``lavage_id`` |integer | Nouvel ID du lavage associé.|
|``type_lavage_id`` |integer | Nouvel ID du type de lavage associé.|
|``status``| string | Nouveau statut de la commande.|
|``employe_id`` |integer|  Nouvel ID de l'employé associé.|


**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation:

```json
{
  "message": "Commande mise à jour avec succès",
  "data": {
    "id": 1,
    "product_id": 125,
    "vehicule_id": 458,
    "lavage_id": 791,
    "type_lavage_id": 103,
    "status": "Terminé",
    "employe_id": 104,
    "user_id": 123,
    "created_at": "2023-01-01T12:00:00Z",
    "updated_at": "2023-01-03T11:45:00Z"
  }
}
```
Si une <b style="color: red">erreur</b> se produit, le code de statut HTTP fournira plus de détails sur l'erreur :

```json
{
  "message": "Commande non trouvée"
}
```


## <li>Suppression d'une commande</li> 

**Endpoint:**

La méthode utilisée est ``DELETE``

**Enpoint**: 
```
/api/client/commande/delete/{id}
```
**Paramètres Requis:**

Soyez connecté comme client

Parameters:
|Paramètre	| Type	| Description|
|-----------|--------|---------------------|
|``id``| integer |ID de la commande à supprimer.|

**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation:

```json
{
  "message": "Commande supprimée avec succès"
}
```
Si une <b style="color: red">erreur</b> se produit, le code de statut HTTP fournira plus de détails sur l'erreur :
```json
{
  "message": "Commande non trouvée"
}
```
