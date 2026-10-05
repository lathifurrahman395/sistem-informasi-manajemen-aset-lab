<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ===== Tambahkan blok ini ke routes/web.php =====

use App\Http\Controllers\LabSchedulePdfController;

Route::get('/admin/lab-schedules/pdf-all', [LabSchedulePdfController::class, 'all'])
    ->name('lab-schedule.pdf.all');
