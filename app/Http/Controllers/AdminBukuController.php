<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.post.index", [
            "judul" => "Barang",
            "posts" => Buku::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view(
            'admin.post.create',
            [
                'judul' => 'Buku',
                'kategoris' => Kategori::all(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'kategori_id' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
        'description' => 'required|string',
    ]);

    try {
        $buku = new Buku();
        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->getClientOriginalName();
            $namagambar = time() . '-' . $imageName;
            $request->file('image')->move(public_path('uploads'), $namagambar);
            $buku->image = 'uploads/' . $namagambar;
        }
        $buku->name = $request->input('name');
        $buku->kategori_id = $request->input('kategori_id');
        $buku->price = $request->input('price');
        $buku->description = $request->input('description');
        $buku->save();

        return redirect()->route('adminbuku.index')->with('success', 'Barang berhasil disimpan.');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function show(Buku $buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $buku = Buku::where('id', $id)->first();
        return view(
            'admin.post.edit',
            [
                'judul' => 'Edit Buku',
                'buku' => $buku,
                'kategoris' => Kategori::all(),

            ]
        );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kategori_id' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
            'description' => 'required|string',
        ]);

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

        return redirect()->route('adminbuku.index')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buku  $buku
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buku = Buku::where('id', $id)->first();

        if (!$buku) {
            return redirect()->route('adminbuku.index')->with('error', 'buku tidak ditemukan');
        }

        // Hapus gambar jika ada
        if (File::exists(public_path($buku->image))) {
            File::delete(public_path($buku->image));
        }

        $buku->delete();

        return redirect()->route('adminbuku.index')->with('success', 'buku berhasil dihapus.');
    }
}
