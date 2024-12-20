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
        Schema::create('appinfo', function (Blueprint $table) {
            $table->integer('id')->nullable();
            $table->string('name', 50)->nullable();
            $table->string('logo', 100)->nullable();
            $table->string('address', 500);
            $table->string('gstno', 17)->nullable();
            $table->string('type', 1)->nullable();
            $table->string('apptype', 5)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('cont1', 20)->nullable();
            $table->string('cont2', 20)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('bank_account_holder_name', 100)->nullable();
            $table->string('bank_qr', 100)->nullable();
            $table->string('bank_name', 150) ->nullable();
            $table->string('bank_branch', 100)->nullable() ;
            $table->string('bank_ac_no', 255)->nullable();
            $table->string('bank_ifsc', 255)->nullable();
            $table->decimal( 'due_ammount', 15, 2)->default(0.00);
            $table->decimal( 'earning_yr', 15, 2)->default(0.00);
            $table->decimal( 'earning_lt', 15, 2)->default(0.00);
        });

        // Create the appuser table
        Schema::create('appuser', function (Blueprint $table) {
            $table->string('id', 10)->primary();
            $table->string('name', 50)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->nullable();
            $table->string('role', 2)->nullable();
            $table->string('sign', 100)->nullable();
            $table->string('status', 1)->nullable();
            $table->string('is_logedin', 1)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('lastlogin_time')->useCurrent()->useCurrentOnUpdate();
            $table->string('lastlogin_from', 30)->nullable();
            $table->string('username', 20)->notNullable();
        });

        // Create the client table
        Schema::create('client', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('name', 40)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('state', 100)->nullable();
            $table->integer('status')->nullable();
            $table->decimal('due_ammount', 10, 2)->default(0.00);
            $table->string('gst', 17)->nullable();
            $table->string('remarks', 100)->nullable();
            $table->string('created_by', 10)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('mobile_additonal', 20)->nullable();
            $table->foreign('created_by')->references('id')->on('appuser');
        });
        Schema::create('supplier', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('merchant_name', 30);
            $table->string('mobile', 15)->nullable();
            $table->string('mobile_additonal', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('state', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('created_by', 10);
            $table->tinyInteger('status');
            $table->decimal('due_ammount', 10, 2)->default(0.00);
            $table->string('gst', 17)->nullable();
            $table->string('remarks', 100)->nullable();
            $table->foreign('created_by')->references('id')->on('appuser');
        });

        Schema::create('asso_ext', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('name', 50);
            $table->string('mobile', 15)->nullable();
            $table->string('email', 255)->nullable();
            $table->tinyInteger('status');
            $table->string('address', 255)->nullable();
            $table->string('uidtype', 255)->nullable();
            $table->string('uid', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('created_by', 10);
            $table->foreign('created_by')->references('id')->on('appuser');

        });
        Schema::create('asso_int', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('name', 50);
            $table->string('mobile', 15)->nullable();
            $table->string('email', 255)->nullable();
            $table->tinyInteger('status');
            $table->string('address', 255)->nullable();
            $table->string('uidtype', 255)->nullable();
            $table->string('uid', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('created_by', 10);
            $table->foreign('created_by')->references('id')->on('appuser');

        });
        // Create the hsn table
        Schema::create('hsn', function (Blueprint $table) {
            $table->string('id', 6)->primary();
            $table->string('name', 50);
            $table->timestamp('created_at')->nullable();
            $table->tinyInteger('status');
            $table->string('cgst', 2)->nullable();
            $table->string('sgst', 2)->nullable();
        });
        // Create the secuence table
        Schema::create('secuence', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->string('type', 20)->nullable();
            $table->string('head', 20)->nullable();
            $table->string('sno', 20)->nullable();
            $table->string('remarks', 40)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('nextval', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 6);
            $table->string('head', 20);
            $table->string('sno', 10)->nullable();

        });
        Schema::create('audit', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('userid', 20);
            $table->string('type', 50);
            $table->text('message', 350);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client');
        Schema::dropIfExists('supplier');
        Schema::dropIfExists('hsn');
        Schema::dropIfExists('secuence');
        Schema::dropIfExists('nextval');
        Schema::dropIfExists('asso_ext');
        Schema::dropIfExists('asso_int');
        Schema::dropIfExists('appinfo');
        Schema::dropIfExists('appuser');
        Schema::dropIfExists('audit');

    }
};
