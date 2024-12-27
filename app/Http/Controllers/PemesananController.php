<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePemesananRequest;
use App\Http\Requests\UpdatePemesananRequest;
use App\Models\Buku;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pemesanan = Pemesanan::where('user_id', $user->id)->get();

        // Gabungkan item dengan nama produk yang sama
        $mergedBukus = [];
        foreach ($pemesanan as $item) {
            if (isset($mergedBukus[$item->book_name])) {
                $mergedBukus[$item->book_name]->quantity += $item->quantity;
            } else {
                $mergedBukus[$item->book_name] = $item;
            }
        }

        // Mengubah kembali array asosiatif ke array numerik
        $bukus = collect(array_values($mergedBukus));

        // Menghitung total harga secara tepat sebelum dikirim ke tampilan
        $grandTotal = $bukus->sum(function ($buku) {
            return $buku->price * $buku->quantity;
        });

        return view("public.pemesanan", [
            "judul" => "User",
            "bukus" => $bukus,
            "grandTotal" => $grandTotal,
            "user" => $user,
        ]);
    }
    public function dataPemesanan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $pemesanan = Pemesanan::where('user_id', $request->input('user_id'))->get();

        // Gabungkan item dengan nama produk yang sama
        $mergedBukus = [];
        foreach ($pemesanan as $item) {
            if (isset($mergedBukus[$item->book_name])) {
                $mergedBukus[$item->book_name]->quantity += $item->quantity;
            } else {
                $mergedBukus[$item->book_name] = $item;
            }
        }

        // Mengubah kembali array asosiatif ke array numerik
        $bukus = collect(array_values($mergedBukus));

        // Menghitung total harga secara tepat sebelum dikirim ke tampilan
        $grandTotal = $bukus->sum(function ($buku) {
            return $buku->price * $buku->quantity;
        });

        $data = [
            "judul" => "User",
            "bukus" => $bukus,
            "grandTotal" => $grandTotal,
            "pemesanan" => $pemesanan,
        ];

        return response()->json($data, 200);
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
     * @param  \App\Http\Requests\StorePemesananRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeApi(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string|max:255',
            'book_id' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $pemesanan = new Pemesanan();

        $book = Buku::where('id', $request->input('book_id'))->first();
        $pemesanan->user_id = $request->input('user_id');

        $pemesanan->book_name = $book->name;
        $pemesanan->price = $book->price;
        $pemesanan->image = $book->image;
        $pemesanan->quantity = 1;
        $pemesanan->save();
        return response()->json($pemesanan, 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string|max:255',
            'book_name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'quantity' => 'required|string|max:255',
        ]);
        $pemesanan = new Pemesanan();
        $pemesanan->user_id = $request->input('user_id');
        $pemesanan->book_name = $request->input('book_name');
        $pemesanan->price = $request->input('price');
        $pemesanan->image = $request->input('image');
        $pemesanan->quantity = $request->input('quantity');
        $pemesanan->save();
        return redirect('/')->with("berhasil menambahkan ke keranjang");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function show(Pemesanan $pemesanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pemesanan $pemesanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePemesananRequest  $request
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePemesananRequest $request, Pemesanan $pemesanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pemesanan = Pemesanan::where('id', $id)->first();
        if (!$pemesanan) {
            return redirect()->route('pemesanan.index')->with('error', 'pemesanan tidak ditemukan');
        }
        $pemesanan->delete();
        return redirect()->route('pemesanan.index')->with('success', 'pemesanan berhasil di hapus');
    }
    public function apiDestroy(Request $request)
    {

        $id = $request->input('id');
        $pemesanan = Pemesanan::where('id', $id)->first();
        if (!$pemesanan) {
            return response()->json([

                'message' => 'Pemesanan tidak ditemukan',
            ], 500);
        }
        $pemesanan->delete();
        return response()->json([
            'status' => true,
            'data' => $pemesanan,
            'message' => 'Pemesanan deleted successfully'], 200);
    }
}
