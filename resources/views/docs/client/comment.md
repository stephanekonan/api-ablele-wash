# Documentation API - Gestion de Commentaire
## Méthode store pour commentaires

## <span style="color:red">Méthode utilisée: `post`</span>

## <span style="color:green">Enpoint: ``/client/comment/store``</span>

La fonction `store` est utilisée pour enregistrer un nouveau commentaire dans le système.

## Paramètres

La méthode accepte les paramètres suivants via la requête HTTP:

- `content` (obligatoire): Le contenu du commentaire.
- `user_id` (obligatoire): L'ID de l'utilisateur qui fait le commentaire.
- `lavage_id` (obligatoire): L'ID du lavage auquel le commentaire est associé.

## Validation

Avant d'enregistrer le commentaire, la méthode effectue une validation sur les paramètres suivants:

- `content`: Obligatoire, le contenu du commentaire ne peut pas être vide.
- `user_id`: Obligatoire, l'ID de l'utilisateur doit être fourni.
- `lavage_id`: Obligatoire, l'ID du lavage doit être fourni.

Si la validation échoue, la méthode renvoie une réponse JSON indiquant les erreurs de validation.

## Création du Commentaire

Après la validation réussie, un nouveau commentaire est créé en utilisant les données fournies. Les champs suivants sont utilisés pour créer le commentaire:

- `user_id`: L'ID de l'utilisateur actuellement authentifié.
- `content`: Le contenu du commentaire fourni dans la requête.
- `lavage_id`: L'ID du lavage fourni dans la requête.

Si la création du commentaire échoue, la méthode renvoie une réponse JSON indiquant une erreur.

## Réponse JSON

Si la validation et la création du commentaire réussissent, la méthode renvoie une réponse JSON avec les informations suivantes:

- `message`: Message indiquant que le commentaire a été enregistré avec succès.
- `data`: Les données du commentaire nouvellement créé.

Si la création du commentaire échoue, la méthode renvoie une réponse JSON avec un message indiquant qu'une erreur s'est produite.

Exemple de réponse réussie:

```json
{
    "message": "Commentaire enregistré avec succès",
    "data": {
        "user_id": 1,
        "content": "C'est un excellent lavage!",
        "lavage_id": 123,
        "created_at": "2023-01-01T12:00:00Z",
        "updated_at": "2023-01-01T12:00:00Z",
        "id": 456
    }
}
```

Exemple de réponse échouée:

```json
{
    "message": "Une erreur s'est produite"
}
```

# Méthode Reply pour Commentaires

## <span style="color:red">Méthode utilisée: `post`</span>

## <span style="color:green">Enpoint: ``/client/comment/reply/{comment}``</span>

La méthode `reply` est utilisée pour ajouter une réponse à un commentaire existant.

## Paramètres

La méthode accepte les paramètres suivants via la requête HTTP:

- `contentreply` (obligatoire): Le contenu de la réponse au commentaire.
- `user_id` (obligatoire): L'ID de l'utilisateur qui fait la réponse.
- `lavage_id` (obligatoire): L'ID du lavage auquel la réponse est associée.

## Validation

Avant d'ajouter la réponse, la méthode effectue une validation sur les paramètres suivants:

- `contentreply`: Obligatoire, le contenu de la réponse ne peut pas être vide.
- `user_id`: Obligatoire, l'ID de l'utilisateur doit être fourni.
- `lavage_id`: Obligatoire, l'ID du lavage doit être fourni.

Si la validation échoue, la méthode renvoie une réponse JSON indiquant les erreurs de validation.

## Création de la Réponse

Après la validation réussie, une nouvelle réponse est créée en utilisant les données fournies. Les champs suivants sont utilisés pour créer la réponse:

- `contentreply`: Le contenu de la réponse fourni dans la requête.
- `user_id`: L'ID de l'utilisateur fourni dans la requête.
- `lavage_id`: L'ID du lavage fourni dans la requête.

La réponse est ensuite associée au commentaire spécifié.

Si la création de la réponse échoue, la méthode renvoie une réponse JSON indiquant une erreur.

## Réponse JSON

Si la validation et la création de la réponse réussissent, la méthode renvoie une réponse JSON avec les informations suivantes:

- `message`: Message indiquant que la réponse a été ajoutée avec succès.
- `data`: Les données de la réponse nouvellement créée.

Si la création de la réponse échoue, la méthode renvoie une réponse JSON avec un message indiquant qu'une erreur s'est produite.

Exemple de réponse réussie:

```json
{
    "message": "Reponse ajoutée avec succès",
    "data": {
        "user_id": 1,
        "content": "Merci pour votre commentaire!",
        "lavage_id": 123,
        "created_at": "2023-01-01T12:00:00Z",
        "updated_at": "2023-01-01T12:00:00Z",
        "id": 789
    }
}
```
 
Exemple de réponse échouée:

```json
{
    "message": "Une erreur s'est produite"
}
```

# Méthode Update pour Commentaires

## <span style="color:red">Méthode utilisée: `put`</span>

## <span style="color:green">Enpoint: ``/client/comment/update/{id}``</span>

La méthode `update` est utilisée pour modifier le contenu d'un commentaire existant.

## Paramètres

La méthode accepte les paramètres suivants via la requête HTTP:

- `content` (obligatoire): Le nouveau contenu du commentaire.

## Recherche du Commentaire

La méthode recherche le commentaire spécifié par l'ID (`comment_id`) dans la base de données.

## Validation

Avant de mettre à jour le commentaire, la méthode effectue une validation sur les paramètres suivants:

- `content`: Obligatoire, le nouveau contenu du commentaire ne peut pas être vide.

Si la validation échoue, la méthode renvoie une réponse JSON indiquant les erreurs de validation.

## Mise à Jour du Commentaire

Si le commentaire est trouvé et que la validation réussit, la méthode met à jour le contenu du commentaire avec les nouvelles données fournies.

Si le commentaire spécifié par l'ID n'est pas trouvé, la méthode renvoie une réponse JSON indiquant que le commentaire est introuvable.

## Réponse JSON

Si la validation et la mise à jour réussissent, la méthode renvoie une réponse JSON avec un message indiquant que le commentaire a été modifié avec succès.

Si le commentaire est introuvable, la méthode renvoie une réponse JSON indiquant que le commentaire est introuvable.

Exemple de réponse réussie:

```json
{
    "message": "Commentaire modifié avec succès"
}

```

# Méthode Destroy pour Commentaires

## <span style="color:red">Méthode utilisée: `delete`</span>

## <span style="color:green">Enpoint: ``/client/comment/destroy/{id}``</span>

La méthode `destroy` est utilisée pour supprimer un commentaire existant.

## Paramètres

La méthode accepte les paramètres suivants via la requête HTTP:

- `comment_id` (obligatoire): L'ID du commentaire à supprimer.

## Recherche du Commentaire

La méthode recherche le commentaire spécifié par l'ID (`comment_id`) dans la base de données.

## Suppression du Commentaire

Si le commentaire est trouvé, la méthode le supprime de la base de données.

Si le commentaire spécifié par l'ID n'est pas trouvé, la méthode renvoie une réponse JSON indiquant que le commentaire est introuvable.

## Réponse JSON

Si le commentaire est trouvé et supprimé avec succès, la méthode renvoie une réponse JSON avec un message indiquant que le commentaire a été supprimé avec succès.

Si le commentaire est introuvable, la méthode renvoie une réponse JSON indiquant que le commentaire est introuvable.

Exemple de réponse réussie:

```json
{
    "message": "Commentaire supprimé avec succès"
}
```
