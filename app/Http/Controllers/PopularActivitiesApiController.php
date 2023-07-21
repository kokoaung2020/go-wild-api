<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PopularActivities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PopularActivitiesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $popularActivities = PopularActivities::all();

        return $popularActivities;
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
            "title"=>"required|min:3",
            "description" => "required|min:5",
            "link"=>"required",
            "photo"=>"required|file|mimes:png,jpeg,jpg|max:1024"
        ]);

        $newName = uniqid()."_popular-activities.".$request->photo->extension();

        $request->photo->storeAs("public",$newName);

        $popularActivities = PopularActivities::create([
            "title" => $request->title,
            "description" => $request->description,
            "link" => $request->link,
            "photo" => $newName,
            "user_id" => Auth::id()
        ]);

        return response()->json(["message"=>"Created"],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carousel = PopularActivities::find($id);
        return $carousel;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->json(["message"=>"hello"]);
        $user = User::find(Auth::id());

        if($user->role !== "admin"){
            return response()->json(["message"=>"Unauthorized"],403);
        }

        $request->validate([
            "title"=>"nullable|min:3",
            "description" => "nullable|min:5",
            "link"=>"nullable",
            "photo"=>"nullable|file|mimes:png,jpeg,jpg|max:1024"
        ]);

        $popularActivities = PopularActivities::find($id);

        if(is_null($popularActivities)){
            return response()->json(["message"=>"Page not found"],404);
        }

        if($request->has("title")){
            $popularActivities->title = $request->title;
        }

        if($request->has("description")){
            $popularActivities->description = $request->description;
        }

        if($request->has("link")){
            $popularActivities->link = $request->link;
        }

        if($request->file("photo")){

            $newName = uniqid()."_carousel.".$request->photo->extension();
            $request->photo->store("storage/$newName");
            Storage::delete("public/".$destination->photo);
            $popularActivities->photo = $newName;
        }

        $popularActivities->update();

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


        $popularActivities = PopularActivities::find($id);
        Storage::delete("public/".$popularActivities->photo);
        $popularActivities->delete();
        return response()->json(["message"=>"deleted"]);

    }
}
