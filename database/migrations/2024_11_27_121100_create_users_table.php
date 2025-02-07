<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();            
            $table->string('username', 100)->unique('users_username_unique')->nullable(false);
            $table->string('password', 100)->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->enum('role', User::ROLE);
            $table->string('token', 100)->unique('users_token_unique')->nullable();
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
