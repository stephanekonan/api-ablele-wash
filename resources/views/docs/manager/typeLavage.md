# Documentation API - Gestion de type de lavage

## <li>Liste des types de lavages</li>

La méthode utilisée est ``GET``

**Enpoint:**
```
/api/gerant/typeslavage
```
Retourne la liste complète des types de lavage.

Paramètres: 

Soyez connecté comme gerant 

**Réponse:**
```json
{
  "message": "Mes types de lavages enregistrés",
  "data": [
    {
      "id": 1,
      "libelle": "Type de Lavage 1",
      "prix": 2000,
      "slug": "type-lavage-1",
      "user_id": 3,
      "created_at": "2023-01-01T12:00:00Z",
      "updated_at": "2023-01-01T12:00:00Z"
    },
    // Other types de lavage...
  ]
}
```

## <li>Créer un type de lavage</li>

La méthode utilisée est ``POST``

**Enpoint:**
```
/api/gerant/typelavage/store
```
Paramètres: 

Soyez connecté comme gerant 

|Paramètre	| Type	| Description|
|-----------|--------|---------------------|
|libelle |(string) | Libellé du type de lavage (au moins 5 caractères)| 
|prix |(numeric) |: Prix du type de lavage. |
|slug|(string) |Avaler tu tapes de lavage|

**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation et les données mises à jour :

```json
{
  "message": "Type de lavage ajouté avec succès",
  "data": {
    "id": 1,
    "libelle": "Nouveau Type de Lavage",
    "prix": 15.99,
    "slug": "nouveau-type-lavage",
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
    "libelle": ["Le libellé doit comporter au moins 5 caractères"],
    "prix": ["Le prix doit être numérique"]
  }
}
```


## <li>Supprimer un type de lavage</li>

La méthode utilisée est ``DELETE``

**Enpoint:**
```
/api/gerant/typelavage/delete/{id}
```
Paramètres: 

Soyez connecté comme gerant 


**Réponse:**

En cas de <b style="color: green">réussite</b>, la réponse contiendra un message de confirmation et les données mises à jour :

```json
{
  "message": "Type de lavage supprimé avec succès"
}
```

Si une <b style="color: red">erreur</b> se produit, le code de statut HTTP fournira plus de détails sur l'erreur :

```json
{
  "message": "Type introuvable"
}
```
