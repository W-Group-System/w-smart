<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_attachments', function (Blueprint $table) {
            $table->increments('id'); 
            $table->unsignedInteger('vendor_id'); 
            $table->string('file_name'); 
            $table->string('file_path'); 
            $table->enum('document_type', [
                'company_profile',
                'office_location_map',
                'sec_dti_reg',
                'articles_of_inc',
                'bir_form',
                'latest_general_info',
                'corporate_sec_cert',
                'audited_fs_bir',
                'business_permit',
                'tax_incentive',
                'sample_invoice',
            ]); 
            $table->timestamps(); 
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_attachments');
    }
}
