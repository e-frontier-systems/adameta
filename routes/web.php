<?php

use App\Http\Controllers\MetadataController;
use App\Http\Controllers\PoolController;
use App\Http\Controllers\TickerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//\Illuminate\Auth\Middleware\Authenticate::redirectUsing(function(\Illuminate\Http\Request $request) {
//    $request->session()->flash('status', 'セッションがタイムアウトしました。');
//    return redirect('login');
//});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
/*
->group(function () {
    Route::get('/ticker', function () {
        return Inertia::render('Ticker');
    })->name('ticker');
});
*/

Route::middleware('auth')->group(function () {

    Route::get('/ticker', [TickerController::class, 'list'])->name('ticker');
    Route::get('/metadata/get', [MetadataController::class, 'getByTickerId'])->name('get-by-ticker-id');
    Route::post('/metadata/new', [MetadataController::class, 'update'])->name('ticker-metadata.update');
    Route::get('/metadata/show', [MetadataController::class, 'show'])->name('metadata.show');

});

Route::middleware('auth')->group(function() {

    Route::get('/pool', [PoolController::class, 'index'])->name('pool');

});

Route::get('/md/{ticker}/poolMetaData.json', [MetadataController::class, 'showPublic'])->name('public_metadata');

/*
Route::get('/ticker', function() {
    return Inertia::render('Ticker', [
        'tickers' => \App\Models\Ticker::all(),
    ]);
})->name('ticker');
*/
