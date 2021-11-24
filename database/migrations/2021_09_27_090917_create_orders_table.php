<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();

            $table->string('number')->unique();//random number  - SISW -0000 000 000
            $table->string('state');  //Cancelled/completed/pending/refunded
            $table->string('coupon')->nullable();

            $table->string('intent_id')
                ->comment('intent ID is the payment intent from stripe')
                ->nullable()->unique();

            $table->unsignedBigInteger('total')->default(0);
            $table->unsignedBigInteger('reduction')->default(0);

            $table->foreignId('user_id')->index()->nullable()->constrained()->nullOnDelete();
            $table->foreignId('shipping_id')->index()->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('billing_id')->index()->nullable()->constrained('locations')->nullOnDelete();

            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
