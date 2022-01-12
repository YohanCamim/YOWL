<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comments::where(['parent_id'=> null])->with('replies')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'news_id' => 'required'
            // parent_id à rajouter si sous commentaire
        ]);
        if($request['parent_id']){
            $comment = Comments::create([
                'content' => $request['content'],
                'author_id' => $request->user()->id,
                'news_id' => $request['news_id'],
                'parent_id' => $request['parent_id']
            ]);
        } else {
            $comment = Comments::create([
                'content' => $request['content'],
                'author_id' => $request->user()->id,
                'news_id' => $request['news_id']
            ]);
        }
       

        if ($comment) {
            return [
                'message' => 'Commentaire crée avec succés',
                'object' => $comment
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oneComments = Comments::where('id', 'like', $id)->with('replies')->get();
        return $oneComments;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comments $comments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $thisComments = Comments::where('id', 'like', $id)->get();
        if ($thisComments[0]['author_id'] == $request->user()->id) {
            if (Comments::where('id', 'like', $id)->delete()) {
                return response()->json([
                    'success' => 'Commentaire supprimé avec succés !'
                ], 200);
            };
        } else {
            return response()->json([
                'message' => 'Ce commentaire ne vous appartient pas'
            ]);
        }
    }

    public function getCommentsNews($id){
        $comments = Comments::where(['news_id'=>$id,'parent_id'=> null])->with('user')->with('replies')->get();
        return $comments;
    }
}
