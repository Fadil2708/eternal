<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('evaluations', function (Blueprint $table) {
            $table->enum('grade', ['A', 'B', 'C', 'D', 'E'])->nullable()->change();
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->enum('grade', ['A', 'B', 'C', 'D', 'E'])->change();
        });
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('evaluations', function (Blueprint $table) {
            $table->enum('grade', ['A', 'B', 'C', 'D'])->nullable()->change();
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->enum('grade', ['A', 'B', 'C', 'D'])->change();
        });
    }
};
