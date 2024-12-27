@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Formulir Edit -->
                        <form method="post" action="{{ route('kategori.update', $kategori->id) }}">
                            @csrf
                            @method('PUT')
                            <!-- Tambahkan elemen formulir sesuai kebutuhan -->
                            <div class="mb-3">
                                <label for="name">Nama Kategori</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $kategori->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <!-- Tambahkan elemen formulir lainnya sesuai kebutuhan -->
                            <div class="d-flex justify-content-around">
                                <a href="/admin/kategori">
                                    <button type="button" class="btn btn-secondary">Batal</button>
                                </a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                        <!-- End Formulir Edit -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
