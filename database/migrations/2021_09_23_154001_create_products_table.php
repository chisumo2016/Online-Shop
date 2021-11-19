<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            //Identifiers
            $table->id();
            $table->string('key')->unique();

            //information
            $table->string('name');
            $table->mediumText('description');
            $table->unsignedInteger('cost');
            $table->unsignedInteger('retail');

            //boolean flags
            $table->boolean('active')->default(true);
            /**
             * $todo Move default to config/even variable
             */
            $table->boolean('vat')->default(config('sho.vat'));

            //relationships
            //$table->foreignId('category_id')->nullable()->index()->constrained('categories')->nullOnDelete();
            //$table->foreignId('range_id')->nullable()->index()->constrained('categories')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->index()->constrained()->nullOnDelete();
            $table->foreignId('range_id')->nullable()->index()->constrained()->nullOnDelete();

            //Date stamps
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
