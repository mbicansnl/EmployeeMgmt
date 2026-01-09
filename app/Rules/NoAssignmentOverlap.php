<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Assignment;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoAssignmentOverlap implements ValidationRule
{
    public function __construct(
        private readonly int $personId,
        private readonly int $projectId,
        private readonly ?int $ignoreId = null,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $start = request('start_date');
        $end = request('end_date');

        $query = Assignment::query()
            ->where('person_id', $this->personId)
            ->where('project_id', $this->projectId)
            ->when($this->ignoreId, fn ($builder) => $builder->where('id', '!=', $this->ignoreId));

        if ($start) {
            $query->where(function ($builder) use ($start, $end) {
                $builder
                    ->whereNull('end_date')
                    ->orWhere('end_date', '>=', $start);

                if ($end) {
                    $builder->where('start_date', '<=', $end);
                }
            });
        }

        if ($query->exists()) {
            $fail('This assignment overlaps with an existing allocation.');
        }
    }
}
