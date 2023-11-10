<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('lot_no')->nullable();
            $table->string('street')->nullable();
            $table->enum('barangay', ['Asinan', 'Banicain', 'Barretto', 'East Tapinac', 'Gordon Heights', 'Kalaklan', 'Mabayuan', 'New Cabalan', 'New Ilalim', 'New Kababae', 'New Kalalake', 'Old Cabalan', 'Pag-asa', 'Santa Rita', 'West Bajac-Bajac', 'West Tapinac'])->default('Santa Rita');
            $table->string('city')->default('Olongapo');
            $table->string('province')->default('Zambales');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->longText('profile_picture')->nullable();
            $table->string('admin_name')->nullable();
            $table->string('role')->default('Resident');
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
}
