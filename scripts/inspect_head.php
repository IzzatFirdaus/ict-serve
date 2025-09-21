<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/admin');
$response = $kernel->handle($request);
$content = $response->getContent();
$headPos = stripos($content, '<head');
if ($headPos === false) {
    echo "<head> not found\n";
    exit(1);
}
$headEnd = stripos($content, '</head>', $headPos);
$head = substr($content, $headPos, $headEnd - $headPos + 7);
file_put_contents(__DIR__ . '/admin_head.html', $head);
echo "Wrote scripts/admin_head.html (first 1000 chars):\n";
echo substr($head, 0, 1000);
$kernel->terminate($request, $response);
