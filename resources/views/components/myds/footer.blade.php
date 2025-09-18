{{--
  MYDS Footer for ICTServe (iServe)
  - Compliant with MYDS standards (Design, Develop, Colour, Icons) and MyGovEA "Berpaksikan Rakyat"
  - Responsive 12/8/4 grid, accessible, keyboard navigable, high contrast, supports dark mode
  - Includes official MOTAC social media links (Facebook, X/Twitter, Instagram, YouTube) per MYDS-Icons-Overview.md
  - Semantic roles and aria-labels for a11y; clear Malay labelling
--}}
@php
  // Official MOTAC social media URLs as of Sep 2025 (verify/update YouTube channel if needed)
  $motac_social = [
    [
      'name' => 'Facebook',
      'icon' => 'facebook',
      'href' => 'https://www.facebook.com/MyMOTAC/',
      'aria' => 'Facebook MyMOTAC Malaysia'
    ],
    [
      'name' => 'X',
      'icon' => 'x', // Use 'x' if available, fallback to 'twitter' if not
      'href' => 'https://twitter.com/MyMOTAC',
      'aria' => 'X / Twitter MyMOTAC Malaysia'
    ],
    [
      'name' => 'Instagram',
      'icon' => 'instagram',
      'href' => 'https://www.instagram.com/mymotac',
      'aria' => 'Instagram MyMOTAC Malaysia'
    ],
    [
      'name' => 'YouTube',
      'icon' => 'youtube',
      'href' => 'https://www.youtube.com/@MyMOTAC',
      'aria' => 'YouTube MyMOTAC Malaysia'
    ],
  ];
@endphp

<x-myds.tokens />

<footer class="bg-black-50 border border-divider mt-8" aria-label="Maklumat Footer">
  <div class="myds-container py-4">
    <div class="grid grid-cols-12 md:grid-cols-8 sm:grid-cols-4 gap-4 items-center">
      {{-- Left: BPM Logo --}}
      <div class="col-span-3 md:col-span-2 sm:col-span-4 flex items-center gap-3">
        <img src="/img/bpm-logo.svg" alt="Logo Bahagian Pengurusan Maklumat MOTAC" height="40" width="40" loading="lazy" decoding="async" />
      </div>
      {{-- Center: Copyright --}}
      <div class="col-span-6 md:col-span-4 sm:col-span-4 txt-black-700 text-sm text-center font-inter">
        © {{ date('Y') }} Hakcipta Terpelihara Bahagian Pengurusan Maklumat (BPM), Kementerian Pelancongan, Seni dan Budaya Malaysia.
      </div>
      {{-- Right: Social Media --}}
      <div class="col-span-3 md:col-span-2 sm:col-span-4 flex justify-end gap-3 min-w-0 myds-footer-social" aria-label="Pautan Media Sosial MOTAC">
        @foreach($motac_social as $soc)
          <a
            href="{{ $soc['href'] }}"
            target="_blank"
            rel="noopener"
            class="myds-footer-link radius-full bg-white shadow-button focus-ring-primary"
            aria-label="{{ $soc['aria'] }}"
            title="{{ $soc['name'] }}"
          >
            <x-myds.icons :name="$soc['icon']" class="myds-icon" />
          </a>
        @endforeach
      </div>
    </div>
  </div>
</footer>
