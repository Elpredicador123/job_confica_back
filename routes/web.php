<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/import', [ImportController::class, 'index'])->name('import.index');
Route::post('/importFile', [ImportController::class, 'import'])->name('import.file');

Route::get('/importfuture', [ImportController::class, 'indexFuture'])->name('importfuture.index');
Route::post('/importfutureFile', [ImportController::class, 'importFuture'])->name('importfuture.file');

Route::get('/importgeneral', [ImportController::class, 'indexGeneral'])->name('importgeneral.index');
Route::post('/importgeneralFile', [ImportController::class, 'importGeneral'])->name('importgeneral.file');

Route::get('/importdiary', [ImportController::class, 'indexDiary'])->name('importdiary.index');
Route::post('/importdiaryFile', [ImportController::class, 'importDiary'])->name('importdiary.file');

Route::get('/importaudit', [ImportController::class, 'indexAudit'])->name('importaudit.index');
Route::post('/importauditFile', [ImportController::class, 'importAudit'])->name('importaudit.file');

Route::get('/importevidence', [ImportController::class, 'indexEvidence'])->name('importevidence.index');
Route::post('/importevidenceFile', [ImportController::class, 'importEvidence'])->name('importevidence.file');

//retornar la vista welcome
Route::get('/apis', function () {
    $routes = [];

    foreach (Route::getRoutes() as $route) {
        if (in_array('GET', $route->methods)) {
            $action = $route->getAction();

            $controllerAction = class_basename(Arr::get($action, 'controller'));
            $controller = explode('@', $controllerAction)[0];
            $action = Arr::get($action, 'as', 'Closure');
            //y la url no contenta ni la palabra show o all
            if ($action === 'Closure' && $controller !=='' && (strpos($route->uri, '/show') === false && strpos($route->uri, '/all') === false)) {
                $routes[] = [
                    'url' => $route->uri,
                    'controller' => $controller,
                    'action' => $action,
                ];
            }
        }
    }
    return view('welcome',compact('routes'));
});