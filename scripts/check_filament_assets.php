<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
// Register Filament service provider explicitly
$app->register(\Filament\FilamentServiceProvider::class);
// Boot the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
try {
    $filament = $app->make('filament');
} catch (Throwable $e) {
    echo "Could not resolve 'filament' from container: ".$e->getMessage()."\n";
    exit(1);
}
if (method_exists($filament, 'bootCurrentPanel')) {
    $filament->bootCurrentPanel();
}
// Try to get styles
if (method_exists($filament, 'getStyles')) {
    $styles = $filament->getStyles();
    echo "getStyles():\n";
    var_export($styles);
    echo "\n\nrenderStyles():\n";
    if (method_exists($filament, 'renderStyles')) {
        echo $filament->renderStyles();
    } else {
        echo "renderStyles method not available\n";
    }
} else {
    echo "Filament does not have getStyles() method\n";
}
