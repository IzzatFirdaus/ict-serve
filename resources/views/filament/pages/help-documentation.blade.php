<x-filament-panels::page>
    {{-- MYDS-Compliant Help Documentation --}}
    <div class="myds-help-documentation">
        
        {{-- Introduction Panel --}}
        <div class="fi-card bg-primary-50 border-l-4 border-primary-600 mb-8">
            <div class="fi-card-content">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-heading font-medium text-primary-900 mb-2">
                            MyGOVEA Principle: Panduan dan Dokumentasi
                        </h3>
                        <p class="text-primary-700 mb-4">
                            This comprehensive help system provides user guidance and documentation as required by the MyGOVEA design principles, ensuring users can effectively utilize all system features.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid myds-12 gap-6">
            {{-- Quick Start Guide --}}
            <div class="col-span-12 lg:col-span-8">
                <div class="fi-card mb-6">
                    <div class="fi-card-header">
                        <h3 class="text-xl font-heading font-medium text-gray-900">
                            Quick Start Guide
                        </h3>
                    </div>
                    <div class="fi-card-content">
                        <div class="space-y-6">
                            {{-- Step 1 --}}
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center font-medium">1</div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 mb-2">System Login</h4>
                                    <p class="text-gray-600 mb-2">Access the system using your government credentials provided by the ICT department.</p>
                                    <ul class="text-sm text-gray-500 ml-4 list-disc">
                                        <li>Use your official government email address</li>
                                        <li>Ensure strong password compliance</li>
                                        <li>Enable two-factor authentication when available</li>
                                    </ul>
                                </div>
                            </div>

                            {{-- Step 2 --}}
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center font-medium">2</div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 mb-2">Equipment Management</h4>
                                    <p class="text-gray-600 mb-2">Manage ICT equipment loans, returns, and maintenance requests.</p>
                                    <ul class="text-sm text-gray-500 ml-4 list-disc">
                                        <li>Browse available equipment catalog</li>
                                        <li>Submit loan applications with required documentation</li>
                                        <li>Track loan status and due dates</li>
                                        <li>Report damage or maintenance issues</li>
                                    </ul>
                                </div>
                            </div>

                            {{-- Step 3 --}}
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-primary-100 text-primary-600 rounded-full flex items-center justify-center font-medium">3</div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 mb-2">Helpdesk Support</h4>
                                    <p class="text-gray-600 mb-2">Access technical support and submit helpdesk tickets for ICT issues.</p>
                                    <ul class="text-sm text-gray-500 ml-4 list-disc">
                                        <li>Create detailed support tickets</li>
                                        <li>Attach relevant screenshots or documents</li>
                                        <li>Track ticket progress and responses</li>
                                        <li>Rate support quality after resolution</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- System Features --}}
                <div class="fi-card">
                    <div class="fi-card-header">
                        <h3 class="text-xl font-heading font-medium text-gray-900">
                            System Features Overview
                        </h3>
                    </div>
                    <div class="fi-card-content">
                        <div class="grid myds-8 gap-4">
                            <div class="col-span-8 md:col-span-4">
                                <div class="p-4 border border-gray-200 rounded-m">
                                    <h4 class="font-medium text-gray-900 mb-2">Equipment Catalog</h4>
                                    <p class="text-sm text-gray-600">Browse and search available ICT equipment with detailed specifications and availability status.</p>
                                </div>
                            </div>
                            <div class="col-span-8 md:col-span-4">
                                <div class="p-4 border border-gray-200 rounded-m">
                                    <h4 class="font-medium text-gray-900 mb-2">Loan Management</h4>
                                    <p class="text-sm text-gray-600">Complete loan lifecycle management from application to return with automated notifications.</p>
                                </div>
                            </div>
                            <div class="col-span-8 md:col-span-4">
                                <div class="p-4 border border-gray-200 rounded-m">
                                    <h4 class="font-medium text-gray-900 mb-2">Damage Reporting</h4>
                                    <p class="text-sm text-gray-600">Report equipment damage with photo documentation and automatic workflow routing.</p>
                                </div>
                            </div>
                            <div class="col-span-8 md:col-span-4">
                                <div class="p-4 border border-gray-200 rounded-m">
                                    <h4 class="font-medium text-gray-900 mb-2">Tracking System</h4>
                                    <p class="text-sm text-gray-600">Track loan requests and support tickets with real-time status updates.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Help Resources --}}
            <div class="col-span-12 lg:col-span-4">
                {{-- FAQ Section --}}
                <div class="fi-card mb-6">
                    <div class="fi-card-header">
                        <h3 class="text-lg font-heading font-medium text-gray-900">
                            Frequently Asked Questions
                        </h3>
                    </div>
                    <div class="fi-card-content">
                        <div class="space-y-4">
                            <details class="group">
                                <summary class="cursor-pointer font-medium text-gray-900 hover:text-primary-600 transition-colors">
                                    How do I submit an equipment loan request?
                                </summary>
                                <p class="mt-2 text-sm text-gray-600 ml-4">
                                    Navigate to Equipment → Loan Application, fill in the required details, and submit with necessary approvals.
                                </p>
                            </details>
                            
                            <details class="group">
                                <summary class="cursor-pointer font-medium text-gray-900 hover:text-primary-600 transition-colors">
                                    What should I do if equipment is damaged?
                                </summary>
                                <p class="mt-2 text-sm text-gray-600 ml-4">
                                    Immediately report the damage through Helpdesk → Damage Report with photos and detailed description.
                                </p>
                            </details>
                            
                            <details class="group">
                                <summary class="cursor-pointer font-medium text-gray-900 hover:text-primary-600 transition-colors">
                                    How can I track my requests?
                                </summary>
                                <p class="mt-2 text-sm text-gray-600 ml-4">
                                    Use the tracking system on the public portal with your request/ticket number for real-time status updates.
                                </p>
                            </details>
                        </div>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="fi-card mb-6">
                    <div class="fi-card-header">
                        <h3 class="text-lg font-heading font-medium text-gray-900">
                            Contact ICT Support
                        </h3>
                    </div>
                    <div class="fi-card-content">
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                ict.support@motac.gov.my
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                </svg>
                                +603-8000 8000
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                Mon-Fri: 8:00 AM - 5:00 PM
                            </div>
                        </div>
                    </div>
                </div>

                {{-- System Status --}}
                <div class="fi-card">
                    <div class="fi-card-header">
                        <h3 class="text-lg font-heading font-medium text-gray-900">
                            System Status
                        </h3>
                    </div>
                    <div class="fi-card-content">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">API Services</span>
                                <span class="fi-badge success">Operational</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Database</span>
                                <span class="fi-badge success">Operational</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">File Storage</span>
                                <span class="fi-badge success">Operational</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Email Notifications</span>
                                <span class="fi-badge success">Operational</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500">Last updated: {{ now()->format('d M Y, g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>