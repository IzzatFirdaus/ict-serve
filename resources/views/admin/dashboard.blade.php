{{--
  ICTServe (iServe) - Admin Reporting Dashboard
  MYDS & MyGovEA Compliant: Citizen-centric, accessible, responsive, clear structure
  Guidelines:
  - Uses MYDS typography, spacing, and color tokens (see myds-tokens.css)
  - Follows 12/8/4 grid
  - Accessible headings, focus, ARIA, and error prevention
  - All icons must be SVG (20x20, 1.5px stroke, accessible)
  - WCAG AA contrast, keyboard navigation, no color-only indicators
--}}

@extends('layouts.app')

@section('title', __('Reporting Dashboard - ICTServe (iServe)'))

@section('content')
  <a
    href="#main-content"
    class="myds-skip-link sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:bg-white focus:shadow-context-menu focus:rounded focus:p-4 focus:z-50 text-txt-black-900"
  >
    Skip to main content
  </a>
  <div id="main-content" class="myds-container py-10" tabindex="-1">
    <header class="mb-10">
      <h1
        class="myds-heading-lg text-txt-primary font-semibold mb-1"
        id="dashboard-title"
      >
        {{ __('Reporting Dashboard') }}
      </h1>
      <p class="myds-body-md text-txt-black-500">
        {{ __('Statistik dan analitik penggunaan sistem ICTServe untuk pentadbir BPM – pantau aset ICT, permohonan, serta prestasi helpdesk.') }}
      </p>
    </header>

    {{-- KPI Widgets: 12/8/4 grid, accessible, color + icon + label --}}
    <section aria-labelledby="kpi-section" class="mb-10">
      <h2 id="kpi-section" class="sr-only">Key Performance Indicators</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Equipment --}}
        <x-dashboard.kpi-widget
          title="Total Equipment"
          :value="$equipmentCount"
          icon="device"
          color="primary"
        />
        {{-- Active Loans --}}
        <x-dashboard.kpi-widget
          title="Active Loans"
          :value="$activeLoans"
          icon="clipboard-list"
          color="success"
        />
        {{-- Open Helpdesk Tickets --}}
        <x-dashboard.kpi-widget
          title="Open Helpdesk Tickets"
          :value="$openTickets"
          icon="support"
          color="warning"
        />
        {{-- Resolved Tickets --}}
        <x-dashboard.kpi-widget
          title="Resolved Tickets"
          :value="$resolvedTickets"
          icon="check-circle"
          color="info"
        />
      </div>
    </section>

    {{-- Analytics: Utilization, Loan Requests --}}
    <section aria-labelledby="analytics-section" class="mb-10">
      <h2 id="analytics-section" class="sr-only">Analytics</h2>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <article
          class="bg-bg-white rounded-lg shadow-card border border-otl-gray-200 p-6"
          aria-labelledby="equipment-utilization-title"
        >
          <h3
            id="equipment-utilization-title"
            class="myds-heading-sm font-semibold text-txt-black-900 flex items-center gap-2 mb-4"
          >
            {{-- SVG Icon: device --}}
            <svg
              width="20"
              height="20"
              fill="none"
              aria-hidden="true"
              class="text-primary-600"
            >
              <rect
                x="3"
                y="5"
                width="14"
                height="10"
                rx="2"
                stroke="currentColor"
                stroke-width="1.5"
              />
              <rect
                x="7"
                y="14"
                width="6"
                height="2"
                rx="1"
                stroke="currentColor"
                stroke-width="1.5"
              />
            </svg>
            {{ __('Equipment Utilization') }}
          </h3>
          <livewire:admin.report.equipment-utilization />
        </article>
        <article
          class="bg-bg-white rounded-lg shadow-card border border-otl-gray-200 p-6"
          aria-labelledby="loan-metrics-title"
        >
          <h3
            id="loan-metrics-title"
            class="myds-heading-sm font-semibold text-txt-black-900 flex items-center gap-2 mb-4"
          >
            {{-- SVG Icon: clipboard-list --}}
            <svg
              width="20"
              height="20"
              fill="none"
              aria-hidden="true"
              class="text-success-700"
            >
              <rect
                x="4"
                y="4"
                width="12"
                height="12"
                rx="3"
                stroke="currentColor"
                stroke-width="1.5"
              />
              <path
                d="M8 8h4M8 12h2"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
              />
            </svg>
            {{ __('Loan Request Trends') }}
          </h3>
          <livewire:admin.report.loan-metrics />
        </article>
      </div>
    </section>

    {{-- Helpdesk Performance & Export --}}
    <section aria-labelledby="helpdesk-export-section" class="mb-10">
      <h2 id="helpdesk-export-section" class="sr-only">Helpdesk & Export</h2>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <article
          class="bg-bg-white rounded-lg shadow-card border border-otl-gray-200 p-6"
          aria-labelledby="helpdesk-performance-title"
        >
          <h3
            id="helpdesk-performance-title"
            class="myds-heading-sm font-semibold text-txt-black-900 flex items-center gap-2 mb-4"
          >
            {{-- SVG Icon: support/headset --}}
            <svg
              width="20"
              height="20"
              fill="none"
              aria-hidden="true"
              class="text-warning-600"
            >
              <circle
                cx="10"
                cy="10"
                r="8"
                stroke="currentColor"
                stroke-width="1.5"
              />
              <path
                d="M6.5 13.5v-2A3.5 3.5 0 0110 8a3.5 3.5 0 013.5 3.5v2"
                stroke="currentColor"
                stroke-width="1.5"
              />
            </svg>
            {{ __('Helpdesk Performance') }}
          </h3>
          <livewire:admin.report.helpdesk-performance />
        </article>
        <article
          class="bg-bg-white rounded-lg shadow-card border border-otl-gray-200 p-6"
          aria-labelledby="export-reports-title"
        >
          <h3
            id="export-reports-title"
            class="myds-heading-sm font-semibold text-txt-black-900 flex items-center gap-2 mb-4"
          >
            {{-- SVG Icon: download --}}
            <svg
              width="20"
              height="20"
              fill="none"
              aria-hidden="true"
              class="text-primary-600"
            >
              <path
                d="M10 4v8M10 12l-3-3m3 3l3-3"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
              />
              <rect
                x="4"
                y="16"
                width="12"
                height="2"
                rx="1"
                fill="currentColor"
                class="opacity-20"
              />
            </svg>
            {{ __('Export Reports') }}
          </h3>
          <livewire:admin.report.export-widget />
        </article>
      </div>
    </section>
  </div>
@endsection
