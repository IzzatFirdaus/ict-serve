document.addEventListener('DOMContentLoaded', () => {
  const loanModal = document.getElementById('loanDetailsModal');
  const ticketModal = document.getElementById('ticketDetailsModal');
  const loanContent = document.getElementById('loanDetailsContent');
  const ticketContent = document.getElementById('ticketDetailsContent');

  function openLoan(id) {
    if (!loanModal || !loanContent) {
      return;
    }
    loanContent.innerHTML = `
      <div class="text-center py-4">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-otl-primary-300 mx-auto"></div>
        <p class="mt-2 text-sm text-gray-500">Loading request details...</p>
      </div>
    `;
    loanModal.classList.remove('hidden');

    setTimeout(() => {
      loanContent.innerHTML = `
        <div class="space-y-4">
          <div>
            <h4 class="font-medium text-txt-black-900">Request Information</h4>
            <p class="text-sm text-txt-black-700">Details would be loaded here via AJAX call to fetch specific request data.</p>
          </div>
        </div>
      `;
    }, 500);
  }

  function openTicket(id) {
    if (!ticketModal || !ticketContent) {
      return;
    }
    ticketContent.innerHTML = `
      <div class="text-center py-4">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-danger-600 mx-auto"></div>
        <p class="mt-2 text-sm text-gray-500">Loading ticket details...</p>
      </div>
    `;
    ticketModal.classList.remove('hidden');

    setTimeout(() => {
      ticketContent.innerHTML = `
        <div class="space-y-4">
          <div>
            <h4 class="font-medium text-txt-black-900">Ticket Information</h4>
            <p class="text-sm text-txt-black-700">Details would be loaded here via AJAX call to fetch specific ticket data.</p>
          </div>
        </div>
      `;
    }, 500);
  }

  // Delegated clicks for open buttons
  document.body.addEventListener('click', (e) => {
    const btnLoan = e.target.closest('[data-open-loan]');
    if (btnLoan) {
      e.preventDefault();
      const id = btnLoan.getAttribute('data-open-loan');
      openLoan(id);
      return;
    }
    const btnTicket = e.target.closest('[data-open-ticket]');
    if (btnTicket) {
      e.preventDefault();
      const id = btnTicket.getAttribute('data-open-ticket');
      openTicket(id);
      return;
    }
    const btnCloseLoan = e.target.closest('[data-close-loan]');
    if (btnCloseLoan) {
      loanModal?.classList.add('hidden');
      return;
    }
    const btnCloseTicket = e.target.closest('[data-close-ticket]');
    if (btnCloseTicket) {
      ticketModal?.classList.add('hidden');
      return;
    }
  });

  // Backdrop click closes modal
  window.addEventListener('click', (event) => {
    if (event.target === loanModal) {
      loanModal.classList.add('hidden');
    }
    if (event.target === ticketModal) {
      ticketModal.classList.add('hidden');
    }
  });
});
