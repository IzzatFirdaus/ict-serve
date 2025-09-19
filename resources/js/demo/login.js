// Demo login form JS
window.addEventListener('DOMContentLoaded', function () {
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault();
      // Simulate login process
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      if (email === 'test@motac.gov.my' && password === 'password') {
        window.location.href = '/dashboard';
      } else {
        alert('E-mel atau kata laluan tidak sah');
      }
    });
  }
});
