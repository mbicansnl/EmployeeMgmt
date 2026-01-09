<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditObserver
{
    public function created(Model $model): void
    {
        $this->record('created', $model);
    }

    public function updated(Model $model): void
    {
        $this->record('updated', $model);
    }

    public function deleted(Model $model): void
    {
        $this->record('deleted', $model);
    }

    private function record(string $action, Model $model): void
    {
        AuditLog::query()->create([
            'user_id' => Auth::id(),
            'action' => $action,
            'subject_type' => $model::class,
            'subject_id' => $model->getKey(),
            'metadata' => [
                'changes' => $model->getChanges(),
            ],
        ]);
    }
}
