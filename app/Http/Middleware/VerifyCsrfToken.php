<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/buku', // Tambahkan endpoint yang diizinkan tanpa CSRF
        'api/buku/*', // Tambahkan jika ada sub-path yang terkait
        'api/login'
    ];
}
