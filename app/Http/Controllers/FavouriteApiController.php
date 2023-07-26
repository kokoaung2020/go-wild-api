<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favourite = Favourite::all();
        return $favourite;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Favourite::where("user_id",Auth::id())->where("featured_tour_id",$request->id)->first()){

            Favourite::find($request->id)->delete();
            return response()->json([
                "message" => "Remove From Favourite",
                "success" => true
            ]);

        }
        else{

            $favourite = new Favourite();
            $favourite->user_id = Auth::id();
            $favourite->featured_tour_id = $request->id;
            $favourite->save();

            return response()->json([
                "message" => "Added to Favourite",
                "success" => true
            ]);

        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
