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
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('server_name');
            $table->uuid('uuid')->unique();
            $table->float('hourly_price');
            $table->string('slug');
            $table->string('ram');
            $table->string('vcpu');
            $table->string('disk_storage');
            $table->string('server_provider');
            $table->string('provider_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
