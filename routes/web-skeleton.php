<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/=
Route::group(['middleware' => ['web']], function () {
    // your routes here
    // Route::get('/', function () {
    //     // return 'Hello Skeleton';
    //     // die(var_export(Route::current(), true));
    //     return Inertia::render('Skeleton', [
    //         // TODO: Add an active authorization filter here to detect whether a user is logged in,
    //         // and slash or repair the use of the auth.prefix, which looks like it may refer to the auth file in roots,
    //         // which may mean that all references to it need to change
    //         'canSkeleton' => Route::has('skeleton'),
    //         'canRegister' => Route::has('register'),
    //         'laravelVersion' => Application::VERSION,
    //         'phpVersion' => PHP_VERSION,
    //     ]);
    // });

    // Route::get('/skeleton', function () {
    //     return Inertia::render('Skeleton');
    // })->middleware(['auth', 'verified'])->name('skeleton');

    Route::get(
        '/skeleton-add/{a}/{b}',
        'VendorName\Skeleton\Http\Controllers\SkeletonController@add'
    );

});

require __DIR__.'/auth-skeleton.php';
