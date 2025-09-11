<x-filament-panels::page>
    {{-- MYDS-Compliant Dashboard Content --}}
    <div class="myds-dashboard">
        {{-- Welcome Panel - MYDS Panel Component --}}
        <div class="fi-card bg-primary-50 border-l-4 border-primary-600 mb-6">
            <div class="fi-card-content">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-heading font-medium text-primary-900 mb-2">
                            Selamat Datang ke ICT Serve
                        </h3>
                        <p class="text-primary-700 mb-4">
                            Sistem pengurusan peralatan ICT yang mematuhi Malaysia Government Design System (MYDS) dan prinsip-prinsip MyGOVEA.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="fi-badge primary">MYDS Compliant</span>
                            <span class="fi-badge success">MyGOVEA Ready</span>
                            <span class="fi-badge gray">Laravel 12</span>
                            <span class="fi-badge gray">Filament 3</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Cards - MYDS Card Component --}}
        <div class="grid myds-12 gap-6 mb-8">
            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <div class="fi-card">
                    <div class="fi-card-content text-center">
                        <div class="text-3xl font-bold text-primary-600 mb-2">{{ $this->getTotalEquipment() }}</div>
                        <div class="text-sm text-gray-600">Total Equipment</div>
                    </div>
                </div>
            </div>
            
            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <div class="fi-card">
                    <div class="fi-card-content text-center">
                        <div class="text-3xl font-bold text-success-600 mb-2">{{ $this->getActiveLoans() }}</div>
                        <div class="text-sm text-gray-600">Active Loans</div>
                    </div>
                </div>
            </div>
            
            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <div class="fi-card">
                    <div class="fi-card-content text-center">
                        <div class="text-3xl font-bold text-warning-600 mb-2">{{ $this->getOpenTickets() }}</div>
                        <div class="text-sm text-gray-600">Open Tickets</div>
                    </div>
                </div>
            </div>
            
            <div class="col-span-12 md:col-span-6 lg:col-span-3">
                <div class="fi-card">
                    <div class="fi-card-content text-center">
                        <div class="text-3xl font-bold text-danger-600 mb-2">{{ $this->getOverdueItems() }}</div>
                        <div class="text-sm text-gray-600">Overdue Items</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MyGOVEA Principles Implementation Status --}}
        <div class="grid myds-12 gap-6">
            <div class="col-span-12 lg:col-span-8">
                <div class="fi-card">
                    <div class="fi-card-header">
                        <h3 class="text-lg font-heading font-medium text-gray-900">
                            MyGOVEA Principles Implementation
                        </h3>
                    </div>
                    <div class="fi-card-content">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-success-50 rounded-m border border-success-200">
                                <div>
                                    <div class="font-medium text-success-900">Antara Muka Minimalis dan Mudah</div>
                                    <div class="text-sm text-success-700">Clean, intuitive interface design</div>
                                </div>
                                <span class="fi-badge success">Implemented</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-success-50 rounded-m border border-success-200">
                                <div>
                                    <div class="font-medium text-success-900">Seragam</div>
                                    <div class="text-sm text-success-700">Consistent MYDS theming throughout</div>
                                </div>
                                <span class="fi-badge success">Implemented</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-primary-50 rounded-m border border-primary-200">
                                <div>
                                    <div class="font-medium text-primary-900">Pencegahan Ralat</div>
                                    <div class="text-sm text-primary-700">Form validation and error prevention</div>
                                </div>
                                <span class="fi-badge primary">In Progress</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-primary-50 rounded-m border border-primary-200">
                                <div>
                                    <div class="font-medium text-primary-900">Panduan dan Dokumentasi</div>
                                    <div class="text-sm text-primary-700">Help system and user guidance</div>
                                </div>
                                <span class="fi-badge primary">In Progress</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-span-12 lg:col-span-4">
                <div class="fi-card">
                    <div class="fi-card-header">
                        <h3 class="text-lg font-heading font-medium text-gray-900">
                            MYDS Features
                        </h3>
                    </div>
                    <div class="fi-card-content">
                        <ul class="space-y-3">
                            <li class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-success-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Inter & Poppins Fonts
                            </li>
                            <li class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-success-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                MYDS Color System
                            </li>
                            <li class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-success-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                12-8-4 Grid System
                            </li>
                            <li class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-success-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Semantic Design Tokens
                            </li>
                            <li class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-success-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Motion & Accessibility
                            </li>
                            <li class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-success-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Dark Mode Support
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>