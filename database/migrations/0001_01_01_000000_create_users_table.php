<?php

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', array_column(UserRole::cases(), 'value'))->default(UserRole::User->value);
            $table->enum('status', array_column(UserStatus::cases(), 'value'))->default(UserStatus::Active->value);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->enum('role', array_column(UserRole::cases(), 'value'));
            $table->enum('status', array_column(UserStatus::cases(), 'value'));
            $table->boolean('trashed');
            $table->timestamp('created_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users', 'id');
            $table->foreignId('impersonated_by')->nullable()->constrained('users', 'id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_revisions');
        Schema::dropIfExists('users');
    }
};
