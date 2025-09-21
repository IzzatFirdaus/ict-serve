@php
    $illustrationStyleSuffix = isset($configData['myStyle']) ? '-' . $configData['myStyle'] : '';
@endphp

@extends('layouts.public')

@section('title', __('500 - Ralat Pelayan Dalaman'))

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/errors.css') }}">
@endsection

@section('content')
    <div class="container-xxl container-p-y error-500" role="main" aria-labelledby="error500-title">
        <div class="misc-wrapper text-center">
            <h1 class="mb-2 mx-2 display-1 fw-bolder" id="error500-title">500</h1>
            <h2 class="mb-2 mt-4 display-5 fw-bold">
                <i class="bi bi-server me-2" aria-hidden="true"></i>{{ __('Ralat Pelayan Dalaman') }}
            </h2>
            <p class="mb-4 mx-auto col-md-8 col-lg-6 text-muted">
                {{ __('Maaf, berlaku ralat di pihak kami. Sila cuba semula nanti atau hubungi sokongan jika masalah berterusan.') }}
            </p>
            <a href="{{ url('/') }}" class="myds-btn m-2 bg-danger-600 text-white rounded-2 px-4 py-2 d-inline-flex align-items-center"
                aria-label="{{ __('Laman Utama') }}">
                <i class="bi bi-house-door-fill me-2" aria-hidden="true"></i>{{ __('Laman Utama') }}
            </a>
            {{-- <div class="mt-4">
                <img src="{{ asset('assets/img/illustrations/myds-error-500' . $illustrationStyleSuffix . '.png') }}"
                     alt="{{ __('Ilustrasi Ralat Server') }}" class="img-fluid myds-error-illustration">
            </div> --}}
        </div>
    </div>
@endsection