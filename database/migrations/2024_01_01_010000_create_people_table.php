<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->uuid('ad_guid')->nullable()->index();
            $table->string('employee_id')->nullable()->index();
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('job_title')->nullable();
            $table->string('location')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('manager_id')->nullable()->constrained('people')->nullOnDelete();
            $table->string('status')->default('active');
            $table->string('employee_type')->default('employee');
            $table->date('join_date')->nullable();
            $table->timestamp('leave_date')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->string('source')->default('local');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
