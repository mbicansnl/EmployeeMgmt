<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('project_role')->nullable();
            $table->unsignedTinyInteger('allocation_percent');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('source')->default('local');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['person_id', 'project_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
