<?php

namespace App\Http\Controllers;

use App\Models\News;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use shweshi\OpenGraph\OpenGraph;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return News::orderByDesc('created_at')->with('user')->with('comments')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       ;

        $request->validate([
            'url' => 'required'
        ]);
        $obj = new OpenGraph;
        $data = $obj->fetch($request['url']);
        $news = News::create([
            'title' => $data['title'],
            'content' => $data['description'],
            'url' => $data['url'],
            'imageUrl' => $data['image'],
            'author_id' => $request->user()->id,
            'category_id' => 2

        ]);
        if ($news) {
            return [
                'message' => 'Post crée avec succés',
                'object' => $news
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oneNews = News::where('id', 'like', $id)->with('user')->with('comments')->get();
        return $oneNews;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $thisNews = News::where('id', 'like', $id)->get();
        if ($thisNews[0]['author_id'] == $request->user()->id) {
            if (News::where('id', 'like', $id)->update($request->all())) {
                return response()->json([
                    'success' => 'Post modifié avec succés !'
                ], 200);
            };
        } else {
            return response()->json([
                'message' => 'Ce post ne vous appartient pas'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $thisNews = News::where('id', 'like', $id)->get();
        if ($thisNews[0]['author_id'] == $request->user()->id) {
            if (News::where('id', 'like', $id)->delete()) {
                return response()->json([
                    'success' => 'Post supprimé avec succés !'
                ], 200);
            };
        } else {
            return response()->json([
                'message' => 'Ce post ne vous appartient pas'
            ]);
        }
    }
    public function search($title)
    {
        $oneNews = News::where('title', 'like', '%' . $title . '%')
        ->orwhere('content', 'like', '%' . $title . '%')
        ->with('user')->with('comments')->get();
        return $oneNews;
    }

    public function getNewsAuthor($id) {
        $news = News::where('author_id','like',$id)->with('user')->with('comments')->get();
        return $news;
    }

    public function authorSearch($search, $id){
        $oneNews = News::where('author_id','like',$id)
        ->where('title', 'like', '%' . $search . '%')
        ->orwhere('content', 'like', '%' . $search . '%')
        ->where('author_id','like',$id)
        ->with('user')
        ->with('comments')
        ->get();
        return $oneNews;
    }
}
