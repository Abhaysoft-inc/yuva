<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = Slide::orderBy('order')->get();
        return view('slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('slides.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'required|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('slides', 'public');
            $validated['image_path'] = $imagePath;
        }

        $validated['is_active'] = $request->has('is_active');

        Slide::create($validated);

        return redirect()->route('slides.index')->with('success', 'Slide added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slide $slide)
    {
        return view('slides.show', compact('slide'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slide $slide)
    {
        return view('slides.edit', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slide $slide)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'required|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($slide->image_path) {
                Storage::disk('public')->delete($slide->image_path);
            }
            $imagePath = $request->file('image')->store('slides', 'public');
            $validated['image_path'] = $imagePath;
        }

        $validated['is_active'] = $request->has('is_active');

        $slide->update($validated);

        return redirect()->route('slides.index')->with('success', 'Slide updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slide $slide)
    {
        // Delete image file
        if ($slide->image_path) {
            Storage::disk('public')->delete($slide->image_path);
        }

        $slide->delete();

        return redirect()->route('slides.index')->with('success', 'Slide deleted successfully!');
    }
}
