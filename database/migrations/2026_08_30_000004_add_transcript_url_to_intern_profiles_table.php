<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('intern_profiles', function (Blueprint $table) {
            $table->string('transcript_url', 500)->nullable()->after('cover_letter_url');
        });
    }

    public function down(): void
    {
        Schema::table('intern_profiles', function (Blueprint $table) {
            $table->dropColumn('transcript_url');
        });
    }
};
