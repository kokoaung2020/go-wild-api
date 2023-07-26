<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\FeaturedTours;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FeaturedToursApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $featuredTours = FeaturedTours::all();
        return $featuredTours;
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
            "address" => "required|min:5",
            "price"=>"required",
            "promotion"=>"nullable",
            "photo"=>"required|file|mimes:png,jpeg,jpg|max:1024"
        ]);

        $newName = uniqid()."_FeaturedTours.".$request->photo->extension();

        $request->photo->storeAs("public",$newName);

        $featuredTours = new FeaturedTours();
        $featuredTours->title = $request->title;
        $featuredTours->address = $request->address;
        $featuredTours->price = $request->price;
        $featuredTours->photo = $newName;
        $featuredTours->user_id = Auth::id();

        if($request->has("promotion")){
            $featuredTours->promotion = $request->promotion;
        }

        $featuredTours->save();

        return response()->json(["message"=>"FeaturedTours Created"],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $featuredTours = FeaturedTours::find($id);
        return $featuredTours;
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
            "address" => "nullable|min:5",
            "price"=>"nullable",
            "promotion"=>"nullable",
            "photo"=>"nullable|file|mimes:png,jpeg,jpg|max:1024"
        ]);

        $featuredTours = FeaturedTours::find($id);

        if(is_null($featuredTours)){
            return response()->json(["message"=>"Page not found"],404);
        }

        if($request->has("title")){
            $featuredTours->title = $request->title;
        }

        if($request->has("address")){
            $featuredTours->address = $request->address;
        }

        if($request->has("price")){
            $featuredTours->price = $request->price;
        }

        if($request->has("promotion")){
            $featuredTours->promotion = $request->promotion;
        }

        if($request->file("photo")){

            $newName = uniqid()."_FeaturedTours.".$request->photo->extension();
            $request->photo->storeAs("public",$newName);
            $featuredTours->photo = $newName;
        }

        $featuredTours->update();

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


        $featuredTours = FeaturedTours::find($id);
        Storage::delete("public/".$featuredTours->photo);
        $featuredTours->delete();
        return response()->json(["message"=>"deleted"]);
    }
}
