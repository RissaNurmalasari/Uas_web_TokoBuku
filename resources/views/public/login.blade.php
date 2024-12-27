<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E Book</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
</head>

<body style="height: 100vh; display: flex; justify-content: center; align-items: center;">
    <div class="content-wrapper">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('danger'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="danger-alert">
                {{ session('danger') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container-fluid">
            <div class="row d-flex justify-content-center" style=" height:5%; margin-top: 1%;">
                <!-- Form Login -->
                <div id="errorAlert" class="alert alert-danger" style="display: none;">
                    <button id="dismissError" class="btn-close float-end" aria-label="Close"></button>
                    <ul id="errorList">
                    </ul>
                </div>
                <div class="card shadow-lg bg-dark bg-gradient" style="width: 20rem; --bs-bg-opacity: .1;">
                    <div class="card-body">
                        <form class="form" method="POST" action="/ceklogin">
                            @csrf
                            <div class="input-group justify-content-center mb-2 ">
                                <h2>LOGIN</h2>
                            </div>
                            <hr>
                            <div class="mb-3 ">
                                <div class="input-group">
                                    <input type="email" autofocus class="shadow form-control" name="email"
                                        aria-describedby="email" required placeholder="Masukan Email"
                                        style="opacity: 0.7;">
                                    <i class="shadow input-group-text bi bi-person-fill"></i>
                                </div>
                            </div>
                            <div class="mb-2" style="padding-bottom: 6%;">
                                <div class=" input-group ">
                                    <input type="password" class="shadow form-control " id="exampleInputPassword1"
                                        required placeholder="Masukan Password" name="password" style="opacity: 0.7;">
                                    <span class="shadow input-group-text bi bi-eye-slash" id="showPassword"></span>
                                </div>
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto mb-3">
                                <button class="shadow text-light btn btn-success" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.3/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah ada notifikasi success dari session
            let successMessage = '{{ session('error') }}';

            if (successMessage) {
                Swal.fire({
                    icon: 'error',
                    title: successMessage,
                    showConfirmButton: false,
                    timer: 3000 // 3 detik
                });
            }
        });
    </script>
    <script>
        const passwordInput = document.getElementById("exampleInputPassword1");
        const showPasswordIcon = document.getElementById("showPassword");

        showPasswordIcon.addEventListener("click", function() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                showPasswordIcon.classList.remove("bi-eye-slash");
                showPasswordIcon.classList.add("bi-eye");
            } else {
                passwordInput.type = "password";
                showPasswordIcon.classList.remove("bi-eye");
                showPasswordIcon.classList.add("bi-eye-slash");
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah ada notifikasi error dari session
            let errorMessage = '{{ $errors->first() }}'; // Mengambil pesan error pertama dari laravel

            if (errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                    showConfirmButton: false,
                    timer: 3000 // Tampilkan notifikasi selama 3 detik
                });
            }
        });
    </script>



</body>

</html>
