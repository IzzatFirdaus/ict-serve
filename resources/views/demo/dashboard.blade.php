<!DOCTYPE html>
<html lang="ms">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Dashboard ICTServe (iServe)</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/css/pages/demo-dashboard.css')
        box-shadow:
          0 10px 15px -3px rgba(0, 0, 0, 0.1),
          0 4px 6px -2px rgba(0, 0, 0, 0.05);
      }

      .rounded-lg {
        border-radius: 0.5rem;
      }

      .p-6 {
        padding: 1.5rem;
      }

      .mt-6 {
        margin-top: 1.5rem;
      }

      .mb-4 {
        margin-bottom: 1rem;
      }

      .text-2xl {
        font-size: 1.5rem;
        line-height: 2rem;
      }

      .font-semibold {
        font-weight: 600;
      }

      .grid {
        display: grid;
      }

      .grid-cols-1 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
      }

      .grid-cols-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
      }

      .gap-6 {
        gap: 1.5rem;
      }

      .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
      }

      @media (min-width: 768px) {
        .md\\:grid-cols-2 {
          grid-template-columns: repeat(2, minmax(0, 1fr));
        }
      }

      @media (min-width: 1024px) {
        .lg\\:grid-cols-4 {
          grid-template-columns: repeat(4, minmax(0, 1fr));
        }
      }
    </style>
  </head>
  <body>
    <div id="app">
      <!-- Use ICTServe Layout Component -->
      <x-ictserve.layout>
        <div class="container mt-6">
          <h1 class="font-poppins text-2xl font-semibold mb-4">
            Dashboard ICTServe (iServe)
          </h1>

          <!-- Statistics Cards -->
          <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6"
          >
            <x-ictserve.widgets.stat-card
              title="Jumlah Pinjaman"
              value="142"
              icon="document"
              color="primary"
              trend="+12%"
              description="Berbanding bulan lalu"
            />

            <x-ictserve.widgets.stat-card
              title="Pinjaman Aktif"
              value="28"
              icon="clock"
              color="warning"
              trend="+5%"
              description="Sedang dalam penggunaan"
            />

            <x-ictserve.widgets.stat-card
              title="Tiket Helpdesk"
              value="37"
              icon="support"
              color="danger"
              trend="-8%"
              description="Tiket terbuka"
            />

            <x-ictserve.widgets.stat-card
              title="Pengguna Aktif"
              value="89"
              icon="user-group"
              color="success"
              trend="+15%"
              description="Pengguna bulan ini"
            />
          </div>

          <!-- Quick Actions -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <x-ictserve.widgets.service-card
              title="Pinjaman Peralatan ICT"
              description="Mohon pinjaman laptop, projektor dan peralatan ICT lain untuk kerja rasmi"
              icon="laptop"
              color="primary"
              buttonText="Buat Permohonan"
              link="/loans/create"
            />

            <x-ictserve.widgets.service-card
              title="Helpdesk ICT"
              description="Laporkan masalah teknikal atau minta bantuan sokongan ICT"
              icon="support"
              color="secondary"
              buttonText="Buat Laporan"
              link="/helpdesk/create"
            />
          </div>

          <!-- Recent Activities -->
          <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="font-poppins text-xl font-semibold mb-4">
              Aktiviti Terkini
            </h2>

            <x-ictserve.widgets.activity-feed
              :activities="[
                [
                    'type' => 'loan_approved',
                    'title' => 'Permohonan pinjaman laptop diluluskan',
                    'description' => 'Permohonan #LP2024001 telah diluluskan oleh penyelia',
                    'timestamp' => '2 jam yang lalu',
                    'icon' => 'check-circle',
                    'color' => 'success'
                ],
                [
                    'type' => 'ticket_created',
                    'title' => 'Tiket helpdesk baharu dibuat',
                    'description' => 'Masalah printer di Tingkat 3 - Tiket #HD2024052',
                    'timestamp' => '3 jam yang lalu',
                    'icon' => 'document-add',
                    'color' => 'primary'
                ],
                [
                    'type' => 'equipment_returned',
                    'title' => 'Peralatan dipulangkan',
                    'description' => 'Laptop ASUS #LT001 telah dipulangkan dengan selamat',
                    'timestamp' => '5 jam yang lalu',
                    'icon' => 'arrow-incoming',
                    'color' => 'warning'
                ]
              ]"
            />
          </div>
        </div>
      </x-ictserve.layout>
    </div>

    @vite('resources/js/pages/demo-dashboard.js')
    @vite('resources/css/pages/demo-dashboard.css')
  </body>
</html>
