@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Formulir Edit -->
                        <form method="post" action="{{ route('adminbuku.update', $buku->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Menyertakan metode PUT untuk mengirimkan data -->

                            <!-- Nama Buku -->
                            <div class="mb-3">
                                <label for="name">Nama Buku</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ $buku->name }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kategori Buku -->
                            <div class="mb-3">
                                <label for="kategori_id">Kategori Buku</label>
                                <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                    name="kategori_id">
                                    <option value="" disabled>Pilih Kategori Buku</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}"
                                            {{ $buku->kategori_id == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->name }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Harga Buku -->
                            <div class="mb-3">
                                <label for="price">Harga Buku</label>
                                <input type="number" placeholder="Dalam Rupiah"
                                    class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                                    value="{{ $buku->price }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gambar Buku -->
                            <div class="mb-3">
                                <label for="image">Gambar</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*" onchange="previewImage(this);">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <img id="image-preview" src="{{ $buku->image_url }}" alt="Preview"
                                    style="max-width: 50%; display: {{ $buku->image_url ? 'block' : 'none' }}">
                            </div>


                            <!-- Deskripsi Buku -->
                            <div class="mb-3">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" class="form-control" style="height: 200px;">{{ $buku->description }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" class="form-control" id="slug" name="slug"
                                value="{{ $buku->slug }}" required>

                            <!-- Tombol Simpan -->
                            <div class="d-flex justify-content-around">
                                <a href="{{ route('adminbuku.index') }}">
                                    <button type="button" class="btn btn-secondary">Batal</button>
                                </a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
    <script>
        document.getElementById('name').addEventListener('input', function() {
            const namaKategori = this.value;
            const slug = namaKategori.toLowerCase().replace(/ /g, '-');
            document.getElementById('slug').value = slug;
        });


        function previewImage(input) {
            var preview = document.getElementById('image-preview');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
                // Update the image name in the input field
                document.getElementById('image').value = file.name;
            } else {
                preview.src = '';
                preview.style.display = 'none'; // Ubah menjadi 'none' jika tidak ada gambar yang dipilih
            }
        }



        document.addEventListener('trix-file-accept', function(event) {
            // Prevent file attachments in Trix editor
            event.preventDefault();
        });

        // Initialize Trix editor
        document.addEventListener('trix-initialize', function() {
            var editor = document.querySelector('trix-editor');
            editor.addEventListener('trix-attachment-add', function(event) {
                // Remove attachments from the editor
                event.attachment.remove();
            });
        });
    </script>
@endsection
