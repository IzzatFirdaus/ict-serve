{{--
  Loan Applications Index — MYDS, bilingual, accessible, Livewire-powered
--}}
@extends('layouts.app')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h1 class="font-poppins text-2xl font-semibold text-black-900">
      {{ __('messages.loan_applications_title') }}
    </h1>
    <x-myds.button :href="route('loan-applications.create')" variant="primary">
      {{ __('messages.add_loan_application') }}
    </x-myds.button>
  </div>

  <livewire:loan-applications-table />
@endsection
