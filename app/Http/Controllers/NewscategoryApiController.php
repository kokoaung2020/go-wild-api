<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Newscategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewscategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Newscategory::all();
        return $category;
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
            "title" => "required"
        ]);

        $category = new Newscategory();
        $category->title = $request->title;
        $category->user_id = Auth::id();
        $category->save();

        return response()->json(["message"=>"Category Created"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
            "title" => "required"
        ]);

        $category = Newscategory::find($id);
        $category->title = $request->title;
        $category->update();

        return response()->json(["message"=>"Category Updated"],200);
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

        $category = Newscategory::find($id);
        $category->delete();

        return response()->json(["message"=>"Category Deleted"],200);
    }
}
