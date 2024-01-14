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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('is_writer')->default(0);
            $table->integer('is_admin')->default(0);
            $table->string('country')->nullable;
            $table->string('address')->nullable;
            $table->string('bio')->nullable;
            $table->string('state')->nullable;
            $table->string('phone')->nullable;
            $table->string('image')->nullable;
            $table->string('profession')->nullable;
            $table->timestamp('email_verified_at')->nullable;
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
