@php
    $illustrationStyleSuffix = isset($configData['myStyle']) ? '-' . $configData['myStyle'] : '';
@endphp

@extends('layouts.public')

@section('title', __('422 - Tidak Dapat Diproses'))

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
    <link rel="stylesheet" href="{{ asset('css/errors.css') }}">
@endsection

@section('content')
    <div class="container-xxl container-p-y error-422" role="main" aria-labelledby="error422-title">
        <div class="misc-wrapper text-center">
            <h1 class="mb-2 mx-2 display-1 fw-bolder" id="error422-title">422</h1>
            <h2 class="mb-2 mt-4 display-5 fw-bold">
                <i class="bi bi-exclamation-circle-fill me-2" aria-hidden="true"></i>{{ __('Data Tidak Sah / Tidak Dapat Diproses') }}
            </h2>
            <p class="mb-4 mx-auto col-md-8 col-lg-6 text-muted">
                {{ __('Terdapat masalah dalam data yang dihantar. Sila semak semula borang dan cuba sekali lagi.') }}
            </p>
            <a href="javascript:history.back()" class="myds-btn m-2 bg-secondary text-white rounded-2 px-4 py-2 d-inline-flex align-items-center"
                aria-label="{{ __('Kembali') }}">
                <i class="bi bi-arrow-left-circle-fill me-2" aria-hidden="true"></i>{{ __('Kembali') }}
            </a>
            {{-- <div class="mt-4">
                <img src="{{ asset('assets/img/illustrations/myds-error-422' . $illustrationStyleSuffix . '.png') }}"
                     alt="{{ __('Ilustrasi Data Tidak Sah') }}" class="img-fluid myds-error-illustration">
            </div> --}}
        </div>
    </div>
@endsection