<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oil_checks', function (Blueprint $table) {
            $table->id();
            $table->decimal('current_odometer', 10, 1);
            $table->date('last_change_date');
            $table->decimal('last_change_odometer', 10, 1);
            $table->boolean('needs_change');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oil_checks');
    }
};
