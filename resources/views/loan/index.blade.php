@extends('layouts.app')

@section('content')
<div class="myds-container">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="myds-heading-lg font-medium mb-6">Senarai Permohonan Pinjaman</h1>
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <p class="text-txt-black-500 myds-body-md">Halaman ini akan memaparkan senarai permohonan pinjaman peralatan.</p>
                
                <div class="mt-6">
                    <a href="{{ route('loan.create') }}" class="myds-btn myds-btn-primary">
                        Buat Permohonan Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection