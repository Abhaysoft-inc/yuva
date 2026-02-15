<?php

namespace App\Http\Controllers;

use App\Models\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directors = Director::orderBy('order')->get();
        return view('directors.index', compact('directors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('directors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'required|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('directors', 'public');
            $validated['photo_path'] = $photoPath;
        }

        $validated['is_active'] = $request->has('is_active');

        Director::create($validated);

        return redirect()->route('directors.index')->with('success', 'Director added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Director $director)
    {
        return view('directors.show', compact('director'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Director $director)
    {
        return view('directors.edit', compact('director'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Director $director)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'required|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($director->photo_path) {
                Storage::disk('public')->delete($director->photo_path);
            }
            $photoPath = $request->file('photo')->store('directors', 'public');
            $validated['photo_path'] = $photoPath;
        }

        $validated['is_active'] = $request->has('is_active');

        $director->update($validated);

        return redirect()->route('directors.index')->with('success', 'Director updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Director $director)
    {
        // Delete photo file
        if ($director->photo_path) {
            Storage::disk('public')->delete($director->photo_path);
        }

        $director->delete();

        return redirect()->route('directors.index')->with('success', 'Director deleted successfully!');
    }
}
