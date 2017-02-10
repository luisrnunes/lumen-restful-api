<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("addresses", function(Blueprint $table) {
            $table->increments("id");
            $table->integer("customer_id")->notnull()->unsigned();
            $table->string("street", 100)->notnull();
            $table->string("number", 10)->notnull();
            $table->string("complement", 50);
            $table->string("zip_code", 8)->notnull();
            $table->string("neighborhood", 50)->notnull();
            $table->string("city", 50)->notnull();
            $table->string("state", 2)->notnull();
            $table->timestamps();
        });

        Schema::table("addresses", function(Blueprint $table) {
            $table->foreign("customer_id")->references("id")->on("customers");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("addresses");
    }
}