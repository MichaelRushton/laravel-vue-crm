<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customer_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->uuid();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->boolean('trashed');
            $table->timestamp('created_at')->nullable()->index();
            $table->foreignId('created_by')->nullable()->index()->constrained('users', 'id');
            $table->foreignId('impersonated_by')->nullable()->index()->constrained('users', 'id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_revisions');
        Schema::dropIfExists('customers');
    }
};
