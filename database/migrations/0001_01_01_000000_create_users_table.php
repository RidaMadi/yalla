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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('city_name')->nullable()->index();
            $table->string('city_region')->nullable();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->integer('gender');
            $table->string('address_id')->references('id')->on('addresses')->onDelete('set null');
            $table->integer('role')->default(\App\Enum\User\UserRole::CUSTOMER);
            $table->boolean('active')->default(true);
            $table->boolean('blocked')->default(false);
            $table->string('lang')->default('ar');
            $table->text('remember_token')->nullable();
            $table->timestamp('logout_at')->nullable();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('temporary_phones', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->string('code');
            $table->timestamp('expired_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('temporary_phones');
    }
};
