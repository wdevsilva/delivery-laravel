<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'carrinho/*',
        'carrinho/reload',
        'carrinho/get_count_js',
        'carrinho/get_count_bag',
        'carrinho/dispensar_bebidas',
    ];
}
