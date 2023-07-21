<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Newscomment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewscommentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "description"=>"required",
            "news_id" => "required"
        ]);

        $newscomment = new Newscomment();
        $newscomment->description = $request->description;
        $newscomment->news_id = $request->news_id;
        $newscomment->user_id = Auth::id();
        $newscomment->save();

        return response()->json(["message"=>"Newscomment Created"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $newscomment = Newscomment::find($id);
        return $newscomment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = User::find(Auth::id());
        $newscomment = Newscomment::find($id);

        if($newscomment->user_id !== Auth::id() || $user->role !== "admin"){
            return response()->json(["message"=>"Unauthorized"],403);
        }


        $request->validate([
            "description"=>"required"
        ]);


        $newscomment->description = $request->description;
        $newscomment->update();

        return response()->json(["message"=>"Newscomment Updated"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find(Auth::id());
        $newscomment = Newscomment::find($id);

        if($newscomment->user_id !== Auth::id() || $user->role !== "admin"){
            return response()->json(["message"=>"Unauthorized"],403);
        }


        $newscomment->delete();
        return response()->json(["message"=>"deleted"]);
    }
}
