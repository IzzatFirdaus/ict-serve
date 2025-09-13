@extends('layouts.app')

@section('title', 'ICTServe Dashboard')

@section('content')
<div class="bg-bg-white">
    <span class="sr-only">Borang Aduan Kerosakan ICT</span>
    <span class="sr-only">Borang Permohonan Peminjaman Peralatan ICT</span>
    <!-- Hero Section -->
    <div class="myds-gradient-primary-br text-txt-white py-16">
        <div class="myds-container">
            <div class="text-center">
                <h1 class="myds-heading-lg mb-4">ICTServe (iServe)</h1>
                <p class="myds-body-xl text-txt-white mb-8 opacity-80">Your one-stop portal for ICT services and support</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('equipment-loan.create') }}" class="inline-flex items-center px-6 py-3 bg-bg-white text-txt-primary rounded-md myds-body-sm font-medium hover:bg-gray-50 transition-colors" role="button" aria-label="Request Equipment Loan">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Request Equipment Loan
                    </a>
                        <a href="{{ route('helpdesk.create-ticket') }}" class="inline-flex items-center px-6 py-3 bg-bg-danger-600 text-txt-white rounded-md myds-body-sm font-medium hover:bg-bg-danger-700 transition-colors" role="button" aria-label="Create Support Ticket">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Create Support Ticket
                    </a>
                        <a href="{{ route('helpdesk.my-tickets') }}" class="inline-flex items-center px-6 py-3 bg-bg-success-600 text-txt-white rounded-md myds-body-sm font-medium hover:bg-bg-success-700 transition-colors" role="button" aria-label="View My Tickets">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a2 2 0 00-2 2v6a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2v1a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" clip-rule="evenodd"></path>
                        </svg>
                        My Tickets
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    @auth
    <div class="bg-gray-50 py-12">
        <div class="myds-container">
            <h2 class="myds-heading-md text-center text-txt-black-900 mb-8">Your Activity Summary</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-bg-white rounded-lg shadow-sm border border-otl-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-primary-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-txt-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="myds-body-sm font-medium text-txt-black-700">Loan Requests</p>
                            <p class="myds-heading-md font-semibold text-txt-black-900">{{ $loanRequestsCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-bg-white rounded-lg shadow-sm border border-otl-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-danger-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-danger-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="myds-body-sm font-medium text-txt-black-700">Support Tickets</p>
                            <p class="myds-heading-md font-semibold text-txt-black-900">{{ $ticketsCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-bg-white rounded-lg shadow-sm border border-otl-gray-200 p-6" role="article" aria-labelledby="equipment-stat">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-bg-success-100 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-txt-success" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p id="equipment-stat" class="myds-body-sm font-medium text-txt-black-700">Items on Loan</p>
                            <p class="myds-heading-md font-semibold text-txt-black-900">{{ $activeLoansCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8">
                    <a href="{{ route('public.my-requests') }}" class="inline-flex items-center px-4 py-2 border border-otl-primary-300 rounded-md myds-body-sm font-medium text-txt-primary hover:bg-bg-primary-50" role="button" aria-label="View All My Requests">
                    View All My Requests
                    <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @endauth

    <!-- Services Section -->
    <div class="py-16">
        <div class="myds-container">
            <div class="text-center mb-12">
                <h2 class="myds-heading-lg text-txt-black-900 mb-4">Available Services</h2>
                <p class="myds-body-lg text-txt-black-700">Access our comprehensive ICT services and support</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" role="region" aria-labelledby="services-heading">
                <h3 id="services-heading" class="sr-only">Service Options</h3>
                <!-- Equipment Loans -->
                <div class="bg-bg-white rounded-lg shadow-sm border border-otl-gray-200 p-6 hover:shadow-md transition-shadow" role="article" aria-labelledby="equipment-loans-title">
                    <div class="w-12 h-12 bg-bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-txt-primary" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                    </div>
                    <h3 id="equipment-loans-title" class="myds-heading-xs text-txt-black-900 mb-2">Equipment Loans</h3>
                    <p class="myds-body-md text-txt-black-700 mb-4">Request to borrow ICT equipment for official use including laptops, projectors, and more.</p>
                    <a href="{{ route('equipment-loan.create') }}" class="text-txt-primary hover:text-txt-primary font-medium" role="button" aria-label="Make an Equipment Loan Request">
                        Make a Request →
                    </a>
                </div>

                <!-- Helpdesk System -->
                <div class="bg-bg-white rounded-lg shadow-sm border border-otl-gray-200 p-6 hover:shadow-md transition-shadow" role="article" aria-labelledby="helpdesk-title">
                    <div class="w-12 h-12 bg-bg-danger-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-txt-danger" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 id="helpdesk-title" class="myds-heading-xs text-txt-black-900 mb-2">Helpdesk Support</h3>
                    <p class="myds-body-md text-txt-black-700 mb-4">Create support tickets, track issues, and get technical assistance.</p>
                    <a href="{{ route('helpdesk.create-ticket') }}" class="text-txt-danger hover:text-txt-danger font-medium" role="button" aria-label="Create Support Ticket">
                        Create Ticket →
                    </a>
                </div>

                <!-- My Tickets -->
                <div class="bg-bg-white rounded-lg shadow-sm border border-otl-gray-200 p-6 hover:shadow-md transition-shadow" role="article" aria-labelledby="my-tickets-title">
                    <div class="w-12 h-12 bg-bg-success-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-txt-success" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a2 2 0 00-2 2v6a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2v1a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 id="my-tickets-title" class="myds-heading-xs text-txt-black-900 mb-2">My Support Tickets</h3>
                    <p class="myds-body-md text-txt-black-700 mb-4">View and track your support requests and helpdesk tickets.</p>
                    <a href="{{ route('helpdesk.my-tickets') }}" class="text-txt-success hover:text-txt-success font-medium" role="button" aria-label="View My Support Tickets">
                        View Tickets →
                    </a>
                </div>

                <!-- Track All Requests -->
                <div class="bg-bg-white rounded-lg shadow-sm border border-otl-gray-200 p-6 hover:shadow-md transition-shadow" role="article" aria-labelledby="all-requests-title">
                    <div class="w-12 h-12 bg-bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-txt-primary" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 id="all-requests-title" class="myds-heading-xs text-txt-black-900 mb-2">All My Requests</h3>
                    <p class="myds-body-md text-txt-black-700 mb-4">Monitor all loan requests, damage complaints, and tickets in one place.</p>
                    <a href="{{ route('public.my-requests') }}" class="text-txt-primary hover:text-txt-primary font-medium" role="button" aria-label="View All My Requests">
                        View All →
                    </a>
                </div>

                <!-- Admin Panel -->
                @auth
                @if(auth()->user()->email === 'admin@motac.gov.my')
                <div class="bg-bg-white rounded-lg shadow-sm border border-otl-gray-200 p-6 hover:shadow-md transition-shadow" role="article" aria-labelledby="admin-panel-title">
                    <div class="w-12 h-12 bg-bg-black-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-txt-black-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 id="admin-panel-title" class="myds-heading-xs text-txt-black-900 mb-2">Admin Panel</h3>
                    <p class="myds-body-md text-txt-black-700 mb-4">Manage equipment, approve requests, and oversee system operations.</p>
                    <a href="/admin" class="text-txt-black-700 hover:text-txt-black-900 font-medium" role="button" aria-label="Access Admin Panel">
                        Access Panel →
                    </a>
                </div>
                @endif
                @endauth

                <!-- Knowledge Base -->
                <div class="bg-bg-white rounded-lg shadow-sm border border-otl-gray-200 p-6 hover:shadow-md transition-shadow" role="article" aria-labelledby="knowledge-base-title">
                    <div class="w-12 h-12 bg-bg-warning-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-txt-warning" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 id="knowledge-base-title" class="myds-heading-xs text-txt-black-900 mb-2">Help & Guidelines</h3>
                    <p class="myds-body-md text-txt-black-700 mb-4">Access user guides, policies, and frequently asked questions.</p>
                    <span class="text-txt-warning font-medium" aria-label="Help section coming soon">Coming Soon</span>
                </div>

                <!-- Contact -->
                <div class="bg-bg-white rounded-lg shadow-sm border border-otl-gray-200 p-6 hover:shadow-md transition-shadow" role="article" aria-labelledby="contact-title">
                    <div class="w-12 h-12 bg-bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-txt-primary" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                        </svg>
                    </div>
                    <h3 id="contact-title" class="myds-heading-xs text-txt-black-900 mb-2">Contact ICT Team</h3>
                    <p class="myds-body-md text-txt-black-700 mb-4">Need immediate assistance? Get in touch with our ICT support team.</p>
                    <span class="text-txt-primary font-medium" aria-label="ICT Team contact extension">ext. 1234</span>
                </div>
            </div>
        </div>
    </div>

    @guest
    <!-- Login Section -->
    <div class="bg-bg-black-50 py-16">
        <div class="max-w-md mx-auto text-center px-4">
            <h2 class="myds-heading-md text-txt-black-900 mb-4">Get Started</h2>
            <p class="myds-body-md text-txt-black-700 mb-6">Sign in with your MOTAC account to access ICT services.</p>
            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-bg-primary-600 text-txt-white rounded-md myds-body-sm font-medium hover:bg-bg-primary-700 transition-colors" role="button" aria-label="Sign in to access ICT services">
                Sign In
                <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
    @endguest
</div>
@endsection
