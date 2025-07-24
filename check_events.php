<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->boot();

$events = App\Models\Event::whereIn('event_code', ['2407423', '2407672'])->get();

foreach($events as $event) {
    echo "Code: {$event->event_code}\n";
    echo "Name: {$event->name}\n";
    echo "Active: " . ($event->isActive() ? 'YES' : 'NO') . "\n";
    echo "Current Time: " . \Carbon\Carbon::now()->format('Y-m-d H:i:s') . "\n";
    echo "---\n";
}
