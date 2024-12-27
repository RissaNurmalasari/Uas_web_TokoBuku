@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Formulir Create -->
                        <form method="post" action="{{ route('kategori.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name">Nama Kategori</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="hidden" class="form-control" id="slug" name="slug">
                            <!-- Tambahkan elemen formulir lainnya sesuai kebutuhan -->
                            <div class="d-flex justify-content-around">
                                <a href="/admin/kategori">
                                    <button type="button" class="btn btn-secondary">Batal</button>
                                </a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                        <!-- End Formulir Create -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('name').addEventListener('input', function() {
            const namaKategori = this.value;
            const slug = namaKategori.toLowerCase().replace(/ /g, '-');
            document.getElementById('slug').value = slug;
        });
    </script>
@endsection
