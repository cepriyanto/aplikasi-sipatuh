<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';

use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use App\Services\NotifikasiJatuhTempoService;
use App\Models\Notifikasi;
use App\Models\Tagihan;

$kernel = $app->make(ConsoleKernel::class);
$kernel->bootstrap();

$service = new NotifikasiJatuhTempoService();
$service->kirimNotifikasiJatuhTempo();

echo "Service executed\n";
$notifs = Notifikasi::where('tagihan_id', 11)->get();
echo 'Notifikasi count for tagihan 11: ' . $notifs->count() . "\n";
foreach ($notifs as $notif) {
    echo $notif->id . ' | ' . $notif->judul . ' | ' . $notif->pesan . ' | ' . $notif->type . ' | ' . $notif->created_at . "\n";
}
