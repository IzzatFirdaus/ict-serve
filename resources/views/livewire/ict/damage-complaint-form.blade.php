<div class="max-w-4xl mx-auto">
    @if($submitted)
        <!-- Success State -->
        <div class="bg-success-50 dark:bg-success-900/20 border border-success-200 dark:border-success-800 rounded-lg p-6 text-center">
            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-success-100 dark:bg-success-800 rounded-full">
                <svg class="w-6 h-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-success-900 dark:text-success-100 mb-2">
                Damage Report Submitted Successfully
            </h3>
            <p class="text-success-700 dark:text-success-300 mb-4">
                Your damage report has been submitted and a support ticket has been created. You will receive an email confirmation shortly.
            </p>
            <button
                wire:click="resetForm"
                class="btn-secondary"
            >
                Submit Another Report
            </button>
        </div>
    @else
        <!-- Form Header -->
        <div class="mb-6">
            <h1 class="text-h2 text-gray-900 dark:text-gray-100 mb-2">
                ICT Damage Report Form
            </h1>
            <p class="text-body-lg text-gray-600 dark:text-gray-400">
                Report damaged ICT equipment and request repair services through this secure form.
            </p>
        </div>

        <!-- Progress Indicator -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                @for($step = 1; $step <= $totalSteps; $step++)
                    <div class="flex items-center {{ $step < $totalSteps ? 'flex-1' : '' }}">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full
                            {{ $currentStep >= $step ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">
                            {{ $step }}
                        </div>
                        @if($step < $totalSteps)
                            <div class="flex-1 h-1 mx-4 {{ $currentStep > $step ? 'bg-primary-600' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                        @endif
                    </div>
                @endfor
            </div>
            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                <span>Contact Details</span>
                <span>Equipment & Damage</span>
                <span>Additional Info</span>
            </div>
        </div>

        <!-- Form Steps -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            <form wire:submit="submit">
                @if($currentStep === 1)
                    <!-- Step 1: Contact Information -->
                    <div class="space-y-6">
                        <h3 class="text-h4 text-gray-900 dark:text-gray-100 mb-4">
                            Contact Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="reporter_name" class="form-label required">
                                    Full Name
                                </label>
                                <input
                                    type="text"
                                    id="reporter_name"
                                    wire:model.blur="reporter_name"
                                    class="form-input @error('reporter_name') error @enderror"
                                    placeholder="Enter your full name"
                                >
                                @error('reporter_name')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="reporter_email" class="form-label required">
                                    Email Address
                                </label>
                                <input
                                    type="email"
                                    id="reporter_email"
                                    wire:model.blur="reporter_email"
                                    class="form-input @error('reporter_email') error @enderror"
                                    placeholder="Enter your email address"
                                >
                                @error('reporter_email')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="reporter_phone" class="form-label">
                                    Phone Number
                                </label>
                                <input
                                    type="tel"
                                    id="reporter_phone"
                                    wire:model.blur="reporter_phone"
                                    class="form-input @error('reporter_phone') error @enderror"
                                    placeholder="Enter your phone number"
                                >
                                @error('reporter_phone')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="department" class="form-label required">
                                    Department
                                </label>
                                <select
                                    id="department"
                                    wire:model.blur="department"
                                    class="form-select @error('department') error @enderror"
                                >
                                    <option value="">Select your department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept }}">{{ $dept }}</option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                @elseif($currentStep === 2)
                    <!-- Step 2: Equipment and Damage Details -->
                    <div class="space-y-6">
                        <h3 class="text-h4 text-gray-900 dark:text-gray-100 mb-4">
                            Equipment & Damage Details
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="equipment_id" class="form-label required">
                                    Equipment Item
                                </label>
                                <select
                                    id="equipment_id"
                                    wire:model.live="equipment_id"
                                    class="form-select @error('equipment_id') error @enderror"
                                >
                                    <option value="">Select equipment item</option>
                                    @foreach($equipmentItems as $equipment)
                                        <option value="{{ $equipment->id }}">
                                            {{ $equipment->name }} - {{ $equipment->model }} ({{ $equipment->asset_tag }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('equipment_id')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="damage_type" class="form-label required">
                                    Damage Type
                                </label>
                                <select
                                    id="damage_type"
                                    wire:model.blur="damage_type"
                                    class="form-select @error('damage_type') error @enderror"
                                >
                                    <option value="">Select damage type</option>
                                    @foreach($damageTypes as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('damage_type')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="form-label required">
                                Damage Description
                            </label>
                            <div class="relative">
                                <textarea
                                    id="description"
                                    wire:model.live="description"
                                    rows="4"
                                    class="form-input @error('description') error @enderror"
                                    placeholder="Please provide a detailed description of the damage or issue..."
                                ></textarea>
                                <div class="absolute bottom-2 right-2 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $descriptionLength }}/{{ $maxDescriptionLength }}
                                </div>
                            </div>
                            @error('description')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="priority" class="form-label">
                                Priority Level
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-2">
                                @foreach(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'] as $value => $label)
                                    <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 {{ $priority === $value ? 'bg-primary-50 dark:bg-primary-900/20 border-primary-300 dark:border-primary-600' : '' }}">
                                        <input
                                            type="radio"
                                            wire:model.live="priority"
                                            value="{{ $value }}"
                                            class="sr-only"
                                        >
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 border-2 rounded-full mr-3 {{ $priority === $value ? 'border-primary-600 bg-primary-600' : 'border-gray-300 dark:border-gray-600' }}">
                                                @if($priority === $value)
                                                    <div class="w-2 h-2 bg-white rounded-full mx-auto mt-0.5"></div>
                                                @endif
                                            </div>
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                @elseif($currentStep === 3)
                    <!-- Step 3: Additional Information -->
                    <div class="space-y-6">
                        <h3 class="text-h4 text-gray-900 dark:text-gray-100 mb-4">
                            Additional Information
                        </h3>

                        <div>
                            <label for="preferred_repair_date" class="form-label">
                                Preferred Repair Date
                            </label>
                            <input
                                type="date"
                                id="preferred_repair_date"
                                wire:model.blur="preferred_repair_date"
                                class="form-input @error('preferred_repair_date') error @enderror"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            >
                            @error('preferred_repair_date')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                            <p class="form-help">
                                Select a preferred date for repair (optional). We will try to accommodate your request.
                            </p>
                        </div>

                        <div>
                            <label class="form-label">
                                Damage Photos (Optional)
                            </label>
                            <div class="mt-2">
                                <div class="flex items-center justify-center w-full">
                                    <label for="photos" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-2 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                <span class="font-semibold">Click to upload</span> or drag and drop
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or JPEG (MAX. 2MB each)</p>
                                        </div>
                                        <input
                                            id="photos"
                                            type="file"
                                            wire:model.live="photos"
                                            class="hidden"
                                            multiple
                                            accept="image/*"
                                        >
                                    </label>
                                </div>

                                @if(!empty($photos))
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                        @foreach($photos as $index => $photo)
                                            <div class="relative group">
                                                <img
                                                    src="{{ $photo->temporaryUrl() }}"
                                                    alt="Damage photo {{ $index + 1 }}"
                                                    class="w-full h-24 object-cover rounded-lg border border-gray-200 dark:border-gray-600"
                                                >
                                                <button
                                                    type="button"
                                                    wire:click="removePhoto({{ $index }})"
                                                    class="absolute -top-2 -right-2 bg-danger-600 text-white rounded-full p-1 shadow-lg opacity-0 group-hover:opacity-100 transition-opacity"
                                                >
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @error('photos.*')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Summary -->
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                            <h4 class="text-h5 text-gray-900 dark:text-gray-100 mb-3">Review Your Report</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Reporter:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $reporter_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Equipment:</span>
                                    <span class="text-gray-900 dark:text-gray-100">
                                        @if($equipment_id)
                                            {{ $equipmentItems->find($equipment_id)->name ?? 'Selected Equipment' }}
                                        @else
                                            Not selected
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Damage Type:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $damage_type ?: 'Not specified' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Priority:</span>
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        {{ $priority === 'urgent' ? 'bg-danger-100 text-danger-800 dark:bg-danger-900/20 dark:text-danger-400' : '' }}
                                        {{ $priority === 'high' ? 'bg-warning-100 text-warning-800 dark:bg-warning-900/20 dark:text-warning-400' : '' }}
                                        {{ $priority === 'medium' ? 'bg-primary-100 text-primary-800 dark:bg-primary-900/20 dark:text-primary-400' : '' }}
                                        {{ $priority === 'low' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' : '' }}
                                    ">
                                        {{ ucfirst($priority) }}
                                    </span>
                                </div>
                                @if(!empty($photos))
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Photos:</span>
                                        <span class="text-gray-900 dark:text-gray-100">{{ count($photos) }} file(s) attached</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form Navigation -->
                <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        @if($currentStep > 1)
                            <button
                                type="button"
                                wire:click="previousStep"
                                class="btn-secondary"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Previous
                            </button>
                        @endif
                    </div>

                    <div>
                        @if($currentStep < $totalSteps)
                            <button
                                type="button"
                                wire:click="nextStep"
                                class="btn-primary"
                            >
                                Next
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        @else
                            <button
                                type="submit"
                                class="btn-primary {{ $loading ? 'opacity-75 cursor-not-allowed' : '' }}"
                                {{ $loading ? 'disabled' : '' }}
                            >
                                @if($loading)
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Submitting...
                                @else
                                    Submit Report
                                @endif
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
