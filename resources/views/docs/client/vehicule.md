# Documentation API - Gestion de véhicule

## <li>Liste des véhicules </li>

La méthode utilisée est ``GET``

**Enpoint**: 
```
/api/client/vehicules
```
Retourne la liste de toutes les véhicules.

**Paramètres Requis:**

Soyez connecté comme client 

**Réponse:**


```json
{
  "message": "Liste de mes véhicules",
  "data": [
    {
      "id": 1,
      "immatriculation": "ABC 123",
      "type": "Sedan",
      "phone_driver": "123456789",
      "driver_name": "John Doe",
      "driver_email": "john@example.com",
      "commune": "Any Commune",
      "user_id": 123,
      "created_at": "2023-01-01T12:00:00Z",
      "updated_at": "2023-01-01T12:00:00Z"
    },
    // Other vehicules...
  ]
}
```
---

## <li>Ajouter un véhicule</li>

La méthode utilisée est ``POST``

**Enpoint**: 
```
/api/client/vehicule/store
```

Permet d'ajouter une voiture à votre compte. Vous pouvez envoyer l'ensemble des informations d'un véhicule ou uniquement celles que vous souhaitez modifier.

**Paramètres Requis :**

|Paramètre	| Type	| Description|
|-----------|--------|---------------------|
|`immatriculation` | String   | La immatriculation du véhicule (exemple : ABC 123)                     |
|`type`           | String   | Le type du véhicule (exemple : Sedan ou SUV).                |
|`phone_driver`    | Integer  | Le numéro de téléphone du conducteur.               |
|`driver_name`    | String   | Le nom du conducteur.                         |
|`driver_email`   | String   | L'adresse email du conducteur.              |
|`commune`        | String   | La commune où se trouve le véhicule.            |

**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation:

```json
Une réponse correcte devrait être une réponse au format JSON avec le status code HTTP 201 et les données suivantes :

{
  "message": "Véhicule enregistré avec succès",
  "data": {
    "id": 1,
    "immatriculation": "XYZ 789",
    "type": "SUV",
    "phone_driver": "987654321",
    "driver_name": "Jane Doe",
    "driver_email": "jane@example.com",
    "commune": "Another Commune",
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
    "immatriculation": ["Le numéro d'immatriculation est requis"],
    // Other validation errors...
  }
}
```
---


## <li>Détails d'un véhicule</li>

La méthode utilisée est ``GET``

**Enpoint**: 
```
/api/client/vehicule/store
```
Parameters:

    id (integer) : ID du véhicule.

**Response:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation:

Si l'appel est une réussite, le statut HTTP sera `HTTP 200 OK` et la réponse contiendra les informations du véhicule demandé :

```json
{
  "message": "Les données de XYZ 789",
  "data": {
    "id": 1,
    "immatriculation": "XYZ 789",
    "type": "SUV",
    "phone_driver": "987654321",
    "driver_name": "Jane Doe",
    "driver_email": "jane@example.com",
    "commune": "Another Commune",
    "user_id": 123,
    "created_at": "2023-01-02T10:30:00Z",
    "updated_at": "2023-01-02T10:30:00Z"
  }
}
```
Si une <b style="color: red">erreur</b> se produit, le code de statut HTTP fournira plus de détails sur l'erreur :

```json
{
  "message": "Véhicule non trouvé"
}
```
---

