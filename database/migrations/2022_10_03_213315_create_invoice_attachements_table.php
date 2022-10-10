<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceAttachementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_attachements', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('invoice_number');
            $table->foreignId('invoice_id')->references('id')->on('invoices')->cascadeOnDelete();
            $table->string('user');
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
        Schema::dropIfExists('invoice_attachements');
    }
}
