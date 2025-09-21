@php
    $illustrationStyleSuffix = isset($configData['myStyle']) ? '-' . $configData['myStyle'] : '';
@endphp

@extends('layouts.public')

@section('title', __('429 - Terlalu Banyak Permintaan'))

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/errors.css') }}">
@endsection

@section('content')
    <div class="container-xxl container-p-y error-429" role="main" aria-labelledby="error429-title">
        <div class="misc-wrapper text-center">
            <h1 class="mb-2 mx-2 display-1 fw-bolder" id="error429-title">429</h1>
            <h2 class="mb-2 mt-4 display-5 fw-bold">
                <i class="bi bi-speedometer2 me-2" aria-hidden="true"></i>{{ __('Terlalu Banyak Permintaan') }}
            </h2>
            <p class="mb-4 mx-auto col-md-8 col-lg-6 text-muted">
                {{ __('Anda telah menghantar terlalu banyak permintaan dalam masa singkat. Sila tunggu sebentar dan cuba lagi.') }}
            </p>
            <a href="javascript:location.reload()" class="myds-btn m-2 bg-info text-white rounded-2 px-4 py-2 d-inline-flex align-items-center"
                aria-label="{{ __('Cuba Sekali Lagi') }}">
                <i class="bi bi-arrow-clockwise me-2" aria-hidden="true"></i>{{ __('Cuba Sekali Lagi') }}
            </a>
            {{-- <div class="mt-4">
                <img src="{{ asset('assets/img/illustrations/myds-error-429' . $illustrationStyleSuffix . '.png') }}"
                     alt="{{ __('Ilustrasi Had Permintaan') }}" class="img-fluid myds-error-illustration">
            </div> --}}
        </div>
    </div>
@endsection