<?php

namespace App\Http\Controllers;

use App\Models\Teamate;
use Illuminate\Http\Request;

class TeamateApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teamate = Teamate::all();
        return $teamate;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $teamate = new Teamate();
        $teamate->user_id = $request->id;
        $teamate->save();

        return response()->json(["message"=>"Added to teamate"]);
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
        $teamate = Teamate::find($id);
        $teamate->delete();
        return response()->json(["message"=>"deleted"]);
    }
}
