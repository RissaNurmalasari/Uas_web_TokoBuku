@extends('admin.layouts.main')
@section('content')
    <div class="container-fluid py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 row">
                    <div class="card-header pb-4">
                        <a href="/admin/kategori/create"> <button type="submit" class="btn btn-success">Tambah</button></a>
                    </div>
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" placeholder="Type here..." id="searchInput">
                        </div>

                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="kategoriTable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama</th>

                                        <th class="text-secondary opacity-7">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategoris as $kategori)
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 d-flex px-4 py-1">
                                                    {{ $loop->iteration }}</p>
                                            </td>
                                            <td>
                                                <div class=" d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $kategori->name }}</h6>
                                                        {{-- <p class="text-xs text-secondary mb-0">john@creative-tim.com</p> --}}
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="btn-group mr-3">
                                                    <a href="/admin/kategori/{{ $kategori->id }}/edit"
                                                        class="text-primary badge badge-sm badge-secondary d-flex px-2 py-1 font-weight-bold text-xs"
                                                        data-toggle="tooltip" data-original-title="Edit user">
                                                        Edit
                                                    </a>
                                                </div>
                                                <div class="btn-group">
                                                    <form method="post" id="deleteForm"
                                                        action="{{ route('kategori.destroy', $kategori->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button"
                                                            class="text-danger badge badge-sm badge-secondary bg-transparent border-0"
                                                            onclick="deleteCategory('{{ $kategori->id }}')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function deleteCategory(slug) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Jika dihapus, data tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true // Tombol OK berada di sebelah kanan
            }).then((result) => {
                if (result.isConfirmed) {
                    // Temukan formulir dengan slug yang diberikan
                    const form = document.getElementById('deleteForm');
                    form.action = "/admin/kategori/" + slug;
                    form.submit();
                }
            });
        }
    </script>

    <!-- Add this script to hide the alert after a delay (e.g., 5 seconds) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('success-alert').style.display = 'none';
            }, 5000); // 5000 milliseconds = 5 seconds
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Get the input field and table
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('kategoriTable');

            // Add an event listener to the input field
            searchInput.addEventListener('input', function() {
                const searchValue = searchInput.value.toLowerCase().trim();

                // Iterate through each row in the table
                Array.from(table.getElementsByTagName('tr')).forEach(function(row) {
                    const nameColumn = row.getElementsByTagName('td')[
                        1]; // Adjust the index based on your column order

                    // If the row contains the search value, show it; otherwise, hide it
                    if (nameColumn) {
                        const nameText = nameColumn.textContent.toLowerCase();
                        row.style.display = nameText.includes(searchValue) ? '' : 'none';
                    }
                });
            });
        });
    </script>
@endsection
