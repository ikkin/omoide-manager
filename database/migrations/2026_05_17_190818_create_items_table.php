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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->string('item_name');
            $table->string('model_no')->nullable();
            $table->integer('condition');
            $table->string('condition_detail')->nullable();
            $table->integer('disposal_plan');
            $table->integer('discard_cost')->nullable();
            $table->integer('sale_price')->nullable();
            $table->string('transfer_target')->nullable();
            $table->string('storage_deadline')->nullable();
            $table->integer('disposal_status');
            $table->string('remark')->nullable();
            $table->jsonb('ai_text')->nullable();
            $table->string('image_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
