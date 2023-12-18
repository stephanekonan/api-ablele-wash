<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required',
            'lavage_id' => 'required',
        ], [
            'content.required' => 'Le champ contenu est requis.',
            'lavage_id.required' => 'Le champ lavage est requis.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user_id = auth()->user()->id;

        $comment = Comment::create([
            'user_id' => $user_id,
            'content' => $request->input('content'),
            'lavage_id' => $request->input('lavage_id'),
        ]);

        if (!$comment) {
            return response()->json([
                'message' => 'Une erreur s\'est produite'
            ]);
        }

        return response()->json([
            'message' => 'Commentaire enregistré avec succès',
            'data' => $comment
        ]);
    }

    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'contentreply' => 'required',
            'user_id' => 'required',
            'lavage_id' => 'required',
        ]);

        $commentReply = new Comment();
        $commentReply->content = $request->input('reply');
        $commentReply->user_id = $request->input('user_id');
        $commentReply->lavage_id = $request->input('lavage_id');

        $reply = $comment->replies()->save($commentReply);

        if (!$reply) {
            return response()->json([
                'message' => 'Une erreur s\'est produite'
            ]);
        }

        return response()->json([
            'message' => 'Reponse ajouté avec succès',
            'data' => $reply
        ]);
    }

    public function update(Request $request, $comment_id)
    {
        $comment = Comment::find($comment_id);

        if (!$comment) {
            return response()->json(['message' => 'Commentaire introuvable']);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ], [
            'content.required' => 'Le champ contenu est requis.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $comment->update($request->all());

        return response()->json(['message' => 'Commentaire modifié avec succès']);
    }

    public function destroy($comment_id)
    {
        $comment = Comment::find('comment_id', $comment_id);

        if (!$comment) {
            return response()->json(['message' => 'Commentaire introuvable']);
        }

        $comment->delete();

        return response()->json(['message' => 'Commentaire supprimé avec succès']);
    }
}
