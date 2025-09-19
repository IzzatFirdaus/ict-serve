<div
  x-data="{ open: localStorage.getItem('cookie-consent') !== 'accepted' }"
  x-show="open"
  x-transition
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
        <button
          type="button"
          class="myds-btn myds-btn-secondary myds-btn-sm"
          @click="open = false"
        >
          Tolak
        </button>
        <button
          type="button"
          class="myds-btn myds-btn-primary myds-btn-sm"
          @click="localStorage.setItem('cookie-consent','accepted'); open=false"
        >
          Terima
        </button>
      </div>
    </div>
  </div>
</div>
