{{--
  Microscope Package - Route Action PHPDoc Comment Template
  =========================================================
  
  Purpose:
  This template generates the PHPDoc comment block for a Laravel route action when using the `php artisan microscope:check-routes` command.
  
  Update Rationale (MyGovEA Principles):
  - Panduan & Dokumentasi (Guidance): The output is formatted into a clean, easy-to-read structure. This makes the generated documentation more effective for developers.
  - Seragam (Consistent): A single, consistent format is used for all routes, regardless of the number of HTTP methods. This predictability makes scanning and understanding routes much faster.
  - Kognitif (Cognitive): By combining the HTTP method and URI into a single, conventional line (e.g., "[GET|POST] /api/user"), the cognitive load on the developer is reduced.
  
  This template replaces the multi-format logic with a single, more descriptive block and corrects the syntax error.
--}}
@php
  // If all standard HTTP methods are allowed, we simplify the label to 'ANY' for clarity.
  $httpMethods = count($methods) >= 7 ? ['ANY'] : $methods;
  // 'GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'
  $httpMethods = strtoupper(implode('|', $httpMethods));
@endphp

*
@if ($routeName)
  *
  @name
  {!! $routeName !!}
@endif

*
@url
[{!! $httpMethods !!}] {!! $url !!} *
@middlewares
{!! implode(', ', $middlewares) !!}
@if ($file && $line)
  *
  @at
  {!! $file !!}:{!! $line !!}
@endif
