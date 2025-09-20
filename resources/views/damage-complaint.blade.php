@extends('layouts.app')

@section('content')
  <div class="myds-container py-8">
    <h1 class="myds-heading text-heading-md">Borang Aduan Kerosakan</h1>
    <p class="mt-4">Maklumat Kerosakan</p>

    <p class="mt-2">Sila isi maklumat kerosakan di bawah.</p>

    <div class="mt-6">
      <a href="{{ url('/') }}" class="text-primary-600">Kembali ke Laman Utama</a>
    </div>
  </div>
@endsection
