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
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('reserve_id', )->unsigned()->index()->nullable()->nullable();
            $table->foreign('reserve_id')->references('id')->on('reserves');
            $table->bigInteger('role_id')->default(3)->unsigned()->index();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->bigInteger('company_id', )->unsigned()->index()->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->rememberToken();
            $table->string('api_token', 80)->unique()->nullable()->default(null);
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
