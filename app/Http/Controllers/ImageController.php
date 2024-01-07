<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Intervention\Image\Facades\Image;


class ImageController extends Controller
{

    public function index()
    {
        // Fetch user's images
        $images = Auth::user()->images;

        return view('images.index', compact('images'));
    }

    public function create()
    {
        return view('images.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Upload image
        $imagePath = $request->file('image')->store('images', 'public');

        // Save image record to database
        Auth::user()->images()->create([
            'name' => $request->file('image')->getClientOriginalName(),
            'path' => $imagePath,
            'description' => 'a screenshot image'
        ]);

        return redirect()->route('images.index')->with('success', 'Image uploaded successfully.');
    }

}
