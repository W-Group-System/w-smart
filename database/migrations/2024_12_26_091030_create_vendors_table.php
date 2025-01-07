<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id')->unique();;
            $table->string('requestor_name')->nullable();
            $table->string('category')->nullable();
            $table->string('vendor_name')->nullable();
            $table->boolean('sole_proprietor')->nullable();
            $table->string('type')->nullable();
            $table->string('company_name')->unique();
            $table->string('vendor_status')->nullable();
            $table->string('classification_type')->nullable();
            $table->string('subsidiary')->nullable();
            $table->string('tin')->nullable();
            $table->string('registration_dti_no')->nullable();
            $table->date('date_registered')->nullable();
            $table->string('approver')->nullable();
            $table->date('start_date')->nullable();
            $table->date('action_date')->nullable();
            $table->date('action')->nullable();
            $table->string('remarks')->nullable();
            $table->date('deleted_at')->nullable();
            $table->string('password'); 
            $table->rememberToken(); 
            $table->string('vendor_code')->nullable(); 
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
        Schema::dropIfExists('vendors');
    }
}
