@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Formulir Create -->
                        <form method="post" action="{{ route('adminbuku.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- Tambahkan elemen formulir sesuai kebutuhan -->
                            <div class="mb-3">
                                <label for="name">Nama Buku</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="kategori_id">Kategori Buku</label>
                                <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                    name="kategori_id">
                                    <option value="" disabled selected>Pilih Kategori Buku</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name">Harga Buku</label>
                                <input type="number" placeholder="Dalam Rupiah"
                                    class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                                    value="{{ old('price') }}">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="image">Gambar</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*" onchange="previewImage(this);">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <img id="image-preview" src="#" alt="Preview"
                                    style="max-width: 50%; display: none;">
                            </div>
                            <div class="mb-3">
                                <label for="description" style="font-size: small;">Deskripsi</label>
                                <textarea name="description" style="font-size: small; height: 200px; width: 500px;"></textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="mb-3">
                                <label for="description">Deskripsi</label>
                                <trix-editor input="my-textarea" data-trix-attribute="content"
                                    data-trix-attachments="false"></trix-editor>
                                <input type="hidden" id="my-textarea" name="description">
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <input type="hidden" class="form-control" id="slug" name="slug" required>

                            <div class="d-flex justify-content-around">
                                <a href="/admin/post">
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
                preview.style.display = null;
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

{{-- <div class="mb-3">
    <label for="category">Pilih Kategori</label>
    <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori"
        name="kategori_id">
        @foreach ($kategoris as $kategori)
            <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
        @endforeach
    </select>
    @error('kategori_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div> --}}
