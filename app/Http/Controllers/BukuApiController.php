<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BukuApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buku = Buku::all()->map(function ($item) {
            $item->image_url = url($item->image);
            return $item;
        });

        return response()->json($buku, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'kategori_id' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:10048',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $buku = new Buku();
        $buku->kategori_id = $request->kategori_id;
        $buku->name = $request->name;
        $buku->image = $request->image;
        $buku->price = $request->price;
        $buku->description = $request->description;
        $buku->save();

        return response()->json($buku, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->query('id');
        $buku = Buku::where('id', $id)->first();

        if (!$buku) {
            return response()->json(['message' => 'Buku not found'], 404);
        }
        return response()->json($buku);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function edit(Buku $buku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'kategori_id' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
            'description' => 'required|string|max:255',
        ]);
        $id = $request->input('id');

        $buku = Buku::findOrFail($id);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            if (File::exists(public_path($buku->image))) {
                File::delete(public_path($buku->image));
            }
            $imageName = $request->file('image')->getClientOriginalName();
            $namagambar = $buku->id . $imageName;
            $request->file('image')->move(public_path('uploads'), $namagambar);
            $buku->image = 'uploads/' . $namagambar;

            // Delete old image if exists

        }

        // Update other fields
        $buku->name = $request->input('name');
        $buku->kategori_id = $request->input('kategori_id');
        $buku->price = $request->input('price');
        $buku->description = $request->input('description');
        $buku->save();
        return response()->json($buku);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $id = $request->input('id');
            $buku = Buku::findOrFail($id);

            $buku->delete();

            return response()->json(['message' => 'Buku deleted successfully']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Buku not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete buku'], 500);
        }
    }
}
