<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Domain;
use App\Models\Person;
use App\Models\Project;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $people = Person::factory()->count(12)->create();
        $domains = Domain::factory()->count(3)->create();
        $projects = Project::factory()->count(6)->create([
            'domain_id' => $domains->random()->id,
        ]);

        foreach ($people as $person) {
            Assignment::factory()->count(2)->create([
                'person_id' => $person->id,
                'project_id' => $projects->random()->id,
            ]);
        }
    }
}
