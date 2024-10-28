<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\variablesCom;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("varcomusa24",  [variablesCom::class, 'varcomusa24'])->name('varcomusa24');
Route::get("varcomusa24nalat",  [variablesCom::class, 'varcomusa24nalat'])->name('varcomusa24nalat');

Route::get("accesVariablesCom",  [variablesCom::class, 'accesVariablesCom'])->name('accesVariablesCom');
Route::get("varcomlat24",  [variablesCom::class, 'varcomlat24'])->name('varcomlat24');

Route::get('/reporte/{variable}', [variablesCom::class, 'mostrarReporte']);
