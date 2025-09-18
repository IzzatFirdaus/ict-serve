@extends('layouts.app')

@section('content')
<div class="myds-container py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-txt-black-900">
                <h1 class="myds-heading-lg font-medium mb-6">Borang Permohonan Peminjaman Peralatan ICT</h1>
                
                <p class="myds-body-md text-txt-black-500 mb-6">
                    Untuk Kegunaan Rasmi Kementerian Pelancongan, Seni dan Budaya
                </p>
                
                <div class="mb-6">
                    <a href="{{ route('equipment-loan.create') }}" class="myds-btn myds-btn-primary">
                        Mulakan Permohonan Baru
                    </a>
                </div>
                
                <p class="myds-body-md text-txt-black-500">
                    Senarai permohonan peminjaman peralatan ICT akan dipaparkan di sini.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection