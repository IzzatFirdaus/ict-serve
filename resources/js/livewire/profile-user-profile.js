// Auto-hide flash messages for user profile page
setTimeout(function () {
  const messages = document.querySelectorAll('.fixed.bottom-4.right-4');
  messages.forEach(function (message) {
    message.style.transition = 'opacity 0.5s';
    message.style.opacity = '0';
    setTimeout(function () {
      message.remove();
    }, 500);
  });
}, 5000);
