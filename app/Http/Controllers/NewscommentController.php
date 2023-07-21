<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewscommentRequest;
use App\Http\Requests\UpdateNewscommentRequest;
use App\Models\Newscomment;

class NewscommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewscommentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Newscomment $newscomment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Newscomment $newscomment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewscommentRequest $request, Newscomment $newscomment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Newscomment $newscomment)
    {
        //
    }
}
