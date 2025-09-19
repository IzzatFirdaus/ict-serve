<!DOCTYPE html>
<html lang="ms">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Log Masuk - ICTServe (iServe)</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/demo/login.css'])
  </head>
  <body>
    <div class="login-container">
      <div class="logo">
        <div class="login-logo-circle">
          <span class="login-logo-text">iS</span>
        </div>
        <h1 class="font-poppins">ICTServe (iServe)</h1>
        <p>Sistem Pengurusan Perkhidmatan ICT MOTAC</p>
      </div>

      <form id="loginForm" action="{{ route('demo.login') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="email" class="form-label">E-mel</label>
          <input
            type="email"
            id="email"
            name="email"
            class="form-input"
            value="test@motac.gov.my"
            required
          />
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Kata Laluan</label>
          <input
            type="password"
            id="password"
            name="password"
            class="form-input"
            value="password"
            required
          />
        </div>

        <button type="submit" class="btn-primary">Log Masuk</button>
      </form>

      <div class="login-demo-credentials">
        <p>Demo Login Credentials:</p>
        <p>E-mel: test@motac.gov.my</p>
        <p>Kata Laluan: password</p>
      </div>
    </div>

    @vite(['resources/js/demo/login.js'])
  </body>
</html>
