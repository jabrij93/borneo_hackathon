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
            $table->text('images')->nullable();
            $table->string('staff_id')->unique()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('genders_id')->nullable(); // Make sure it's an unsigned integer
            $table->foreign('genders_id')->references('id')->on('genders');
            $table->unsignedBigInteger('departments_id')->nullable(); // Make sure it's an unsigned integer
            $table->foreign('departments_id')->references('id')->on('departments');
            // $table->string('department')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
            $table->integer('phonenumber')->nullable();
            $table->string('company_name')->nullable();
            $table->string('role')->default('users');
            $table->string('profile_photo_path', 2048)->nullable();
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
