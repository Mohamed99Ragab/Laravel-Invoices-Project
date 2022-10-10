<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_num');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('product');
            $table->foreignId('section_id')->references('id')->on('sections');
            $table->decimal('amount_collection',8,2);
            $table->decimal('amount_commission',8,2);
            $table->decimal('discount');
            $table->string('rate_vat');
            $table->decimal('value_vat',8,2);
            $table->decimal('total',8,2);
            $table->string('status',50);
            $table->integer('value_status');
            $table->date('Payment_Date')->nullable();
            $table->text('note')->nullable();
            $table->string('user');
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
