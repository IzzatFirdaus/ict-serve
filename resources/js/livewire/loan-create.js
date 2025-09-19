// Loan Create Blade - Client-side date min adjustment
document.addEventListener('DOMContentLoaded', () => {
  const fromDate = document.getElementById('requested_from');
  const toDate = document.getElementById('requested_to');
  if (fromDate && toDate) {
    fromDate.addEventListener('change', () => {
      toDate.min = fromDate.value;
      if (toDate.value && toDate.value <= fromDate.value) {
        const nextDay = new Date(fromDate.value);
        nextDay.setDate(nextDay.getDate() + 1);
        toDate.value = nextDay.toISOString().split('T')[0];
      }
    });
  }
});
