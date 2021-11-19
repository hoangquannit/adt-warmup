<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->mediumText('avatar')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('remember_token')->nullable();

            $table->integer('created_by')->nullable()->comment('The latest user ID that created the record');
            $table->integer('updated_by')->nullable()->comment('The latest user ID that updated the record');
            $table->smallInteger('enable')->default(1)->comment('Flag indicating invalid (deletion) record');
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
        Schema::dropIfExists('admin_accounts');
    }
}
