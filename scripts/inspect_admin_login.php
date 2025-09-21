<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/admin/login');
$response = $kernel->handle($request);
$content = $response->getContent();
file_put_contents(__DIR__.'/admin_login.html', $content);
$kernel->terminate($request, $response);
echo 'Wrote scripts/admin_login.html (size: '.strlen($content).")\n";
$headPos = stripos($content, '<head');
if ($headPos === false) {
    echo "<head> not found\n";
    exit(1);
}
$headEnd = stripos($content, '</head>', $headPos);
$head = substr($content, $headPos, $headEnd - $headPos + 7);
file_put_contents(__DIR__.'/admin_login_head.html', $head);
echo "Wrote scripts/admin_login_head.html\n";
