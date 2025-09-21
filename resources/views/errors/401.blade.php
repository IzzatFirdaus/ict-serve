@php
    // Use MYDS adaptive illustration suffix if available
    $illustrationStyleSuffix = isset($configData['myStyle']) ? '-' . $configData['myStyle'] : '';
@endphp

@extends('layouts.public')

@section('title', __('401 - Tidak Dibenarkan'))

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/errors.css') }}">
@endsection

@section('content')
    <div class="container-xxl container-p-y error-401" role="main" aria-labelledby="error401-title">
        <div class="misc-wrapper text-center">
            <h1 class="mb-2 mx-2 display-1 fw-bolder" id="error401-title">401</h1>
            <h2 class="mb-2 mt-4 display-5 fw-bold">
                <i class="bi bi-person-fill-lock me-2" aria-hidden="true"></i>{{ __('Akses Tidak Sah!') }}
            </h2>
            <p class="mb-4 mx-auto col-md-8 col-lg-6 text-muted">
                {{ __('Anda tidak mempunyai kebenaran untuk mengakses halaman ini. Sila log masuk dengan akaun yang sah atau hubungi pentadbir sistem jika ini adalah satu kesilapan.') }}
            </p>
            <a href="{{ url('/') }}" class="myds-btn m-2 bg-danger-600 text-white rounded-2 px-4 py-2 d-inline-flex align-items-center"
                aria-label="{{ __('Kembali ke Laman Utama') }}">
                <i class="bi bi-house-door-fill me-2" aria-hidden="true"></i>{{ __('Kembali ke Laman Utama') }}
            </a>
            <div class="mt-4">
                {{-- <img src="{{ asset('assets/img/illustrations/myds-error-401' . $illustrationStyleSuffix . '.png') }}"
                    alt="{{ __('Ilustrasi Akses Tidak Dibenarkan') }}" width="200"
                    class="img-fluid myds-error-illustration" /> --}}
            </div>
        </div>
    </div>
@endsection