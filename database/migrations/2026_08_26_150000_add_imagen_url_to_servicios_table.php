<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('servicios')) {
            return;
        }

        Schema::table('servicios', function (Blueprint $table) {
            if (! Schema::hasColumn('servicios', 'imagen_url')) {
                $table->string('imagen_url', 500)->nullable()->after('nombre');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('servicios')) {
            return;
        }

        Schema::table('servicios', function (Blueprint $table) {
            if (Schema::hasColumn('servicios', 'imagen_url')) {
                $table->dropColumn('imagen_url');
            }
        });
    }
};
