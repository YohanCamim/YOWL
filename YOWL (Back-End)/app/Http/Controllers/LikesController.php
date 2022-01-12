<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Likes;
use App\Models\Comments;
use Illuminate\Http\Request;
use App\Models\LikesComments;
use Illuminate\Support\Facades\DB;

class LikesController extends Controller
{

    public function likeNews(Request $request, $id)
    {
        $request->validate([
            'type' => 'required'
        ]);

        if (Likes::where(['news_id' => $id, 'author_id' => $request->user()->id])->exists()) {
            $thisLike =  Likes::where(['news_id' => $id, 'author_id' => $request->user()->id])->get();
            if ($request['type'] != $thisLike[0]['type']) {
                if ($request['type'] == 1) {
                    $oneNews = News::where('id', 'like', $id)->get();
                    $nbDown = $oneNews[0]['ratingDown'];
                    $nbUp = $oneNews[0]['ratingUp'];
                    News::where('id', 'like', $id)->update([
                        'ratingDown' => $nbDown - 1,
                        'ratingUp' => $nbUp + 1
                    ]);
                    Likes::where(['news_id' => $id, 'author_id' => $request->user()->id])->update([
                        'type' => 1
                    ]);
                    return [
                        'message' => 'Ce post à été disliké mais il vient detre liké !'
                    ];
                } else {
                    $oneNews = News::where('id', 'like', $id)->get();
                    $nbDown = $oneNews[0]['ratingDown'];
                    $nbUp = $oneNews[0]['ratingUp'];
                    News::where('id', 'like', $id)->update([
                        'ratingDown' => $nbDown + 1,
                        'ratingUp' => $nbUp - 1
                    ]);
                    Likes::where(['news_id' => $id, 'author_id' => $request->user()->id])->update([
                        'type' => 0
                    ]);
                    return [
                        'message' => 'Ce post à été liké mais il vient detre disliké !'
                    ];
                }
            } else {
                if ($thisLike[0]['type'] == 1) {
                    $oneNews = News::where('id', 'like', $id)->get();
                    $nbUp = $oneNews[0]['ratingUp'];

                    News::where('id', 'like', $id)->update([
                        'ratingUp' => $nbUp - 1
                    ]);
                    Likes::where(['news_id' => $id, 'author_id' => $request->user()->id])->delete();
                return [
                    'message' => 'Ce post été liké et le like à été supprimé !'
                ];
                } else {
                    $oneNews = News::where('id', 'like', $id)->get();
                    $nbDown = $oneNews[0]['ratingDown'];

                    News::where('id', 'like', $id)->update([
                        'ratingDown' => $nbDown - 1
                    ]);
                    Likes::where(['news_id' => $id, 'author_id' => $request->user()->id])->delete();
                return [
                    'message' => 'Ce post été disliké et le dislike à été supprimé !'
                ];
                }
            }
        } else {
            if ($request['type'] == '1') {
                $oneNews = News::where('id', 'like', $id)->get();
                $nbUp = $oneNews[0]['ratingUp'];
                News::where('id', 'like', $id)->update([
                    'ratingUp' => $nbUp + 1
                ]);
                Likes::create([
                    'news_id' => $id,
                    'author_id' => $request->user()->id,
                    'type' => 1
                ]);
                return [
                    'message' => 'Ce post à été liké !'
                ];
            } else {
                $oneNews = News::where('id', 'like', $id)->get();
                $nbDown = $oneNews[0]['ratingDown'];
                News::where('id', 'like', $id)->update([
                    'ratingDown' => $nbDown + 1
                ]);
                Likes::create([
                    'news_id' => $id,
                    'author_id' => $request->user()->id,
                    'type' => 0
                ]);
                return [
                    'message' => 'Ce post à été disliké !'
                ];
            }
        }
    }

    public function likeComments(Request $request, $id)
    {
        $request->validate([
            'type' => 'required'
        ]);

        if (LikesComments::where(['comments_id' => $id, 'author_id' => $request->user()->id])->exists()) {
            $thisLike =  LikesComments::where(['comments_id' => $id, 'author_id' => $request->user()->id])->get();
            if ($request['type'] != $thisLike[0]['type']) {
                if ($request['type'] == 1) {
                    $oneComments = Comments::where('id', 'like', $id)->get();
                    $nb = $oneComments[0]['rating'];
                    Comments::where('id', 'like', $id)->update([
                        'rating' => $nb + 2
                    ]);
                    LikesComments::where(['comments_id' => $id, 'author_id' => $request->user()->id])->update([
                        'type' => 1
                    ]);
                    return [
                        'message' => 'Ce commentaire à été disliké mais il vient detre liké !'
                    ];
                } else {
                    $oneComments = Comments::where('id', 'like', $id)->get();
                    $nb = $oneComments[0]['rating'];
                    Comments::where('id', 'like', $id)->update([
                        'rating' => $nb - 2
                    ]);
                    LikesComments::where(['comments_id' => $id, 'author_id' => $request->user()->id])->update([
                        'type' => 0
                    ]);
                    return [
                        'message' => 'Ce commentaire à été liké mais il vient detre disliké !'
                    ];
                }
            } else {
                if ($thisLike[0]['type'] == 1) {
                    $onecomments = Comments::where('id', 'like', $id)->get();
                    $nb = $onecomments[0]['rating'];

                    Comments::where('id', 'like', $id)->update([
                        'rating' => $nb - 1
                    ]);
                    LikesComments::where(['comments_id' => $id, 'author_id' => $request->user()->id])->delete();
                return [
                    'message' => 'Ce commentaire été liké et le like à été supprimé !'
                ];
                } else {
                    $onecomments = Comments::where('id', 'like', $id)->get();
                    $nb = $onecomments[0]['rating'];

                    Comments::where('id', 'like', $id)->update([
                        'rating' => $nb + 1
                    ]);
                    LikesComments::where(['comments_id' => $id, 'author_id' => $request->user()->id])->delete();
                return [
                    'message' => 'Ce commentaire été disliké et le dislike à été supprimé !'
                ];
                }
            }
        } else {
            if ($request['type'] == '1') {
                $oneComments = Comments::where('id', 'like', $id)->get();
                $nb = $oneComments[0]['rating'];
                Comments::where('id', 'like', $id)->update([
                    'rating' => $nb + 1
                ]);
                LikesComments::create([
                    'comments_id' => $id,
                    'author_id' => $request->user()->id,
                    'type' => 1
                ]);
                return [
                    'message' => 'Ce commentaire à été liké !'
                ];
            } else {
                $oneComments = Comments::where('id', 'like', $id)->get();
                $nb = $oneComments[0]['ratingDown'];
                Comments::where('id', 'like', $id)->update([
                    'rating' => $nb - 1
                ]);
                LikesComments::create([
                    'comments_id' => $id,
                    'author_id' => $request->user()->id,
                    'type' => 0
                ]);
                return [
                    'message' => 'Ce commentaire à été disliké !'
                ];
            }
        }
    }


    public function isLiked(Request $request,$id){
        if(Likes::where(['news_id' => $id, 'author_id' => $request->user()->id])->exists())
        {
            $thisLike =  Likes::where(['news_id' => $id, 'author_id' => $request->user()->id])->get();
            return [
                'object' => $thisLike[0]['type']
            ];
        }else {
            return [];
        }
        
    }

    public function articleLiked(Request $request) {
        return Likes::where('author_id', 'like' , $request->user()->id)->get();
    }

    public function articlesLiked(Request $request){
        return DB::table('news')
        ->join('likes as likes1','likes1.news_id','=','news.id')
        ->select('news.*')
        ->where('news.author_id','=',$request->user()->id)
        ->where('likes1.type','=','1')
        ->get();
    }

    public function articlesDisliked(Request $request){
        return DB::table('news')
        ->join('likes as likes1','likes1.news_id','=','news.id')
        ->select('news.*')
        ->where('news.author_id','=',$request->user()->id)
        ->where('likes1.type','=','0')
        ->get();
    }
}
