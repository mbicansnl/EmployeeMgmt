<?php

declare(strict_types=1);

namespace App\Filament\Resources\AssignmentResource\Pages;

use App\Filament\Resources\AssignmentResource;
use App\Rules\NoAssignmentOverlap;
use Filament\Resources\Pages\EditRecord;

class EditAssignment extends EditRecord
{
    protected static string $resource = AssignmentResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        validator($data, [
            'allocation_percent' => ['required', 'integer', 'min:0', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'project_id' => [new NoAssignmentOverlap($data['person_id'], $data['project_id'], $this->record->id)],
        ])->validate();

        return $data;
    }
}
