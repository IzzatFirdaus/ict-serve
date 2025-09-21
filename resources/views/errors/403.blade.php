@php
    $illustrationStyleSuffix = isset($configData['myStyle']) ? '-' . $configData['myStyle'] : '';
@endphp

@extends('layouts.public')

@section('title', __('403 - Akses Dihalang'))

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/errors.css') }}">
@endsection

@section('content')
    <div class="container-xxl container-p-y error-403" role="main" aria-labelledby="error403-title">
        <div class="misc-wrapper text-center">
            <h1 class="mb-2 mx-2 display-1 fw-bolder" id="error403-title">403</h1>
            <h2 class="mb-2 mt-4 display-5 fw-bold">
                <i class="bi bi-hand-thumbs-down-fill me-2" aria-hidden="true"></i>{{ __('Akses Dihalang!') }}
            </h2>
            <p class="mb-4 mx-auto col-md-8 col-lg-6 text-muted">
                {{ __('Anda tidak mempunyai kebenaran mencukupi untuk mengakses sumber ini. Sila hubungi pentadbir sistem jika anda memerlukan akses.') }}
            </p>
            <a href="{{ url('/') }}" class="myds-btn m-2 bg-danger-600 text-white rounded-2 px-4 py-2 d-inline-flex align-items-center"
                aria-label="{{ __('Kembali ke Laman Utama') }}">
                <i class="bi bi-house-door-fill me-2" aria-hidden="true"></i>{{ __('Kembali ke Laman Utama') }}
            </a>
            <div class="mt-4">
                {{-- <img src="{{ asset('assets/img/illustrations/myds-error-403' . $illustrationStyleSuffix . '.png') }}"
                    alt="{{ __('Ilustrasi Akses Dihalang') }}" width="200"
                    class="img-fluid myds-error-illustration" /> --}}
            </div>
        </div>
    </div>
@endsection