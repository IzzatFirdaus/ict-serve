@extends('layouts.app')

@section('title', 'Reporting Dashboard - ICT Serve')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-primary-700 mb-6">{{ __('Reporting Dashboard') }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- KPI Widgets -->
        <x-dashboard.kpi-widget title="Total Equipment" :value="$equipmentCount" icon="device" color="primary" />
        <x-dashboard.kpi-widget title="Active Loans" :value="$activeLoans" icon="clipboard-list" color="success" />
        <x-dashboard.kpi-widget title="Open Helpdesk Tickets" :value="$openTickets" icon="support" color="warning" />
        <x-dashboard.kpi-widget title="Resolved Tickets" :value="$resolvedTickets" icon="check-circle" color="info" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Equipment Utilization Analytics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Equipment Utilization') }}</h2>
            <livewire:admin.report.equipment-utilization />
        </div>
        <!-- Loan Request Metrics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Loan Request Trends') }}</h2>
            <livewire:admin.report.loan-metrics />
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Helpdesk Performance Tracking -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Helpdesk Performance') }}</h2>
            <livewire:admin.report.helpdesk-performance />
        </div>
        <!-- Export Functionality -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('Export Reports') }}</h2>
            <livewire:admin.report.export-widget />
        </div>
    </div>
</div>
@endsection
