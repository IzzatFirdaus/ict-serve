@extends('layouts.public')

@section('title', 'Ticket Submitted Successfully - ICT Serve')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
        <!-- Success Icon -->
        <div class="w-16 h-16 bg-success-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <!-- Success Message -->
        <h1 class="text-2xl font-bold text-gray-900 mb-4">
            {{ __('Ticket Submitted Successfully!') }}
        </h1>

        @if(session('ticket_number'))
        <div class="bg-primary-50 border border-primary-200 rounded-lg p-4 mb-6">
            <p class="text-primary-800 font-medium mb-2">{{ __('Your Ticket Number:') }}</p>
            <p class="text-2xl font-bold text-primary-900 font-mono tracking-wider">
                {{ session('ticket_number') }}
            </p>
            <p class="text-sm text-primary-700 mt-2">
                {{ __('Please save this number for your records and future reference.') }}
            </p>
        </div>
        @endif

        <!-- Next Steps -->
        <div class="text-left bg-gray-50 rounded-lg p-6 mb-6">
            <h2 class="font-semibold text-gray-900 mb-3">{{ __('What happens next?') }}</h2>
            <ol class="space-y-2 text-sm text-gray-700">
                <li class="flex items-start">
                    <span class="inline-flex items-center justify-center w-5 h-5 bg-primary-100 text-primary-800 rounded-full text-xs font-medium mr-3 mt-0.5 flex-shrink-0">1</span>
                    <span>{{ __('You will receive an email confirmation shortly with your ticket details.') }}</span>
                </li>
                <li class="flex items-start">
                    <span class="inline-flex items-center justify-center w-5 h-5 bg-primary-100 text-primary-800 rounded-full text-xs font-medium mr-3 mt-0.5 flex-shrink-0">2</span>
                    <span>{{ __('Our ICT support team will review and prioritize your ticket.') }}</span>
                </li>
                <li class="flex items-start">
                    <span class="inline-flex items-center justify-center w-5 h-5 bg-primary-100 text-primary-800 rounded-full text-xs font-medium mr-3 mt-0.5 flex-shrink-0">3</span>
                    <span>{{ __('A technician will be assigned and will contact you for any additional information needed.') }}</span>
                </li>
                <li class="flex items-start">
                    <span class="inline-flex items-center justify-center w-5 h-5 bg-primary-100 text-primary-800 rounded-full text-xs font-medium mr-3 mt-0.5 flex-shrink-0">4</span>
                    <span>{{ __('You will receive email updates as your ticket progresses through resolution.') }}</span>
                </li>
            </ol>
        </div>

        <!-- Priority-based SLA Information -->
        <x-alert type="info" class="text-left mb-6">
            <p class="font-medium mb-2">{{ __('Response Time Expectations:') }}</p>
            <ul class="list-disc list-inside space-y-1 text-sm">
                <li><span class="font-medium text-danger-700">{{ __('Urgent:') }}</span> {{ __('Within 2-4 hours') }}</li>
                <li><span class="font-medium text-warning-700">{{ __('High:') }}</span> {{ __('Within 8-12 hours') }}</li>
                <li><span class="font-medium text-primary-700">{{ __('Medium:') }}</span> {{ __('Within 1-2 business days') }}</li>
                <li><span class="font-medium text-gray-700">{{ __('Low:') }}</span> {{ __('Within 3-5 business days') }}</li>
            </ul>
        </x-alert>

        <!-- Important Notes -->
        <x-alert type="warning" class="text-left mb-6">
            <p class="font-medium mb-2">{{ __('Important Notes:') }}</p>
            <ul class="list-disc list-inside space-y-1 text-sm">
                <li>{{ __('Please check your email (including spam folder) for updates') }}</li>
                <li>{{ __('You can track your ticket status using the ticket number above') }}</li>
                <li>{{ __('For urgent issues, our emergency hotline is available 24/7: +60 3-xxxx xxxx') }}</li>
                <li>{{ __('Do not create duplicate tickets for the same issue') }}</li>
            </ul>
        </x-alert>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('public.track') }}"
               class="inline-flex items-center justify-center px-4 py-2 bg-primary-600 text-white rounded-md text-sm font-medium hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                {{ __('Track Ticket Status') }}
            </a>

            <a href="{{ route('public.helpdesk.create') }}"
               class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('Report Another Issue') }}
            </a>

            <a href="{{ url('/') }}"
               class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                {{ __('Back to Home') }}
            </a>
        </div>

        <!-- Contact Information -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-600 mb-2">{{ __('Need immediate help?') }}</p>
            <div class="text-sm text-gray-700 space-y-1">
                <p><span class="font-medium">{{ __('Emergency Hotline:') }}</span> +60 3-xxxx xxxx (24/7)</p>
                <p><span class="font-medium">{{ __('Email:') }}</span> ict-support@example.gov.my</p>
                <p><span class="font-medium">{{ __('Office Hours:') }}</span> {{ __('Monday - Friday, 8:00 AM - 5:00 PM') }}</p>
                <p><span class="font-medium">{{ __('Location:') }}</span> {{ __('ICT Department, Ground Floor, Block A') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
