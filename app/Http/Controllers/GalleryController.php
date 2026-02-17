<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'order' => 'required|integer',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048|required_without:images',
            'images' => 'nullable|array|required_without:image',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $files = [];
        if ($request->hasFile('images')) {
            $files = $request->file('images');
        } elseif ($request->hasFile('image')) {
            $files = [$request->file('image')];
        }

        if (empty($files)) {
            return redirect()->back()
                ->withErrors(['images' => 'Please upload at least one image.'])
                ->withInput();
        }

        $isActive = $request->has('is_active');
        $baseOrder = (int) $validated['order'];
        $createdCount = 0;

        foreach ($files as $index => $file) {
            $imagePath = $file->store('gallery', 'public');

            Gallery::create([
                'title' => $validated['title'] ?? null,
                'description' => $validated['description'] ?? null,
                'image_path' => $imagePath,
                'category' => $validated['category'],
                'order' => $baseOrder + $index,
                'is_active' => $isActive,
            ]);

            $createdCount++;
        }

        $message = $createdCount === 1
            ? 'Image added to gallery successfully!'
            : $createdCount . ' images added to gallery successfully!';

        return redirect()->route('gallery.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return view('gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return view('gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => 'required|string|max:255',
            'order' => 'required|integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $imagePath = $request->file('image')->store('gallery', 'public');
            $validated['image_path'] = $imagePath;
        }

        $validated['is_active'] = $request->has('is_active');

        $gallery->update($validated);

        return redirect()->route('gallery.index')->with('success', 'Gallery image updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete image file
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gallery image deleted successfully!');
    }

    /**
     * Remove selected gallery images in bulk.
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'gallery_ids' => 'required|array|min:1',
            'gallery_ids.*' => 'integer|exists:galleries,id',
        ]);

        $galleries = Gallery::whereIn('id', $validated['gallery_ids'])->get();

        foreach ($galleries as $gallery) {
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }
        }

        $deleted = Gallery::whereIn('id', $validated['gallery_ids'])->delete();

        return redirect()->route('gallery.index')->with(
            'success',
            $deleted . ' selected image(s) deleted successfully!'
        );
    }
}
