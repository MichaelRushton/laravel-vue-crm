<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->index()->constrained();
            $table->string('token');
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_resets');
    }
};
