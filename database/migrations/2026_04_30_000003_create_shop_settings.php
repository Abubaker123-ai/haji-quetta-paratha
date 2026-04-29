<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_open')->default(true);
            $table->boolean('use_schedule')->default(false);
            $table->string('opening_time')->default('06:00');
            $table->string('closing_time')->default('22:00');
            $table->string('custom_message')->nullable();
            $table->timestamps();
        });

        // Seed default row
        DB::table('shop_settings')->insert([
            'is_open'        => true,
            'use_schedule'   => false,
            'opening_time'   => '06:00',
            'closing_time'   => '22:00',
            'custom_message' => null,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_settings');
    }
};
