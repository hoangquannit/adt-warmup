<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provider_admin_id');
            $table->string('provider');
            $table->string('admin_id')->nullable();

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
        Schema::dropIfExists('social_accounts');
    }
}
