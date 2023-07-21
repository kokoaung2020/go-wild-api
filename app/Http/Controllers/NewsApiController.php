<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
        return $news;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user = User::find(Auth::id());

        if($user->role !== "admin"){
            return response()->json(["message"=>"Unauthorized"],403);
        }

        $request->validate([
            "title" => "required|min:3",
            "description"=>"required|min:10",
            "newscategory_id" => "required"
        ]);

        $news = new News();
        $news->title = $request->title;
        $news->description = $request->description;
        $news->newscategory_id = $request->newscategory_id;
        $news->user_id = Auth::id();
        $news->save();

        return response()->json(["message"=>"News Created"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::find($id);
        return $news;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find(Auth::id());
        if($user->role !== "admin"){
            return response()->json(["message"=>"Unauthorized"],403);
        }

        $request->validate([
            "title"=>"nullable|min:3",
            "description"=>"nullable|min:10"
        ]);

        $news = News::find($id);

        if(is_null($news)){
            return response()->json(["message"=>"Page not found"],404);
        }

        if($request->has("title")){
            $news->title = $request->title;
        }

        if($request->has("description")){
            $news->description = $request->description;
        }

        if($request->has("newscategory_id")){
            $news->newscategory_id = $request->newscategory_id;
        }

        $news->update();

        return response()->json([
            "message"=>"updated"
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find(Auth::id());

        if($user->role !== "admin"){
            return response()->json(["message"=>"Unauthorized"],403);
        }


        $News = News::find($id);
        $News->delete();
        return response()->json(["message"=>"deleted"]);
    }
}
