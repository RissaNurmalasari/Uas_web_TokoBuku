@extends('public.layouts.main')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Keranjang Belanja</h2>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Kuantitas</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bukus as $index => $buku)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $buku->book_name }}</td>
                        <td class="price">Rp{{ number_format($buku->price, 0, ',', '.') }}</td>
                        <td>
                            <input type="number" class="form-control quantity" value="{{ $buku->quantity }}" min="1"
                                data-price="{{ $buku->price }}">
                        </td>
                        <td class="total">Rp{{ number_format($buku->price * $buku->quantity, 0, ',', '.') }}</td>
                        <td>
                            <form action="/pemesanan/{{ $buku->id }}" method="post"
                                id="deleteForm-{{ $buku->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteItem('{{ $buku->id }}')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <h4>Total: Rp<span id="grandTotal">{{ number_format($grandTotal, 0, ',', '.') }}</span></h4>
            <button class="btn btn-primary">Checkout</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function deleteItem(id) {
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
                    // Temukan formulir dengan id yang sesuai
                    const form = document.getElementById('deleteForm-' + id);
                    form.submit();
                }
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('.quantity');
            const grandTotalElement = document.getElementById('grandTotal');

            function updateTotal() {
                let grandTotal = 0;
                quantityInputs.forEach(input => {
                    const price = parseFloat(input.getAttribute('data-price'));
                    const quantity = parseInt(input.value);
                    const total = price * quantity;

                    const totalElement = input.closest('tr').querySelector('.total');
                    totalElement.textContent = `Rp${total.toLocaleString('id-ID')}`;

                    grandTotal += total;
                });
                grandTotalElement.textContent = `Rp${grandTotal.toLocaleString('id-ID')}`;
            }

            quantityInputs.forEach(input => {
                input.addEventListener('input', updateTotal);
            });

            updateTotal();
        });
    </script>
@endsection
