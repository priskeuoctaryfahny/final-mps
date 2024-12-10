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
        Schema::create('web_settings', function (Blueprint $table) {
            $table->id();
            $table->string('web_logo')->nullable();
            $table->string('web_favicon')->nullable();
            $table->string('web_title')->nullable();
            $table->string('web_description')->nullable();
            $table->string('web_keywords')->nullable();
            $table->string('web_author')->nullable();
            $table->string('web_email')->nullable();
            $table->string('web_phone')->nullable();
            $table->string('web_address')->nullable();
            $table->foreignId('web_default_user_role')->default(1)->constrained('roles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
