 <!-- Navbar -->
 <nav class="navbar navbar-expand-lg navbar-light bg-light">
     <a class="navbar-brand" href="#">Toko Buku</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
         aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
     </button>
     <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav ml-auto">
             <li class="nav-item active">
                 <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
             </li>
             @if ($user->admin == 1)
                 <li class="nav-item">
                     <a class="nav-link" href="/admin">Admin</a>
                 </li>
             @else
             @endif
             <li class="nav-item">
                 <a class="nav-link" href="/pemesanan">Pemesanan</a>
             </li>
             <li class="nav-item">
                 <a class="nav-link" href="#">Selamat datang <strong> {{ $user->name }}</strong></a>
             </li>
         </ul>
     </div>
 </nav>
