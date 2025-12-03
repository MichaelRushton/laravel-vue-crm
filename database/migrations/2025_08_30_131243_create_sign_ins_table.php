<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sign_ins', function (Blueprint $table) {
            $table->id();
            $table->ipAddress();
            $table->string('email');
            $table->foreignId('user_id')->nullable()->index()->constrained();
            $table->boolean('correct_password')->nullable();
            $table->timestamp('created_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sign_ins');
    }
};
