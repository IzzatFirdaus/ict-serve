@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@extends('layouts.app')

@section('content')
<div class="myds-container max-w-md mx-auto py-10">
    <div class="bg-bg-white-0 border border-otl-gray-200 rounded-radius-l shadow-context-menu p-6">
        <h1 class="myds-heading text-heading-xs font-semibold text-txt-black-900 mb-1">Create an account</h1>
        <p class="text-body-sm text-txt-black-600 mb-6">Register to access iServe</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-4" novalidate>
            @csrf
            <x-myds.input name="name" label="Full Name" :value="old('name')" required autocomplete="name" />
            <x-myds.input name="email" type="email" label="Email Address" :value="old('email')" required autocomplete="email" />
            <x-myds.input name="password" type="password" label="Password" required autocomplete="new-password" />
            <x-myds.input name="password_confirmation" type="password" label="Confirm Password" required autocomplete="new-password" />
            <x-myds.button type="submit" variant="primary" class="w-full">Create account</x-myds.button>
        </form>
    </div>
</div>
@endsection
