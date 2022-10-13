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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('city')->nullable();
            $table->string('date')->nullable();
            $table->string('code')->nullable();
            $table->enum('status',[0,1])->default(0);
            $table->enum('role',['user','service_provider'])->default('user');
            $table->string('ID_number')->nullable()->unique();
            $table->string('ID_img')->nullable()->unique();
            $table->string('scope')->nullable();
            $table->text('about')->nullable();
            $table->string('Bank_Number')->nullable()->unique();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
