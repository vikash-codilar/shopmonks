<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExcelSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excel_sheets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imei');
            $table->string('product_code');
            $table->string('invoice_no');
            $table->string('pallet_id');
            $table->string('box_id');
            $table->string('description');
            $table->string('model');
            $table->string('storage');
            $table->string('color');
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
        Schema::dropIfExists('excel_sheets');
    }
}
