@php
    $illustrationStyleSuffix = isset($configData['myStyle']) ? '-' . $configData['myStyle'] : '';
@endphp

@extends('layouts.public')

@section('title', __('503 - Laman Dalam Selenggaraan'))

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/errors.css') }}">
@endsection

@section('content')
    <div class="container-xxl container-p-y error-503" role="main" aria-labelledby="error503-title">
        <div class="misc-wrapper text-center">
            <h1 class="mb-2 mx-2 display-1 fw-bolder" id="error503-title">503</h1>
            <h2 class="mb-2 mt-4 display-5 fw-bold">
                <i class="bi bi-gear-fill me-2" aria-hidden="true"></i>{{ __('Laman Dalam Selenggaraan') }}
            </h2>
            <p class="mb-4 mx-auto col-md-8 col-lg-6 text-muted">
                {{ __('Sistem kami sedang dalam selenggaraan buat sementara waktu. Kami akan kembali secepat mungkin. Terima kasih atas kesabaran anda!') }}
            </p>
            @auth
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="myds-btn m-2 bg-secondary text-white rounded-2 px-4 py-2 d-inline-flex align-items-center"
                            type="submit" aria-label="{{ __('Log Keluar') }}">
                        <i class="bi bi-box-arrow-left me-2" aria-hidden="true"></i>{{ __('Log Keluar') }}
                    </button>
                </form>
            @endauth
            <div class="mt-4 pt-2">
                {{-- <img src="{{ asset('assets/img/illustrations/myds-maintenance' . $illustrationStyleSuffix . '.png') }}"
                     alt="{{ __('Ilustrasi Laman Dalam Selenggaraan') }}" width="300"
                     class="img-fluid myds-error-illustration"> --}}
            </div>
        </div>
    </div>
@endsection