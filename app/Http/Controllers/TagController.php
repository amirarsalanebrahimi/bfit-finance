<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Exception;

class TagController extends Controller
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:tags,name|max:255',
            'color' => 'required|hex_color'
        ]);

        Tag::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $category)
    {
        //
    }
}
