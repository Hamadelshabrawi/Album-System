<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Pictures;
use Illuminate\Http\Request;
use App\Models\Albums;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class AlbumController extends Controller
{
    public function index()
    {
        $albums = Albums::with('pictures')->get();
        return view('albums.index', compact('albums'));

    }
    public function album_edit($id)
    {
        $albums = Albums::find($id);
        if ($albums->pictures->count() >= 1) {
            return view('albums.edit', compact('albums'));
        } else {
            return redirect()->back()->withErrors('Cannot edit this album because it is empty');
        }
    }
    public function show_albbum($id)
    {
        $albums = Albums::find($id);
        if ($albums->pictures->count() >= 1) {
            return view('albums.show', compact('albums'));
        } else {
            return redirect()->back()->withErrors('Cannot show this album because it is empty');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'albumName' => 'required|string|max:255',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'imageTitles.*' => 'required|string|max:255',
        ]);

        $user_id = Auth::user()->id;

        $album = Albums::create([
            'name' => $request->input('albumName'),
            'user_id' => $user_id,
        ]);

        foreach ($request->file('images') as $key => $image) {
            $title = $request->input("imageTitles.$key");

            $name = Str::slug($title) . '.' . $image->getClientOriginalExtension();

            $picture = new Pictures([
                'name' => $name,
                'album_id' => $album->id,
            ]);
            $album->pictures()->save($picture);
            $image->storeAs('public/pictures', $name);
        }

        return redirect()->route('albums.index')->with('success', 'Album created successfully.');
    }


    public function update(Request $request, $id)
    {

        // Validate the form data
        $request->validate([
            'albumName' => 'required|string|max:255',
            'additionalImages.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'imageTitles.*' => 'required|string|max:255',
        ]);

        // Find the album by ID
        $album = Albums::findOrFail($id);
        $album->name = $request->input('albumName');
        $album->save();

        // Handle existing images removal
        if ($request->has('removeImages')) {
            $imagesToRemove = $request->input('removeImages');
            Pictures::whereIn('id', $imagesToRemove)->delete();
        }

        // Handle image renaming
        $imageNames = $request->input('imageNames');

        if (is_array($imageNames)) {
            foreach ($imageNames as $fileId => $imageName) {
                $picture = Pictures::find($fileId);

                if ($picture && $picture->name !== $imageName) {
                    $originalExtension = pathinfo($picture->name, PATHINFO_EXTENSION);
                    $newImageName = $imageName . '.' . $originalExtension;

                    if (Storage::exists('public/pictures/' . $picture->name)) {
                        Storage::move('public/pictures/' . $picture->name, 'public/pictures/' . $newImageName);
                    }

                    $picture->name = $newImageName;
                    $picture->save();
                }
            }
        }

        // Handle uploading of additional images and titles
        if ($request->hasFile('additionalImages')) {
            $additionalImages = $request->file('additionalImages');
            $imageTitles = $request->input('imageTitles');
            $uploadedImages = [];

            foreach ($additionalImages as $index => $image) {
                // Get the file extension
                $extension = $image->getClientOriginalExtension();

                // Generate a unique file name
                $imageName = $imageTitles[$index] . '.' . $extension;

                // Save the image to the storage folder
                $image->storeAs('public/pictures', $imageName);

                // Add the image name and title to the uploaded images array
                $uploadedImages[] = [
                    'name' => $imageName,
                    'title' => $imageTitles[$index],
                ];
            }

            // Create picture records for the uploaded images
            $album->pictures()->createMany($uploadedImages);
        }

        return redirect()->route('albums.index')->with('success', 'Album updated successfully');
    }


    public function transform(Request $request, $id)
    {
        $request->validate([
            'targetAlbum' => 'required|exists:albums,id',
        ]);

        $sourceAlbum = Albums::findOrFail($id);
        $targetAlbum = Albums::findOrFail($request->input('targetAlbum'));
        foreach ($sourceAlbum->pictures as $picture) {
            $picture->update(['album_id' => $targetAlbum->id]);
        }
        $sourceAlbum->delete();

        return redirect()->route('albums.index')->with('success', 'Images transferred and album deleted.');
    }


    public function delete(Request $request, $id)
    {
        $sourceAlbum = Albums::findOrFail($id);
        foreach ($sourceAlbum->pictures as $images) {
            $picture = Pictures::find($images->id);
            if ($picture) {
                // Delete the image file (you may need to adjust the path)
                \Storage::delete('public/pictures/' . $picture->name);
                // Delete the image record from the database
                $picture->delete();
            }
        }
        $sourceAlbum = Albums::findOrFail($id)->delete();
        return redirect()->route('albums.index')->with('success', 'Images and album deleted.');
    }



}
