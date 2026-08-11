<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Fix: tokenable_id harus UUID karena users.id adalah UUID.
     */
    public function up(): void
    {
        if (Schema::getColumnType('personal_access_tokens', 'tokenable_id') === 'bigint') {
            if (DB::connection()->getDriverName() === 'mysql') {
                Schema::table('personal_access_tokens', function (Blueprint $table) {
                    $table->uuid('tokenable_id')->change();
                });
            } elseif (DB::connection()->getDriverName() === 'sqlite') {
                Schema::dropIfExists('personal_access_tokens_temp');

                DB::statement('CREATE TABLE personal_access_tokens_temp AS SELECT * FROM personal_access_tokens');

                Schema::drop('personal_access_tokens');

                Schema::create('personal_access_tokens', function (Blueprint $table) {
                    $table->id();
                    $table->string('tokenable_type');
                    $table->uuid('tokenable_id');
                    $table->index(['tokenable_type', 'tokenable_id']);
                    $table->text('name');
                    $table->string('token', 64)->unique();
                    $table->text('abilities')->nullable();
                    $table->timestamp('last_used_at')->nullable();
                    $table->timestamp('expires_at')->nullable();
                    $table->timestamps();
                });

                DB::table('personal_access_tokens_temp')->orderBy('id')->chunkById(500, function ($rows) {
                    foreach ($rows as $row) {
                        DB::table('personal_access_tokens')->insert((array) $row);
                    }
                });

                Schema::dropIfExists('personal_access_tokens_temp');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            Schema::table('personal_access_tokens', function (Blueprint $table) {
                $table->unsignedBigInteger('tokenable_id')->change();
            });
        }
    }
};
