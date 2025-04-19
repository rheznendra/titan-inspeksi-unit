<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\MasterData\Inspection\QuestionInspection;
use App\Livewire\Home;
use App\Http\Controllers\Export\UnitInspectionExport;



Route::get('/', Home::class)->name('home');
Route::get('/inspeksi', \App\Livewire\UnitInspection\Inspection::class)->name('inspection');
Route::get('{ulid}/pdf', [UnitInspectionExport::class, 'export'])->name('pdf');

if (env('APP_ENV') === 'local') {
    Route::prefix('master-data')->name('master-data.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('master-data.inspection.questions');
        });
        Route::prefix('inspection')->name('inspection.')->group(function () {
            Route::get('questions', QuestionInspection::class)->name('questions');
        });
    });
}
