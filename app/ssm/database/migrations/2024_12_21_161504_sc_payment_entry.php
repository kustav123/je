<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sc_payment_entry', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('scid', 20)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->float('amount')->nullable();
            $table->string('mode', 10)->nullable();
            $table->float('hisamount')->nullable();
            $table->float('curamount')->nullable();
            $table->string('frmaccount', 20)->nullable();
            $table->string('frmbnk', 20)->nullable();
            $table->string('remarks', 100)->nullable();
            $table->string('created_by', 10)->nullable();
            $table->string('trid', 50)->nullable();
            $table->tinyInteger('compid')->nullable();
            $table->foreign('scid')->references('id')->on('supplier')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sc_payment_entry');
    }
};
