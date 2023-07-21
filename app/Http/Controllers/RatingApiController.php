<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rating = Rating::all();
        return $rating;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "rating" => "required"
        ]);

        $rating = new Rating();
        $rating->rating = $request->rating;
        $rating->user_id = Auth::id();
        $rating->featured_tours_id = $request->id;
        $rating->save();

        return response()->json(["message"=>"Rating Added"],200);
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
        $rateId = Rating::find(Auth::id());

        if(Auth::id() === $rateId->user_id){

            $request->validate([
                "rating" => "required"
            ]);

            $rating = Rating::find($id);

            $rating->rating = $request->rating;
            $rating->featured_tours_id = $request->id;
            $rating->update();

            return response()->json(["message"=>"Rating Added"],200);

        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rating = Rating::find($id);
        $rating->delete();
        return response()->json(["message"=>"deleted"]);
    }
}
