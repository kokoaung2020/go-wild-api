<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CarouselApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carousels = Carousel::all();
        return $carousels;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::id());

        if($user->role === "admin"){

            $request->validate([
                "title"=>"required|min:3",
                "badge"=>"required|max:20",
                "description" => "required|min:5",
                "button"=>"required",
                "link"=>"required",
                "photo"=>"required|file|mimes:png,jpeg,jpg|max:1024"
            ]);

            $newName = uniqid()."_carousel.".$request->photo->extension();

            $request->photo->storeAs("public",$newName);


            $carousels = Carousel::create([
                "title"=>$request->title,
                "badge"=>$request->badge,
                "description"=>$request->description,
                "button"=>$request->button,
                "link"=>$request->link,
                "photo"=>$newName,
                "user_id"=>Auth::id()
            ]);


            return response()->json(["message"=>"Carousel Created"],200);
        }

        return response()->json(["message"=>"Unauthorized"],403);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carousel = Carousel::find($id);
        return $carousel;
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
            "badge"=>"nullable|max:20",
            "description" => "nullable|min:5",
            "button"=>"nullable",
            "link"=>"nullable",
            "photo"=>"nullable|file|mimes:png,jpeg,jpg|max:1024"
        ]);

        $carousel = Carousel::find($id);

        if(is_null($carousel)){
            return response()->json(["message"=>"Page not found"],404);
        }

        if($request->has("title")){
            $carousel->title = $request->title;
        }

        if($request->has("badge")){
            $carousel->badge = $request->badge;
        }

        if($request->has("description")){
            $carousel->description = $request->description;
        }

        if($request->has("button")){
            $carousel->button = $request->button;
        }

        if($request->has("link")){
            $carousel->link = $request->link;
        }

        if($request->file("photo")){

            $newName = uniqid()."_carousel.".$request->photo->extension();
            Storage::delete("public/".$destination->photo);
            $request->photo->store("storage/$newName");
            $carousel->photo = $newName;
        }

        $carousel->update();

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


        $carousel = Carousel::find($id);
        Storage::delete("public/".$carousel->photo);
        $carousel->delete();
        return response()->json(["message"=>"deleted"]);

    }
}
