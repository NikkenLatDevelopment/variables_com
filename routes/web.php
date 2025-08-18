<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\variablesCom;
use App\Http\Controllers\varComUsa;

Route::get('/', function () {
    return view('welcome');
});

Route::get("varcomusa24",  [variablesCom::class, 'varcomusa24'])->name('varcomusa24');
Route::get("varcomusa24nalat",  [variablesCom::class, 'varcomusa24nalat'])->name('varcomusa24nalat');

Route::get("accesVariablesCom",  [variablesCom::class, 'accesVariablesCom'])->name('accesVariablesCom');
Route::get("varcomlat24",  [variablesCom::class, 'varcomlat24'])->name('varcomlat24');

Route::get('/reporte/{variable}', [variablesCom::class, 'mostrarReporte']);
Route::get('/reporte-pdf/{variable}', [variablesCom::class, 'generarPDF'])->name('reporte.pdf');
Route::post('/guardar-imagen', [TuControlador::class, 'guardarImagen']);

Route::get("varcomusa",  [varComUsa::class, 'varcomusa'])->name('varcomusa');
Route::get("varcomusa12",  [varComUsa::class, 'varcomusa12'])->name('varcomusa12');

Route::get("varcomusa_impresiones",  [varComUsa::class, 'varcomusa_impresiones'])->name('varcomusa_impresiones');
