<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBirthdateAgePhoneGenderToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthdate')->nullable(); // Birthdate field
            $table->integer('age')->nullable(); // Age field
            $table->string('phone')->nullable(); // Phone field
            $table->enum('gender', ['male', 'female', 'other'])->nullable(); // Gender field
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['birthdate', 'age', 'phone', 'gender']);
        });
    }
}
