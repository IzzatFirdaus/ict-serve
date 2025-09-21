@php
    $illustrationStyleSuffix = isset($configData['myStyle']) ? '-' . $configData['myStyle'] : '';
@endphp

@extends('layouts.public')

@section('title', __('404 - Halaman Tidak Ditemui'))

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/errors.css') }}">
@endsection

@section('content')
    <div class="container-xxl container-p-y error-404" role="main" aria-labelledby="error404-title">
        <div class="misc-wrapper text-center">
            <h1 class="mb-2 mx-2 display-1 fw-bolder error-code" id="error404-title">404</h1>
            <h2 class="mb-2 mt-4 display-5 fw-bold error-title">
                <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i>{{ __('Halaman Tidak Ditemui!') }}
            </h2>
            <p class="mb-4 mx-auto col-md-8 col-lg-6 text-muted">
                {{ __('Halaman yang anda cuba akses tidak wujud atau telah dipindahkan. Sila semak URL atau kembali ke halaman utama.') }}
            </p>
            <a href="{{ url('/') }}" class="myds-btn m-2 bg-primary-600 text-white rounded-2 px-4 py-2 d-inline-flex align-items-center"
                aria-label="{{ __('Kembali ke Laman Utama') }}">
                <i class="bi bi-house-door-fill me-2" aria-hidden="true"></i>{{ __('Kembali ke Laman Utama') }}
            </a>
            {{-- Illustration block (optional) --}}
            {{-- <div class="mt-4">
                <img src="{{ asset('assets/img/illustrations/myds-error-404' . $illustrationStyleSuffix . '.png') }}"
                     alt="{{ __('Ilustrasi Halaman Tidak Ditemui') }}"
                     width="250" class="img-fluid myds-error-illustration">
            </div> --}}
        </div>
    </div>
@endsection