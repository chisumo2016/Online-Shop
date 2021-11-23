<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('code'); // gimmie my money off
            $table->unsignedInteger('reduction')->default(0); //900
            $table->unsignedInteger('uses')->default(0); //1
            $table->unsignedInteger('max_uses')->nullable(); //1
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
