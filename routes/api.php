<?php

declare(strict_types=1);

use App\Http\Controllers\LocalDirectoryImportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::post('/people/import', LocalDirectoryImportController::class)->name('people.import');
});
