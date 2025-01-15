<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_managements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rapidx_user_id')->comment = 'from RapidX User';
            $table->string('employee_no')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('department')->nullable()->comment = 'from SystemOne db_hris tbl_Department';
            $table->string('position')->nullable()->comment = 'from SystemOne db_hris tbl_Position';
            $table->unsignedTinyInteger('user_level')->comment = '0-User, 1-Admin';
            $table->unsignedTinyInteger('status')->default(0)->comment = '0-active, 1-deactivate';
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-Show, 1-Hide';
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
        Schema::dropIfExists('user_managements');
    }
}
