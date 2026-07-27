<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['users', 'vacancies', 'applications', 'internships', 'faqs', 'testimonials'];

        foreach ($tables as $table) {
            if (!Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, fn(Blueprint $t) => $t->softDeletes());
            }
        }
    }

    public function down(): void
    {
        $tables = ['users', 'vacancies', 'applications', 'internships', 'faqs', 'testimonials'];

        foreach ($tables as $table) {
            if (Schema::hasColumn($table, 'deleted_at')) {
                Schema::table($table, fn(Blueprint $t) => $t->dropSoftDeletes());
            }
        }
    }
};