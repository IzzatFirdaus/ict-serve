@php
    $illustrationStyleSuffix = isset($configData['myStyle']) ? '-' . $configData['myStyle'] : '';
@endphp

@extends('layouts.public')

@section('title', __('419 - Sesi Telah Tamat'))

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/errors.css') }}">
@endsection

@section('content')
    <div class="container-xxl container-p-y error-419" role="main" aria-labelledby="error419-title">
        <div class="misc-wrapper text-center">
            <h1 class="mb-2 mx-2 display-1 fw-bolder" id="error419-title">419</h1>
            <h2 class="mb-2 mt-4 display-5 fw-bold">
                <i class="bi bi-clock-history me-2" aria-hidden="true"></i>{{ __('Sesi Telah Tamat!') }}
            </h2>
            <p class="mb-4 mx-auto col-md-8 col-lg-6 text-muted">
                {{ __('Sesi anda telah tamat atau permintaan tidak sah. Sila muat semula halaman atau log masuk semula untuk meneruskan.') }}
            </p>
            <a href="{{ url('/login') }}" class="myds-btn m-2 bg-warning-600 text-white rounded-2 px-4 py-2 d-inline-flex align-items-center"
                aria-label="{{ __('Log Masuk Semula') }}">
                <i class="bi bi-box-arrow-in-right me-2" aria-hidden="true"></i>{{ __('Log Masuk Semula') }}
            </a>
            <div class="mt-4">
                {{-- <img src="{{ asset('assets/img/illustrations/myds-error-419' . $illustrationStyleSuffix . '.png') }}"
                     alt="{{ __('Ilustrasi Sesi Tamat') }}" width="200"
                     class="img-fluid myds-error-illustration"> --}}
            </div>
        </div>
    </div>
@endsection
