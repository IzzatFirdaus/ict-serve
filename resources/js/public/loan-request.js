// Pass user data to JavaScript
window.authUserData = {
  name: '{{ auth()->user()->name }}',
  position: '{{ auth()->user()->position ?? "" }}',
  phone: '{{ auth()->user()->phone ?? "" }}',
};
