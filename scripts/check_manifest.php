<?php

$path = __DIR__.'/../public/build/manifest.json';
if (! file_exists($path)) {
    echo "manifest missing\n";
    exit(1);
}
$m = json_decode(file_get_contents($path), true);
echo 'Number of entries: '.count($m)."\n";
if (array_key_exists('resources/css/app.css', $m)) {
    echo "resources/css/app.css in manifest\n";
} else {
    echo "resources/css/app.css not in manifest\n";
}
// print first 10 keys
echo "Sample keys:\n";
$keys = array_keys($m);
for ($i = 0; $i < min(10, count($keys)); $i++) {
    echo $keys[$i]."\n";
}
