<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name_main')->nullable();
            $table->string('name_sub')->nullable();
            $table->text('desc')->nullable();
            $table->string('code_order')->nullable();
            $table->decimal('from')->nullable();
            $table->decimal('to')->nullable();
            $table->string('GBS')->nullable();
            $table->string('file')->nullable();
            $table->enum('status',['receiving','Discuss','under_review',' under_way','complete','canceled'])->nullable();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
