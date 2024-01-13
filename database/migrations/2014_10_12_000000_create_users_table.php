<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid');
            $table->string('enterprise_user_id', 29)->nullable();
            $table->integer('parent_id')->default(false);
            $table->string('api_token')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->text('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('status')->default(true);
            $table->text('image')->nullable();
            $table->string('sms_unit')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_customer')->default(false);
            $table->string('active_portal')->nullable();
            $table->boolean('two_factor')->default(false);
            $table->integer('two_factor_code')->nullable();
            $table->dateTime('two_factor_expires_at')->nullable();
            $table->string('two_factor_backup_code')->nullable();
            $table->string('locale')->default('');
            $table->string('timezone')->default('');
            $table->timestamp('last_access_at')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->rememberToken();
            $table->char('key_id', 20)->nullable();
            $table->char('key_secret', 50)->nullable();
            $table->unsignedBigInteger('api_sending_server')->nullable();
            $table->boolean('is_accept_connection_declaration')->default(false);
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
        Schema::dropIfExists('users');
    }
};
