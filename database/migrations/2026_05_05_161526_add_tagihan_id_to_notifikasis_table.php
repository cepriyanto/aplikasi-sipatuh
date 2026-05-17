<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notifikasis', function (Blueprint $table) {
            $table->foreignId('tagihan_id')->nullable()->constrained('tagihans')->nullOnDelete()->after('user_id');
            $table->index('tagihan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifikasis', function (Blueprint $table) {
            $table->dropForeign(['tagihan_id']);
            $table->dropIndex(['tagihan_id']);
            $table->dropColumn('tagihan_id');
        });
    }
};
