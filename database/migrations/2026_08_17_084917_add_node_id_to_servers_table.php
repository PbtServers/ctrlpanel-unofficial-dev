<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('servers', 'node_id')) {
            Schema::table('servers', function (Blueprint $table) {
                $table->foreignId('node_id')
                    ->nullable()
                    ->constrained('nodes')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('servers', 'node_id')) {
            Schema::table('servers', function (Blueprint $table) {
                $table->dropForeign(['node_id']);
                $table->dropColumn('node_id');
            });
        }
    }
};
