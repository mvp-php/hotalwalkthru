<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ht_category_master', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name');
            $table->string('del_flag');
            $table->timestamps('created_date');
			$table->string('created_by');
			$table->timestamps('updated_date');
			$table->string('updated_by');
			$table->timestamps('deleted_date');
			$table->string('deleted_by');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ht_category_master');
    }
}
