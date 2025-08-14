<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
             $table->string('address_line_1')->nullable();
             $table->string('address_line_2')->nullable();
             $table->string('city')->nullable();
             $table->string('state')->nullable();
             $table->string('country')->nullable();
             $table->string('zip')->nullable();
             $table->string('alternative_phone')->nullable();
             $table->string('date_of_birth')->nullable();
             $table->string('gender')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
