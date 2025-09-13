@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-3 border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center gap-2" style="font-size:1.25rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                        <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 2 7.5V14a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-3h2v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1V7.5a.5.5 0 0 0-.146-.354l-6-6zM13 14h-2v-3a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v3H3V7.707l5-5 5 5V14z"/>
                    </svg>
                    <span>Dashboard</span>
                </div>
                <div class="card-body text-center bg-light">
                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h2 class="mb-3 fw-bold text-success">Welcome!</h2>
                    <p class="mb-0 text-secondary">You are logged in!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
