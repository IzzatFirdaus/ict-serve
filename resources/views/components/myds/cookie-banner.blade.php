<div
  x-data="{ open: localStorage.getItem('cookie-consent') !== 'accepted' }"
  x-show="open"
  x-cloak
  x-transition
  role="dialog"
  aria-modal="false"
  aria-label="Cookie consent"
  class="fixed bottom-4 inset-x-0 z-50"
>
  <div class="myds-container">
    <div
      class="myds-card flex flex-col md:flex-row items-start md:items-center justify-between gap-3"
    >
      <p class="font-inter text-body-sm text-txt-black-900">
        Kami menggunakan kuki untuk meningkatkan pengalaman anda. Dengan
        meneruskan, anda bersetuju dengan penggunaan kuki kami.
      </p>
      <div class="flex items-center gap-2">
        <x-myds.button type="button" variant="secondary" size="sm" @click="open = false" aria-label="Decline cookies">Tolak</x-myds.button>
        <x-myds.button type="button" variant="primary" size="sm" @click="localStorage.setItem('cookie-consent','accepted'); open=false" aria-label="Accept cookies">Terima</x-myds.button>
      </div>
    </div>
  </div>
</div>
