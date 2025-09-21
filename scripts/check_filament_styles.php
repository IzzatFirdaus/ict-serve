<?php

require __DIR__.'/..//vendor/autoload.php';
$app = require __DIR__.'/..//bootstrap/app.php';
// Bootstrap application
try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "Kernel bootstrapped\n";
} catch (Throwable $e) {
    echo 'Bootstrap error: '.$e->getMessage()."\n";
}
if (class_exists('\\Filament\\Filament')) {
    echo "Filament class exists\n";
    try {
        // Attempt to boot panels/providers so assets are registered
        if (class_exists('App\\Providers\\Filament\\AdminPanelProvider')) {
            $providerClass = 'App\\Providers\\Filament\\AdminPanelProvider';
            $provider = new $providerClass(app());
            if (method_exists($provider, 'register')) {
                $provider->register();
                echo "AdminPanelProvider->register() called\n";
            }
            if (method_exists($provider, 'boot')) {
                $provider->boot();
                echo "AdminPanelProvider->boot() called\n";
            }
        }
        // Attempt to get styles via Filament facade if available
        $styles = call_user_func(['\\Filament\\Filament', 'getStyles']);
        echo "getStyles result:\n";
        var_export($styles);
        echo "\n";
        echo "Rendered styles:\n";
        echo call_user_func(['\\Filament\\Filament', 'renderStyles']);
    } catch (Throwable $e) {
        echo 'getStyles error: '.$e->getMessage()."\n";
    }
} else {
    echo "Filament class not found\n";
}
