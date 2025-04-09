<?php

use App\Livewire\MasterData\Inspection\QuestionInspection;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('master-data.inspection.questions');
});

Route::prefix('master-data')->name('master-data.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('master-data.inspection.questions');
    });
    Route::prefix('inspection')->name('inspection.')->group(function () {
        Route::get('questions', QuestionInspection::class)->name('questions');
    });
});

Route::prefix('unit-inspection')->name('unit-inspection.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('unit-inspection.inspection');
    });
    Route::get('inspection', \App\Livewire\UnitInspection\Inspection::class)->name('inspection');
    Route::get('history', \App\Livewire\UnitInspection\History::class)->name('history');
});
