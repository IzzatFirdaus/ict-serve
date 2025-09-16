{{--
  Borang Aduan Kerosakan ICT (ServiceDesk ICT)
  - MYDS & MyGovEA: citizen-centric, accessible, high contrast, error-prevention, responsive 12/8/4 grid.
  - Follows: MYDS Colour, Design, Icon, Develop, MyGovEA principles.
  - Usage: <x-myds.form-ict-complaint :divisions="$divisions" :damageTypes="$damageTypes" :values="old()" :errorsBag="$errors->toArray()" />
--}}

@props([
  'divisions' => [],      // [['value'=>'bpm','label'=>'Bahagian Pengurusan Maklumat'], ...]
  'damageTypes' => [],    // [['value'=>'network','label'=>'Rangkaian'], ...]
  'values' => [],
  'errorsBag' => [],
])

@php
  // Value/old helper
  $v = fn($k, $d = '') => $values[$k] ?? old($k, $d);
  // Error helper
  $err = fn($k) => $errorsBag[$k] ?? null;
@endphp

<x-myds.tokens />

<section class="bg-gray-50 dark:bg-black-100 py-8">
  <div class="myds-container">
    <div class="bg-white dark:bg-dialog radius-l shadow-card border border-divider p-6" aria-labelledby="ict-complaint-title">
      <div class="grid grid-12 sm:grid-4">
        <div class="col-span-9 sm:col-span-4">
          <h1 id="ict-complaint-title" class="text-2xl font-semibold txt-black-900 m-0 font-poppins">Borang Aduan Kerosakan ICT</h1>
          <nav aria-label="Breadcrumb" class="mt-2 mb-4">
            <ol class="flex text-sm txt-black-500 gap-2" aria-label="Jejak Laluan">
              <li><a href="{{ route('home') }}" class="myds-footer-link">Utama</a></li>
              <li><span>/</span></li>
              <li aria-current="page" class="font-medium txt-black-700">ServiceDesk ICT</li>
            </ol>
          </nav>
          <p class="txt-black-500 mt-2 text-base">Sila lengkapkan borang di bawah. Ruangan bertanda <span class="txt-danger">*</span> adalah wajib.</p>
        </div>
        <div class="col-span-3 sm:col-span-4 flex justify-end items-start">
          <span class="txt-black-500 text-sm font-inter">PK.(S).MOTAC.07.(L1)</span>
        </div>
      </div>

      <form method="POST" action="{{ route('ictserve.complaint.submit') }}" class="mt-4" novalidate autocomplete="off" aria-describedby="ict-complaint-desc">
        @csrf

        <div id="ict-complaint-desc" class="sr-only">Borang aduan kerosakan peralatan ICT dalaman MOTAC. Semua maklumat mesti diisi dengan betul.</div>

        <div class="grid grid-12 sm:grid-4 gap-4">
          <div class="col-span-6 sm:col-span-4">
            <x-myds.input
              id="nama_penuh"
              label="Nama Penuh"
              :required="true"
              :invalid="!!$err('nama_penuh')"
              :hint="$err('nama_penuh')"
              placeholder="Nama Penuh"
              :value="$v('nama_penuh')"
              autocomplete="name"
            />
          </div>
          <div class="col-span-6 sm:col-span-4">
            <x-myds.select
              id="bahagian"
              label="Bahagian"
              :required="true"
              :invalid="!!$err('bahagian')"
              :hint="$err('bahagian')"
              placeholder="Sila Pilih"
              :options="$divisions"
              :value="$v('bahagian')"
              autocomplete="organization"
            />
          </div>
          <div class="col-span-6 sm:col-span-4">
            <x-myds.input
              id="gred_jawatan"
              label="Gred Jawatan"
              placeholder="Gred Jawatan"
              :invalid="!!$err('gred_jawatan')"
              :hint="$err('gred_jawatan')"
              :value="$v('gred_jawatan')"
              autocomplete="organization-title"
            />
          </div>
          <div class="col-span-6 sm:col-span-4">
            <x-myds.input
              id="email"
              type="email"
              label="E-Mel"
              :required="true"
              placeholder="nama@motac.gov.my"
              :invalid="!!$err('email')"
              :hint="$err('email')"
              :value="$v('email')"
              autocomplete="email"
            />
          </div>
          <div class="col-span-6 sm:col-span-4">
            <x-myds.input
              id="telefon"
              type="tel"
              label="No. Telefon"
              :required="true"
              placeholder="012-3456789"
              :invalid="!!$err('telefon')"
              :hint="$err('telefon')"
              :value="$v('telefon')"
              autocomplete="tel"
            />
          </div>
          <div class="col-span-6 sm:col-span-4">
            <x-myds.select
              id="jenis_kerosakan"
              label="Jenis Kerosakan"
              :required="true"
              placeholder="Sila Pilih"
              :options="$damageTypes"
              :invalid="!!$err('jenis_kerosakan')"
              :hint="$err('jenis_kerosakan')"
              :value="$v('jenis_kerosakan')"
            />
          </div>
          <div class="col-span-12 sm:col-span-4">
            <x-myds.textarea
              id="maklumat_kerosakan"
              label="Maklumat Kerosakan"
              :required="true"
              rows="5"
              placeholder="Maklumat Kerosakan"
              :invalid="!!$err('maklumat_kerosakan')"
              :hint="$err('maklumat_kerosakan')"
              autocomplete="off"
            >{{ $v('maklumat_kerosakan') }}</x-myds.textarea>
          </div>
          <div class="col-span-12 sm:col-span-4">
            <x-myds.checkbox
              id="perakuan"
              :required="true"
              :checked="(bool)$v('perakuan')"
              label="Perakuan"
              hint="Saya memperakui dan mengesahkan bahawa semua maklumat yang diberikan di dalam eBorang Laporan Kerosakan ini adalah benar, dan bersetuju menerima perkhidmatan Bahagian Pengurusan Maklumat (BPM) berdasarkan Piagam Pelanggan sedia ada."
            />
            @if ($err('perakuan'))
              <div class="myds-hint error mt-2">{{ $err('perakuan') }}</div>
            @endif
          </div>
        </div>

        <div class="mt-4 flex gap-3">
          <x-myds.button variant="primary" type="submit">Hantar Aduan</x-myds.button>
          <x-myds.button variant="secondary" type="reset">Padam</x-myds.button>
        </div>
      </form>
    </div>
  </div>
</section>
