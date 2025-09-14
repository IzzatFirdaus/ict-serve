@props([
    'status' => '',
    'type' => 'default', // ticket, loan, equipment, user, priority
    'size' => 'medium', // small, medium, large
    'showIcon' => true,
])

@php
    // Define status configurations for different types
    $statusConfigs = [
        'ticket' => [
            'open' => ['color' => 'warning', 'text' => 'Terbuka', 'icon' => 'clock'],
            'in_progress' => ['color' => 'primary', 'text' => 'Dalam Proses', 'icon' => 'arrow-right'],
            'pending' => ['color' => 'warning', 'text' => 'Menunggu', 'icon' => 'pause'],
            'resolved' => ['color' => 'success', 'text' => 'Diselesaikan', 'icon' => 'check'],
            'closed' => ['color' => 'black', 'text' => 'Ditutup', 'icon' => 'x'],
            'cancelled' => ['color' => 'danger', 'text' => 'Dibatalkan', 'icon' => 'x-circle'],
        ],
        'loan' => [
            'pending_support' => ['color' => 'warning', 'text' => 'Menunggu Sokongan', 'icon' => 'clock'],
            'approved' => ['color' => 'success', 'text' => 'Diluluskan', 'icon' => 'check'],
            'rejected' => ['color' => 'danger', 'text' => 'Ditolak', 'icon' => 'x'],
            'issued' => ['color' => 'primary', 'text' => 'Dikeluarkan', 'icon' => 'arrow-right'],
            'returned' => ['color' => 'success', 'text' => 'Dipulangkan', 'icon' => 'check-circle'],
            'overdue' => ['color' => 'danger', 'text' => 'Tertunggak', 'icon' => 'warning'],
            'completed' => ['color' => 'black', 'text' => 'Selesai', 'icon' => 'check-circle'],
        ],
        'equipment' => [
            'available' => ['color' => 'success', 'text' => 'Tersedia', 'icon' => 'check'],
            'on_loan' => ['color' => 'warning', 'text' => 'Dipinjam', 'icon' => 'arrow-right'],
            'under_maintenance' => ['color' => 'danger', 'text' => 'Dalam Penyelenggaraan', 'icon' => 'gear'],
            'retired' => ['color' => 'black', 'text' => 'Bersara', 'icon' => 'x'],
            'lost' => ['color' => 'danger', 'text' => 'Hilang', 'icon' => 'warning'],
            'damaged' => ['color' => 'danger', 'text' => 'Rosak', 'icon' => 'warning'],
        ],
        'user' => [
            'active' => ['color' => 'success', 'text' => 'Aktif', 'icon' => 'check'],
            'inactive' => ['color' => 'black', 'text' => 'Tidak Aktif', 'icon' => 'x'],
            'suspended' => ['color' => 'danger', 'text' => 'Digantung', 'icon' => 'warning'],
            'pending' => ['color' => 'warning', 'text' => 'Menunggu', 'icon' => 'clock'],
        ],
        'priority' => [
            'low' => ['color' => 'success', 'text' => 'Rendah', 'icon' => 'arrow-down'],
            'medium' => ['color' => 'warning', 'text' => 'Sederhana', 'icon' => 'minus'],
            'high' => ['color' => 'danger', 'text' => 'Tinggi', 'icon' => 'arrow-up'],
            'urgent' => ['color' => 'danger', 'text' => 'Segera', 'icon' => 'warning'],
        ],
        'default' => [
            'active' => ['color' => 'success', 'text' => 'Aktif', 'icon' => 'check'],
            'inactive' => ['color' => 'black', 'text' => 'Tidak Aktif', 'icon' => 'x'],
            'pending' => ['color' => 'warning', 'text' => 'Menunggu', 'icon' => 'clock'],
            'completed' => ['color' => 'success', 'text' => 'Selesai', 'icon' => 'check-circle'],
            'cancelled' => ['color' => 'danger', 'text' => 'Dibatalkan', 'icon' => 'x-circle'],
        ]
    ];

    // Get configuration for the current type and status
    $config = $statusConfigs[$type][$status] ?? $statusConfigs['default'][$status] ?? [
        'color' => 'black',
        'text' => ucfirst(str_replace('_', ' ', $status)),
        'icon' => 'info'
    ];

    // Size configurations
    $sizeClasses = [
        'small' => 'px-2 py-1 text-xs',
        'medium' => 'px-2.5 py-1 text-xs',
        'large' => 'px-3 py-1.5 text-sm',
    ];

    $iconSizes = [
        'small' => '12',
        'medium' => '14',
        'large' => '16',
    ];

    // Build CSS classes
    $colorClasses = "bg-{$config['color']}-100 text-{$config['color']}-700 border-{$config['color']}-200";
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['medium'];
    $iconSize = $iconSizes[$size] ?? $iconSizes['medium'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full border font-medium font-inter {$colorClasses} {$sizeClass}"]) }}>
    @if($showIcon)
        <x-myds.icon name="{{ $config['icon'] }}" size="{{ $iconSize }}" class="mr-1" />
    @endif
    {{ $config['text'] }}
</span>
