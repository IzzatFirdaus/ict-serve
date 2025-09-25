@extends('layouts.app')

@section('content')
  <main
    class="font-inter text-sm leading-[1.6] bg-background-light dark:bg-background-dark min-h-screen p-6"
  >
    <div class="container mx-auto grid grid-cols-12 gap-6">
      <div class="col-span-12 lg:col-span-8">
        <h1 class="font-poppins text-2xl font-semibold mb-4">Maklumat MOTAC</h1>

        <section aria-labelledby="overview" class="mb-6">
          <h2 id="overview" class="font-poppins text-xl font-semibold mb-2">
            Gambaran Keseluruhan
          </h2>
          <p class="font-inter text-sm">
            Kementerian Pelancongan, Seni dan Budaya Malaysia (MOTAC)
            bertanggungjawab untuk mempromosi, mengawal selia dan membangun
            sektor pelancongan, seni dan budaya di Malaysia. Halaman ini
            menyediakan rujukan ringkas tentang dasar, garis panduan, dan cara
            untuk menghubungi kementerian.
          </p>
        </section>

        <section aria-labelledby="policies" class="mb-6">
          <h2 id="policies" class="font-poppins text-xl font-semibold mb-2">
            Dasar & Polisi
          </h2>
          <div class="space-y-3">
            <div
              class="p-4 border border-divider rounded bg-white dark:bg-dialog"
            >
              <h3 class="font-poppins text-lg font-medium">Polisi Privasi</h3>
              <p class="mt-1 font-inter text-sm">
                Maklumat peribadi dikendalikan mengikut peraturan privasi
                kerajaan. Sila rujuk
                <a href="#" class="text-primary-600 underline">
                  Dasar Privasi MOTAC
                </a>
                untuk butiran.
              </p>
            </div>

            <div
              class="p-4 border border-divider rounded bg-white dark:bg-dialog"
            >
              <h3 class="font-poppins text-lg font-medium">Keselamatan</h3>
              <p class="mt-1 font-inter text-sm">
                Kami menggunakan amalan keselamatan standard untuk melindungi
                data dan sistem. Sekiranya anda menemui kelemahan, sila hubungi
                kami melalui borang maklumat di bawah.
              </p>
            </div>

            <div
              class="p-4 border border-divider rounded bg-white dark:bg-dialog"
            >
              <h3 class="font-poppins text-lg font-medium">Penafian</h3>
              <p class="mt-1 font-inter text-sm">
                Informasi yang disediakan adalah untuk tujuan rujukan umum
                sahaja. MOTAC tidak bertanggungjawab atas sebarang keputusan
                yang dibuat berdasarkan maklumat ini.
              </p>
            </div>
          </div>
        </section>

        <section aria-labelledby="help" class="mb-6">
          <h2 id="help" class="font-poppins text-xl font-semibold mb-2">
            Bantuan & Hubungi
          </h2>
          <p class="font-inter text-sm">
            Untuk bantuan lanjut, hubungi Bahagian Pengurusan Maklumat atau
            gunakan borang maklumat rasmi kami.
          </p>

          <div class="mt-4">
            <a
              href="/contact"
              class="inline-flex items-center px-4 py-2 rounded bg-primary-600 text-white focus:outline-none focus:ring focus:ring-primary-300"
            >
              Hubungi Kami
            </a>
          </div>
        </section>
      </div>

      <aside class="col-span-12 lg:col-span-4">
        <div
          class="p-4 border border-divider rounded bg-white dark:bg-dialog mb-4"
        >
          <h3 class="font-poppins text-lg font-medium">Permintaan Maklumat</h3>
          <p class="font-inter text-sm mt-2">
            Hantar permintaan rasmi untuk dokumen atau maklumat yang tidak
            tersedia secara awam.
          </p>
          <div class="mt-3">
            <a href="/public/track" class="text-primary-600 underline">
              Buat Permintaan
            </a>
          </div>
        </div>

        <div class="p-4 border border-divider rounded bg-white dark:bg-dialog">
          <h3 class="font-poppins text-lg font-medium">Alamat & Sosial</h3>
          <p class="font-inter text-sm mt-2">
            Bahagian Pengurusan Maklumat, Kementerian Pelancongan, Seni dan
            Budaya Malaysia.
          </p>
          <ul class="mt-2 space-y-1">
            <li class="font-inter text-sm">Telefon: 03-xxxx xxxx</li>
            <li class="font-inter text-sm">
              Email:
              <a href="mailto:info@motac.gov.my" class="text-primary-600">
                info@motac.gov.my
              </a>
            </li>
          </ul>
        </div>
      </aside>
    </div>
  </main>
@endsection

