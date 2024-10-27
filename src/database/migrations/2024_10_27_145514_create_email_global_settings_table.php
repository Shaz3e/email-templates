<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_global_settings', function (Blueprint $table) {
            $table->id();
            $table->longText('name')->nullable();
            $table->longText('value')->nullable();
            $table->timestamps();
        });

        $settings = [
            ['name' => 'header_image', 'value' => null],
            ['name' => 'footer_text_color', 'value' => null],
            ['name' => 'footer_background_color', 'value' => null],
            ['name' => 'footer_text', 'value' => null],
        ];

        DB::table('email_global_settings')->insert($settings);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_global_settings');
    }
};
