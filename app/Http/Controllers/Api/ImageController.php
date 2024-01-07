<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;

class ImageController extends Controller
{
    // API method to create an image
    public function create(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Check if the request has a file
        if ($request->hasFile('image')) {
            // Retrieve the uploaded file
            $imageFile = $request->file('image');

            // Generate a unique name for the image
            $imageName = uniqid() . '.' . $imageFile->getClientOriginalExtension();

            // Store the image in the 'images' directory within the 'public' disk
            $imagePath = $imageFile->storeAs('images', $imageName, 'public');

            // Save image record to the database
            $image = Auth::user()->images()->create([
                'name' => $imageName,
                'path' => $imagePath,
                'description' => $request->input('description', 'a screenshot image'), // Use description from the request or a default value
            ]);

            // Respond with success message and image data
            return response()->json(['message' => 'Image uploaded successfully', 'data' => $image], Response::HTTP_CREATED);
        }

        // If no file is present, respond with an error
        return response()->json(['error' => 'No image file provided'], Response::HTTP_BAD_REQUEST);
    }
    // API method to view images
    public function index()
    {
        $images = Auth::user()->images;

        return response()->json(['data' => $images], Response::HTTP_OK);
    }

    // API method to delete an image
    public function destroy(Image $image)
    {
        // Ensure the user owns the image
        if (Auth::id() !== $image->user_id) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        // Delete image record from database
        $image->delete();

        // Optionally, you may also want to delete the physical image file
        // Storage::disk('public')->delete($image->path);

        return response()->json(['message' => 'Image deleted successfully'], Response::HTTP_OK);
    }
}
