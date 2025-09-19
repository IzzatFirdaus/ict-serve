{{-- MYDS Component Test Page --}}
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MYDS Components Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-washed">
    {{-- Include MYDS Alpine Data --}}
    @include('components.myds.alpine-data')

    <div class="min-h-screen">
        {{-- Header Test --}}
        @include('components.myds.header')

        <main class="py-8">
            <x-myds.container variant="wide" centered>
                <x-myds.heading level="1" class="mb-8">MYDS Component Library Test</x-myds.heading>

                {{-- Grid System Test --}}
                <section class="mb-12">
                    <x-myds.heading level="2" class="mb-6">Grid System</x-myds.heading>
                    <x-myds.grid>
                        <x-myds.grid-item span="4" class="bg-primary-100 p-4 rounded-md">
                            <x-myds.text>Grid Item 1 (4 columns)</x-myds.text>
                        </x-myds.grid-item>
                        <x-myds.grid-item span="4" class="bg-success-100 p-4 rounded-md">
                            <x-myds.text>Grid Item 2 (4 columns)</x-myds.text>
                        </x-myds.grid-item>
                        <x-myds.grid-item span="4" class="bg-warning-100 p-4 rounded-md">
                            <x-myds.text>Grid Item 3 (4 columns)</x-myds.text>
                        </x-myds.grid-item>
                    </x-myds.grid>
                </section>

                {{-- Typography Test --}}
                <section class="mb-12">
                    <x-myds.heading level="2" class="mb-6">Typography</x-myds.heading>
                    <x-myds.heading level="1">Heading Level 1</x-myds.heading>
                    <x-myds.heading level="2">Heading Level 2</x-myds.heading>
                    <x-myds.heading level="3">Heading Level 3</x-myds.heading>
                    <x-myds.text size="lg">Large text paragraph with Inter font family.</x-myds.text>
                    <x-myds.text>Default text paragraph with normal sizing.</x-myds.text>
                    <x-myds.text size="sm" variant="muted">Small muted text for captions and hints.</x-myds.text>
                </section>

                {{-- Buttons Test --}}
                <section class="mb-12">
                    <x-myds.heading level="2" class="mb-6">Buttons</x-myds.heading>
                    <div class="flex flex-wrap gap-4 mb-4">
                        <x-myds.button variant="primary">Primary Button</x-myds.button>
                        <x-myds.button variant="secondary">Secondary Button</x-myds.button>
                        <x-myds.button variant="outline">Outline Button</x-myds.button>
                        <x-myds.button variant="ghost">Ghost Button</x-myds.button>
                        <x-myds.button variant="danger">Danger Button</x-myds.button>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <x-myds.button size="sm">Small Button</x-myds.button>
                        <x-myds.button size="default">Default Button</x-myds.button>
                        <x-myds.button size="lg">Large Button</x-myds.button>
                        <x-myds.button disabled>Disabled Button</x-myds.button>
                    </div>
                </section>

                {{-- Form Components Test --}}
                <section class="mb-12">
                    <x-myds.heading level="2" class="mb-6">Form Components</x-myds.heading>
                    <x-myds.grid>
                        <x-myds.grid-item span="6">
                            <form class="space-y-6">
                                <x-myds.input
                                    name="email"
                                    type="email"
                                    label="Email Address"
                                    placeholder="Enter your email"
                                    required
                                    help="We'll never share your email with anyone else."
                                />

                                <x-myds.input
                                    name="error-example"
                                    label="Input with Error"
                                    placeholder="This has an error"
                                    error="This field has an error message"
                                />

                                <x-myds.select
                                    name="country"
                                    label="Country"
                                    :options="['my' => 'Malaysia', 'sg' => 'Singapore', 'th' => 'Thailand']"
                                    placeholder="Choose country"
                                    required
                                />

                                <x-myds.textarea
                                    name="description"
                                    label="Description"
                                    placeholder="Enter description..."
                                    maxlength="200"
                                    help="Describe your request in detail"
                                />

                                <div class="flex space-x-6">
                                    <x-myds.checkbox
                                        name="terms"
                                        label="I agree to the terms and conditions"
                                        required
                                    />
                                </div>

                                <div class="space-y-3">
                                    <x-myds.text weight="medium">Preferred Contact Method:</x-myds.text>
                                    <x-myds.radio name="contact" value="email" label="Email" />
                                    <x-myds.radio name="contact" value="phone" label="Phone" checked />
                                    <x-myds.radio name="contact" value="sms" label="SMS" />
                                </div>
                            </form>
                        </x-myds.grid-item>
                        <x-myds.grid-item span="6">
                            {{-- Progress --}}
                            <x-myds.heading level="2" class="mb-4">Progress</x-myds.heading>
                            <x-myds.progress value="65" max="100" label="Upload Progress" class="mb-6" />
                        </x-myds.grid-item>
                    </x-myds.grid>
                </section>

                {{-- Alerts Section --}}
                <section class="mb-12">
                    <x-myds.grid>
                        <x-myds.grid-item span="6">
                            {{-- Alerts --}}
                            <x-myds.heading level="2" class="mb-4">Alerts</x-myds.heading>

                            <x-myds.alert variant="info" class="mb-4">
                                <strong>Information:</strong> This is an informational alert message.
                            </x-myds.alert>

                            <x-myds.alert variant="success" class="mb-4">
                                <strong>Success:</strong> Your form has been submitted successfully!
                            </x-myds.alert>

                            <x-myds.alert variant="warning" class="mb-4">
                                <strong>Warning:</strong> Please review your information before submitting.
                            </x-myds.alert>

                            <x-myds.alert variant="danger">
                                <strong>Error:</strong> There was an error processing your request.
                            </x-myds.alert>
                        </x-myds.grid-item>
                    </x-myds.grid>
                </section>

                {{-- Card Components Test --}}
                <section class="mb-12">
                    <x-myds.heading level="2" class="mb-6">Cards</x-myds.heading>
                    <x-myds.grid>
                        <x-myds.grid-item span="4">
                            <x-myds.card>
                                <x-myds.heading level="4">Basic Card</x-myds.heading>
                                <x-myds.text>This is a basic card component with default styling.</x-myds.text>
                            </x-myds.card>
                        </x-myds.grid-item>
                        <x-myds.grid-item span="4">
                            <x-myds.card variant="elevated">
                                <x-myds.heading level="4">Elevated Card</x-myds.heading>
                                <x-myds.text>This card has elevated styling with more shadow.</x-myds.text>
                            </x-myds.card>
                        </x-myds.grid-item>
                        <x-myds.grid-item span="4">
                            <x-myds.card variant="outlined">
                                <x-myds.heading level="4">Outlined Card</x-myds.heading>
                                <x-myds.text>This card has outlined styling with borders.</x-myds.text>
                            </x-myds.card>
                        </x-myds.grid-item>
                    </x-myds.grid>
                </section>

                {{-- Badges Test --}}
                <section class="mb-12">
                    <x-myds.heading level="2" class="mb-6">Badges</x-myds.heading>
                    <div class="flex flex-wrap gap-2 items-center">
                        <x-myds.badge variant="primary">Primary</x-myds.badge>
                        <x-myds.badge variant="secondary">Secondary</x-myds.badge>
                        <x-myds.badge variant="success">Success</x-myds.badge>
                        <x-myds.badge variant="warning">Warning</x-myds.badge>
                        <x-myds.badge variant="danger">Danger</x-myds.badge>
                        <x-myds.badge variant="info">Info</x-myds.badge>
                        <x-myds.badge size="sm">Small</x-myds.badge>
                        <x-myds.badge size="lg">Large</x-myds.badge>
                    </div>
                </section>

                {{-- Tabs Test --}}
                <section class="mb-12">
                    <x-myds.heading level="2" class="mb-6">Tabs</x-myds.heading>
                    <x-myds.tabs :tabs="[
                        ['key' => 'tab1', 'label' => 'First Tab', 'content' => '<p>This is the content of the first tab.</p>'],
                        ['key' => 'tab2', 'label' => 'Second Tab', 'content' => '<p>This is the content of the second tab.</p>'],
                        ['key' => 'tab3', 'label' => 'Third Tab', 'content' => '<p>This is the content of the third tab.</p>']
                    ]" activeTab="tab1" />
                </section>

                {{-- Table Test --}}
                <section class="mb-12">
                    <x-myds.heading level="2" class="mb-6">Table</x-myds.heading>
                    <x-myds.table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Ahmad Ibrahim</td>
                                <td>ahmad@motac.gov.my</td>
                                <td>Administrator</td>
                                <td><x-myds.badge variant="success">Active</x-myds.badge></td>
                                <td>
                                    <x-myds.button size="sm" variant="outline">Edit</x-myds.button>
                                </td>
                            </tr>
                            <tr>
                                <td>Siti Nurhaliza</td>
                                <td>siti@motac.gov.my</td>
                                <td>User</td>
                                <td><x-myds.badge variant="warning">Pending</x-myds.badge></td>
                                <td>
                                    <x-myds.button size="sm" variant="outline">Edit</x-myds.button>
                                </td>
                            </tr>
                        </tbody>
                    </x-myds.table>
                </section>

                {{-- Breadcrumbs Test --}}
                <section class="mb-12">
                    <x-myds.heading level="2" class="mb-6">Breadcrumbs</x-myds.heading>
                    <x-myds.breadcrumb :items="[
                        ['label' => 'Home', 'url' => '/'],
                        ['label' => 'ServiceDesk ICT', 'url' => '/servicedesk'],
                        ['label' => 'Equipment Loans', 'url' => '/loans'],
                        ['label' => 'New Request']
                    ]" />
                </section>

                {{-- Interactive Components Test --}}
                <section class="mb-12">
                    <x-myds.heading level="2" class="mb-6">Interactive Components</x-myds.heading>
                    <div class="space-y-6">
                        {{-- Dropdown Test --}}
                        <div>
                            <x-myds.text weight="medium" class="mb-2">Dropdown Menu:</x-myds.text>
                            <x-myds.dropdown label="Actions">
                                <x-myds.dropdown-item href="#" icon="🔍">View Details</x-myds.dropdown-item>
                                <x-myds.dropdown-item href="#" icon="✏️">Edit</x-myds.dropdown-item>
                                <x-myds.dropdown-item href="#" icon="📄">Download</x-myds.dropdown-item>
                                <x-myds.dropdown-item href="#" icon="🗑️" variant="danger">Delete</x-myds.dropdown-item>
                            </x-myds.dropdown>
                        </div>

                        {{-- Tooltip Test --}}
                        <div>
                            <x-myds.text weight="medium" class="mb-2">Tooltip:</x-myds.text>
                            <x-myds.tooltip message="This is a helpful tooltip with additional information.">
                                <x-myds.button>Hover for tooltip</x-myds.button>
                            </x-myds.tooltip>
                        </div>

                        {{-- Modal Test --}}
                        <div x-data="modal()">
                            <x-myds.text weight="medium" class="mb-2">Modal:</x-myds.text>
                            <x-myds.button @click="show()">Open Modal</x-myds.button>

                            <x-myds.modal x-show="open" @click.away="hide()">
                                <x-myds.heading level="3" class="mb-4">Test Modal</x-myds.heading>
                                <x-myds.text class="mb-6">This is a modal dialog for testing purposes.</x-myds.text>
                                <div class="flex justify-end space-x-3">
                                    <x-myds.button variant="outline" @click="hide()">Cancel</x-myds.button>
                                    <x-myds.button @click="hide()">Confirm</x-myds.button>
                                </div>
                            </x-myds.modal>
                        </div>
                    </div>
                </section>
            </x-myds.container>
        </main>

        {{-- Footer Test --}}
        @include('components.myds.footer')
    </div>
</body>
</html>
