<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Person;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'project_id' => Project::factory(),
            'project_role' => $this->faker->jobTitle(),
            'allocation_percent' => $this->faker->numberBetween(10, 80),
            'start_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'end_date' => $this->faker->optional()->dateTimeBetween('now', '+6 months'),
            'source' => 'local',
        ];
    }
}
