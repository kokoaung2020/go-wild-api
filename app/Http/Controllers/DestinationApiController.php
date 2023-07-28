<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\DestinationResource;

class DestinationApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destination = Destination::all();
        return DestinationResource::collection($destination);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            "name"=>"required",
            "photo"=>"required|file|mimes:png,jpeg,jpg|max:1024"
        ]);

        $destination = new Destination();
        $destination->name = $request->name;
        $destination->user_id = Auth::id();

        $newName = uniqid()."_destination.".$request->photo->extension();
        $request->photo->storeAs("public",$newName);

        $destination->photo = $newName;
        $destination->save();

        return response()->json([
            "message"=>"Created"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $destination = Destination::find($id);
        return new DestinationResource($destination);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "photo"=>"nullable|file|mimes:png,jpeg,jpg|max:1024"
        ]);

        $destination = Destination::find($id);

        if(is_null($destination)){
            return response()->json(["message"=>"Page Not Found"],404);
        }

        if($request->has("name")){
            $destination->name = $request->name;
        }

        if($request->has("photo")){

            $newName = uniqid()."_destination.".$request->photo->extension();
            Storage::delete("public/".$destination->photo);
            $request->photo->storeAs("public",$newName);

            $destination->photo = $newName;

        }

        $destination->update();

        return response()->json([
            "message"=>"updated",
            "destination"=>new DestinationResource($destination)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destination = Destination::find($id);
        Storage::delete("public/".$destination->photo);
        $destination->delete();
        return response()->json(["message"=>"deleted"]);
    }
}
