<?php

use App\Http\Controllers\Export\UnitInspectionExport;
use App\Livewire\MasterData\Inspection\QuestionInspection;
use App\Livewire\UnitInspection\History;
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
    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/', History::class)->name('index');
        Route::get('{ulid}/pdf', [UnitInspectionExport::class, 'export'])->name('pdf');
    });
});
