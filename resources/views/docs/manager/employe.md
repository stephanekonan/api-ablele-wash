# Documentation de l'API - Gestion des Employés

## <li>Liste de tous les employés du gérant connecté</li>

Obtenez la liste de tous les employés en utilisant la méthode `GET` sur l'endpoint.

**Endpoint:**

```
/api/gerant/employes
```

**Réponse JSON:**
```json
{
  "message": "Liste de mes employés",
  "data": {
    "employes": [
      {
        // Données d'un employé
      },
    ],
  }
}
```
## <li>Ajout d'un nouvel employé</li>

Ajoutez un nouvel employé en utilisant la méthode ``POST`` sur l'endpoint.

**Endpoint:**
```
/api/gerant/employe/store
```
|Paramètre	|Type	|Description|
|-----------|--------|---------------------|
|employe_name|	string|	Nom de l'employé|
|employe_phone|	string|	Numéro de téléphone de l'employé|
|employe_cni	|string|	Numéro CNI de l'employé|
|lavage_id	|int	|Identifiant du lavage associé|
|password	|string|	Mot de passe de l'employé|

**Réponse JSON:**
```json
{
  "message": "{employe_name} ajouté avec succès",
  "data": {
    // Données de l'employé nouvellement ajouté
  }
}

```
## <li>Edition d'un employé</li>

Modifiez les données d'un employé en utilisant la méthode ``GET`` sur l'endpoint.

**Endpoint:**
```
/api/gerant/employe/edit/{id}
```
Paramètre de Requête:
|Paramètre	|Type	|Description|
|-----------|--------|---------------------|
|id	|string|	Identifiant crypté de l'employé|

**Réponse JSON:**

```json
{
  "message": "Modification des données de {employe_name}",
  "data": {
    "employe": {
      // Données de l'employé
    },
    "lavages": [
      // Liste des lavages associés à l'utilisateur connecté
      // Chaque élément du tableau pourrait ressembler à {"id": 1, "lavage_name": "Nom du Lavage", ...}
    ]
  }
}
```

## <li>Mise à jour des données d'un employé</li>

Effectuez la mise à jour des données d'un employé en utilisant la méthode ``PUT`` sur l'endpoint.

**Endpoint:**
```
/api/gerant/employe/update/{id}
```
Paramètres de Requête:

|Paramètre|	Type|	Description|
|-----------|--------|---------------------|
|employe_name	|string	|Nouveau nom de l'employé|
|employe_phone	|string|	Nouveau numéro de téléphone|
|employe_cni	|string	|Nouveau numéro CNI|
|lavage_id|	int|	Nouvel identifiant du lavage|

Exemple de Corps de Requête JSON:
```json
{
  "employe_name": "Nouveau Nom",
  "employe_phone": "Nouveau Numéro",
  "employe_cni": "Nouveau CNI",
  "lavage_id": 2
}
```

Réponse JSON:
```json
{
  "message": "Mise à jour effectuée avec succès",
  "data": {
    "employe": {
      // Données de l'employé après la mise à jour
    }
  }
}
```
## <li>Suppression d'un employé</li>

Supprimez un employé spécifique en utilisant la méthode DELETE sur l'endpoint.

**Endpoint:**
```
/api/gerant/employe/delete/{id}
```
Réponse JSON
```json
{
  "message": "Employé supprimé avec succès"
}
```
