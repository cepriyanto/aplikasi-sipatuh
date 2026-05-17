<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';

use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use App\Models\Tagihan;
use App\Models\Notifikasi;
use Carbon\Carbon;

$kernel = $app->make(ConsoleKernel::class);
$kernel->bootstrap();

$today = Carbon::today()->toDateString();
echo "Today: $today\n";
$tagihans = Tagihan::where('status', Tagihan::STATUS_BELUM_LUNAS)->get();
echo "Belum lunas: " . $tagihans->count() . "\n";
foreach ($tagihans as $tagihan) {
    $date = $tagihan->tanggal_jatuh_tempo->toDateString();
    $diff = Carbon::today()->startOfDay()->diffInDays(Carbon::parse($date)->startOfDay(), false);
    $userId = $tagihan->mahasiswa ? $tagihan->mahasiswa->user_id : 'null';
    echo 'Tagihan ' . $tagihan->id . ' jenis=' . $tagihan->jenis . ' tanggal=' . $date . ' diff=' . $diff . ' user=' . $userId . "\n";
}
echo 'Notifikasi existing: ' . Notifikasi::count() . "\n";
