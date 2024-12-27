@extends('public.layouts.main')
@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Daftar Barang</h1>
        <div class="row">
            <!-- Kartu Barang 1 -->
            @foreach ($bukus as $buku)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset($buku->image) }}" class="card-img-top" alt="Gambar Barang 1">
                        <div class="card-body">
                            <h5 class="card-title">{{ $buku->name }}</h5>
                            <p class="card-text">{{ $buku->description }}.</p>
                            <p class="card-text"><strong>Harga:</strong> Rp{{ $buku->price }}</p>
                            <a href="#" class="btn btn-primary">Lihat Detail</a>
                            <form action="{{ route('pemesanan.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="book_name" value="{{ $buku->name }}">
                                <input type="hidden" name="price" value="{{ $buku->price }}">
                                <input type="hidden" name="image" value="{{ $buku->image }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button class="btn btn-success">Tambah Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
