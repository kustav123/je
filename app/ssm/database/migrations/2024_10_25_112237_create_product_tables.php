<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Product main table
        Schema::create('finish_product', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('name', 50);
            $table->string('unit', 20);
            $table->string('created_by', 10);
            $table->integer('current_stock')->default(0);
            $table->tinyInteger('status');
            $table->string('remarks', 255)->nullable();
            $table->timestamp('created_at')->nullable();


            $table->foreign('created_by')->references('id')->on('appuser')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
        });
        Schema::create('raw_product', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('name', 50);
            $table->string('unit', 20);
            $table->string('created_by', 10);
            $table->integer('current_stock')->default(0);
            $table->tinyInteger('status');
            $table->string('remarks', 255)->nullable();
            $table->timestamp('created_at')->nullable()->default(null);
            $table->foreign('created_by')
                ->references('id')
                ->on('appuser')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        // Raw Product Entry
        Schema::create('product_entry_main', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('chalan_no', 35)->nullable();
            $table->string('from', 20);
            $table->date('recived_date')->nullable();
            $table->string('delivary_mode', 10)->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->double('total_amount')->nullable();
            $table->double('total_cgst')->nullable();
            $table->double('total_sgst')->nullable();
            $table->string('remarks', 100)->nullable();
            $table->string('created_by', 10)->nullable();

            $table->foreign('created_by')->references('id')->on('appuser')->onDelete('cascade');
            $table->foreign('from')->references('id')->on('supplier');
        });
        Schema::create('product_entry_history', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('entry_id', 20);
            $table->timestamp('created_at');
            $table->string('product', 20)->nullable();
            $table->string('qty', 255)->nullable();
            $table->string('amount', 255)->nullable();
            $table->string('remarks', 100)->nullable();
            $table->primary(['id', 'entry_id']);
            $table->index('entry_id', 'product_entry_history_entry_id_foreign');
            $table->index('product', 'product_entry_history_product_foreign');
            $table->foreign('entry_id')
                  ->references('id')
                  ->on('product_entry_main')
                  ->onDelete('cascade');
        });

        //Proudct Assign external assosiate
        Schema::create('product_st_out_ext', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('to', 20)->nullable()->index();
            // $table->timestamp('entry_time')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('date')->nullable();
            $table->string('entry_by', 10)->nullable();
            $table->string('remarks', 100)->nullable();
            $table->timestamp('created_at')->nullable();

        });
        Schema::create('product_st_out_ext_dtl', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('eid', 10)->comment('Main Entry ID');
            $table->string('product', 20);
            $table->integer('qty');
            $table->foreign('eid')->references('id')->on('product_st_out_ext');
            $table->foreign('product')->references('id')->on('raw_product');
            $table->index('eid');
            $table->index('product');
        });

        //Proudct Assign internal assosiate
        Schema::create('product_st_out_int', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('to', 20)->index();
            $table->timestamp('entry_time')->nullable()->useCurrent();
            $table->date('date')->nullable();
            $table->string('entry_by', 10)->nullable();
            $table->string('remarks', 100)->nullable();

            $table->foreign('to')->references('id')->on('asso_int');
        });

        Schema::create('product_st_out_int_dtl', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('eid', 10)->comment('Main Entry ID');
            $table->string('product', 20);
            $table->integer('qty');
            $table->foreign('eid')->references('id')->on('product_st_out_int')->onDelete('cascade');
            $table->foreign('product')->references('id')->on('raw_product')->onDelete('cascade');
            $table->index('eid');
            $table->index('product');
        });
       //Product Assignment Map

        Schema::create('product_st_out_ext_map', function (Blueprint $table) {
            $table->increments('id');
            $table->string('aid', 20)->comment('Assosiate ID');
            $table->string('product', 20);
            $table->integer('qty');
            $table->foreign('aid')->references('id')->on('asso_ext');
            $table->foreign('product')->references('id')->on('raw_product');
            $table->index('aid');
            $table->index('product');
        });
        Schema::create('product_st_out_int_map', function (Blueprint $table) {
            $table->id()->increments('id');
            $table->string('aid', 20)->comment('Assosiate ID');
            $table->string('product', 20);
            $table->integer('qty');
            $table->foreign('aid')->references('id')->on('asso_int');
            $table->foreign('product')->references('id')->on('raw_product');
            $table->index('aid');
            $table->index('product');
        });

        //Raw Product Adjust
        Schema::create('rawproduct_adj_his_ext', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('from', 20)->nullable()->comment('Assosiate ID');
            $table->timestamp('entry_time');
            $table->date('date')->nullable();
            $table->string('product', 20)->nullable();
            $table->integer('qty')->nullable();
            $table->string('entry_by', 10)->nullable();
            $table->string('remarks', 100)->nullable();
            $table->foreign('from')->references('id')->on('asso_ext');
            $table->foreign('product')->references('id')->on('raw_product');
            $table->index('from');
            $table->index('product');
        });
        Schema::create('rawproduct_adj_his_int', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('from', 20)->comment('Assosiate ID');
            $table->timestamp('entry_time')->nullable();
            $table->date('date')->nullable();
            $table->string('product', 20);
            $table->integer('qty');
            $table->string('entry_by', 10)->nullable();
            $table->string('remarks', 100)->nullable();
            $table->foreign('from')->references('id')->on('asso_int');
            $table->foreign('product')->references('id')->on('raw_product');
            $table->index('from');
            $table->index('product');
        });

        //Finish Product Sock Receive from associate
        Schema::create('finproduct_in_his_ext', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('aid', 10);
            $table->string('product', 20);
            $table->date('date')->nullable();
            $table->integer('qty')->nullable();

            $table->foreign('aid')->references('id')->on('asso_ext');
            $table->foreign('product')->references('id')->on('finish_product');

            $table->index('aid');
            $table->index('product');
        });
        Schema::create('finproduct_in_his_int', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('aid', 10);
            $table->string('product', 20);
            $table->date('date')->nullable();
            $table->integer('qty')->nullable();

            $table->foreign('aid')->references('id')->on('asso_ext');
            $table->foreign('product')->references('id')->on('finish_product');

            $table->index('aid');
            $table->index('product');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('product_entry_history');
        Schema::dropIfExists('product_entry_main');
        Schema::dropIfExists('product_st_out_ext_dtl');
        Schema::dropIfExists('product_st_out_ext');
        Schema::dropIfExists('product_st_out_int_dtl');
        Schema::dropIfExists('product_st_out_int');
        Schema::dropIfExists('product_st_out_ext_map');
        Schema::dropIfExists('product_st_out_int_map');
        Schema::dropIfExists('rawproduct_adj_his_ext');
        Schema::dropIfExists('rawproduct_adj_his_int');
        Schema::dropIfExists('finproduct_in_his_int');
        Schema::dropIfExists('finproduct_in_his_ext');
        Schema::dropIfExists('finish_product');
        Schema::dropIfExists('raw_product');


    }
};
