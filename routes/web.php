<?php

// use App\Http\Controllers\API\ReportController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

// Route::get('aaa', [ReportController::class, 'view']);

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.'
    ], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('storePassword', [ProfileController::class, 'storePassword'])->name('password');
    });

    Route::group([
        'prefix' => 'users',
        'as' => 'users.',
        'controller' => UserController::class
    ], function () {
        Route::get('/', 'index')->name('index');
        Route::get('table', 'table')->name('table');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');

        Route::group([
            'prefix' => '{user}'
        ], function () {
            Route::get('/', 'show')->name('show');
            Route::get('edit', 'edit')->name('edit');
            Route::post('update', 'update')->name('update');
            Route::post('delete', 'delete')->name('delete');
        });
    });
});

Route::get('pull', function () {
    exec("git reset --hard HEAD && git status && git pull 2>&1", $r2);

    echo "<pre>";

    foreach ($r2 as $line) {
        echo $line . "\n";
    }
});

Route::get('migrate', function () {
    Artisan::call('migrate');
    echo Artisan::output();
});

Route::get('optimize', function () {
    Artisan::call('optimize');
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    // echo Artisan::output();
    echo "Optimized successfully.";
});
