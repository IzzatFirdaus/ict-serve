<!-- MYDS Header Navigation -->
<header class="bg-white border-b border-otl-divider shadow-sm">
    <div class="myds-container">
        <div class="flex items-center justify-between h-16">
            <!-- Logo and Navigation -->
            <div class="flex items-center space-x-8">
                <!-- MOTAC Logo -->
                <div class="flex-shrink-0">
                    <img class="h-8 w-auto" src="/images/motac-logo.png" alt="MOTAC Intranet" loading="lazy">
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex space-x-6" aria-label="Main navigation">
                    <a href="/" class="text-txt-black-700 hover:text-txt-primary px-3 py-2 text-sm font-medium transition-colors">
                        Utama
                    </a>
                    <a href="/informasi" class="text-txt-black-700 hover:text-txt-primary px-3 py-2 text-sm font-medium transition-colors">
                        Informasi
                    </a>
                    <a href="/muat-turun" class="text-txt-black-700 hover:text-txt-primary px-3 py-2 text-sm font-medium transition-colors">
                        Muat Turun
                    </a>
                    <a href="/direktori" class="text-txt-black-700 hover:text-txt-primary px-3 py-2 text-sm font-medium transition-colors">
                        Direktori
                    </a>

                    <!-- ServiceDesk ICT Dropdown -->
                    <div class="relative group">
                        <button class="text-txt-primary font-semibold px-3 py-2 text-sm transition-colors border-b-2 border-primary-600 flex items-center">
                            ServiceDesk ICT
                            <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-64 bg-white rounded-md shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="py-2">
                                <a href="{{ route('public.loan-request') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Equipment Loan Request
                                    </div>
                                </a>
                                <a href="{{ route('public.damage-complaint.guest') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-danger-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Report Damage/Issues
                                    </div>
                                </a>
                                <a href="{{ route('public.my-requests') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a2 2 0 00-2 2v6a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2v1a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" clip-rule="evenodd"></path>
                                        </svg>
                                        My Requests
                                    </div>
                                </a>
                                <div class="border-t border-gray-100 my-2"></div>
                                <a href="/admin" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Admin Panel
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="/webmail" class="text-txt-black-700 hover:text-txt-primary px-3 py-2 text-sm font-medium transition-colors">
                        Webmail MyGovUC 3.0
                    </a>
                    <a href="/my-integriti" class="text-txt-black-700 hover:text-txt-primary px-3 py-2 text-sm font-medium transition-colors">
                        MY Integriti
                    </a>
                </nav>
            </div>

            <!-- Search and Mobile Menu -->
            <div class="flex items-center space-x-4">
                <!-- Search Icon -->
                <button type="button" class="text-txt-black-700 hover:text-txt-primary p-2 rounded-[var(--radius-m)] hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary" aria-label="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Mobile menu button -->
                <button type="button" class="md:hidden text-txt-black-700 hover:text-txt-primary p-2 rounded-[var(--radius-m)] hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary" aria-label="Open main menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu (hidden by default) -->
    <div class="md:hidden border-t border-otl-divider bg-gray-50" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="/" class="block px-3 py-2 text-sm font-medium text-txt-black-700 hover:text-txt-primary hover:bg-white rounded-[var(--radius-m)] transition-colors">Utama</a>
            <a href="/informasi" class="block px-3 py-2 text-sm font-medium text-txt-black-700 hover:text-txt-primary hover:bg-white rounded-[var(--radius-m)] transition-colors">Informasi</a>
            <a href="/muat-turun" class="block px-3 py-2 text-sm font-medium text-txt-black-700 hover:text-txt-primary hover:bg-white rounded-[var(--radius-m)] transition-colors">Muat Turun</a>
            <a href="/direktori" class="block px-3 py-2 text-sm font-medium text-txt-black-700 hover:text-txt-primary hover:bg-white rounded-[var(--radius-m)] transition-colors">Direktori</a>

            <!-- ServiceDesk ICT Section -->
            <div class="bg-primary-50 rounded-[var(--radius-m)] p-2 mt-2">
                <div class="text-sm font-semibold text-txt-primary px-1 py-1">ServiceDesk ICT</div>
                <a href="{{ route('public.loan-request') }}" class="block px-3 py-2 text-sm text-txt-black-700 hover:text-txt-primary hover:bg-white rounded-[var(--radius-s)] transition-colors">Equipment Loan Request</a>
                <a href="{{ route('public.damage-complaint.guest') }}" class="block px-3 py-2 text-sm text-txt-black-700 hover:text-txt-primary hover:bg-white rounded-[var(--radius-s)] transition-colors">Report Damage/Issues</a>
                <a href="{{ route('public.my-requests') }}" class="block px-3 py-2 text-sm text-txt-black-700 hover:text-txt-primary hover:bg-white rounded-[var(--radius-s)] transition-colors">My Requests</a>
                <a href="/admin" class="block px-3 py-2 text-sm text-txt-black-700 hover:text-txt-primary hover:bg-white rounded-[var(--radius-s)] transition-colors">Admin Panel</a>
            </div>

            <a href="/webmail" class="block px-3 py-2 text-sm font-medium text-txt-black-700 hover:text-txt-primary hover:bg-white rounded-[var(--radius-m)] transition-colors">Webmail MyGovUC 3.0</a>
            <a href="/my-integriti" class="block px-3 py-2 text-sm font-medium text-txt-black-700 hover:text-txt-primary hover:bg-white rounded-[var(--radius-m)] transition-colors">MY Integriti</a>
        </div>
    </div>
</header>
