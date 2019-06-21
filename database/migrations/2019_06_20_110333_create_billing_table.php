<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->float('amount', 8, 2);
            $table->date('due_date');
            $table->boolean('is_payed')->default(false);
            $table->unsignedBigInteger('flat_id');
            $table->timestamps();

            $table->foreign('flat_id')->references('id')->on('flat_owned')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing');
    }
}
