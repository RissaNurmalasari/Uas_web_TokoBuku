@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">

                        <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name">Nama User</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password"
                                        class="form-control mb-3  @error('password') is-invalid @enderror" id="password"
                                        name="password">
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword"
                                        aria-label="Toggle password visibility">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" aria-label="Konfirmasi Password">
                                <div id="passwordMatchMessage" class="text-red"></div>
                            </div>


                            <div class="d-flex justify-content-around">
                                <a href="/admin/user">
                                    <button type="button" class="btn btn-secondary">Batal</button>
                                </a>
                                <button type="submit" class="btn btn-primary" aria-label="Simpan">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // JavaScript untuk menampilkan/menyembunyikan password
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation'); // Tambahkan ini

        const togglePasswordButton = document.getElementById('togglePassword');

        togglePasswordButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ganti ikon mata terbuka/tutup
            const eyeIconClass = type === 'password' ? 'fa-eye' : 'fa-eye-slash';
            togglePasswordButton.innerHTML = `<i class="fa ${eyeIconClass}" aria-hidden="true"></i>`;
        });

        // JavaScript untuk memeriksa kecocokan antara password dan konfirmasi password
        const passwordMatchMessage = document.getElementById('passwordMatchMessage');

        function validatePassword() {
            if (passwordInput.value !== confirmPasswordInput.value) {
                passwordMatchMessage.innerHTML = 'Password tidak cocok.';
                confirmPasswordInput.setCustomValidity('Password tidak cocok.');
            } else {
                passwordMatchMessage.innerHTML = '';
                confirmPasswordInput.setCustomValidity('');
            }
        }

        passwordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', validatePassword);
    </script>
    <style>
        .text - red {
            color: red;
        }
    </style>
@endsection
