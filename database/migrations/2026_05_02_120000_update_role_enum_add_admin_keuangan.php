<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate any legacy admin role values to admin_keuangan before changing the enum
        DB::statement("UPDATE users SET role = 'admin_keuangan' WHERE role = 'admin'");
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('mahasiswa', 'admin_keuangan', 'akademik', 'pimpinan') DEFAULT 'mahasiswa'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('mahasiswa', 'admin', 'akademik', 'pimpinan') DEFAULT 'mahasiswa'");
        }
        DB::statement("UPDATE users SET role = 'admin' WHERE role = 'admin_keuangan'");
    }
};
