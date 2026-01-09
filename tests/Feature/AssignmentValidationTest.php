<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Person;
use App\Models\Project;
use App\Rules\NoAssignmentOverlap;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AssignmentValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_overlap_is_rejected(): void
    {
        $person = Person::factory()->create();
        $project = Project::factory()->create();

        Assignment::factory()->create([
            'person_id' => $person->id,
            'project_id' => $project->id,
            'start_date' => now()->subMonth()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
        ]);

        $validator = Validator::make([
            'project_id' => $project->id,
            'person_id' => $person->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonths(2)->toDateString(),
        ], [
            'project_id' => [new NoAssignmentOverlap($person->id, $project->id)],
        ]);

        $this->assertTrue($validator->fails());
    }

    public function test_allocation_percent_is_capped(): void
    {
        $validator = Validator::make([
            'allocation_percent' => 150,
        ], [
            'allocation_percent' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $this->assertTrue($validator->fails());
    }
}
