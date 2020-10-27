<?php

use FreshinUp\ActivityApi\Controllers\Api\v1\ActivityController;
use FreshinUp\ActivityApi\Controllers\Api\v1\NoteController;
use FreshinUp\ActivityApi\Controllers\Api\v1\ReminderUnitController;
use FreshinUp\ActivityApi\Controllers\Api\v1\SavedSearchController;
use FreshinUp\ActivityApi\Controllers\Api\v1\StatusController;
use FreshinUp\ActivityApi\Controllers\Api\v1\TypeController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => config('fresh-activity-api.prefix'),
        'middleware' => config('fresh-activity-api.middlewares'),
    ],
    function () {
        Route::group([
            'prefix' => 'v1'
        ], function () {
            Route::apiResource('saved-searches', SavedSearchController::class);
            Route::apiResource('activities', ActivityController::class);
            Route::post('/activities/{uuid}/notes', [ActivityController::class, 'storeNotes'])->name('activities.notes');
            Route::put('/activities/{uuid}/notes', [ActivityController::class, 'updateNotes'])->name('activities.updateNotes');
            Route::apiResource('statuses', StatusController::class);
            Route::apiResource('types', TypeController::class);
            Route::apiResource('reminder-unities', ReminderUnitController::class);
        });
    }
);
