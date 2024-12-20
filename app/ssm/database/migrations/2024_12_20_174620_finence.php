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
        Schema::create('leadger_sc', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('clid', 20)->nullable();
            $table->date('date')->nullable();
            $table->string('type', 20)->nullable();
            $table->double('current_amomount')->nullable();
            $table->double('truns_ammount')->nullable();
            $table->string('mode', 30)->nullable();
            $table->string('remarks', 50)->nullable();
            $table->string('refno', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('tid', 50)->nullable();
            $table->foreign('clid')->references('id')->on('supplier')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leadger_sc');

    }
};
