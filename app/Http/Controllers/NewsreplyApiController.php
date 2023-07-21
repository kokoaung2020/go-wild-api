<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Newsreply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsreplyApiController extends Controller
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
            "description"=>"required"
        ]);

        $newsreply = new Newsreply();
        $newsreply->description = $request->description;
        $newsreply->newscomment_id = $request->id;
        $newsreply->user_id = Auth::id();
        $newsreply->save();

        return response()->json(["message"=>"Newsreply Created"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $newsreply = Newsreply::find($id);
        return $newsreply;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find(Auth::id());
        $newsreply = Newsreply::find($id);

        if($newsreply->user_id !== Auth::id() || $user->role !== "admin"){
            return response()->json(["message"=>"Unauthorized"],403);
        }


        $request->validate([
            "description"=>"required"
        ]);


        $newsreply->description = $request->description;
        $newsreply->update();

        return response()->json(["message"=>"Newsreply Updated"],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find(Auth::id());
        $newsreply = Newsreply::find($id);

        if($newsreply->user_id !== Auth::id() || $user->role !== "admin"){
            return response()->json(["message"=>"Unauthorized"],403);
        }


        $newsreply->delete();
        return response()->json(["message"=>"deleted"]);
    }
}
