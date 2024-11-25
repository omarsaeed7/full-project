<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
/* The CRUD Routes Maker */
//  Route::resource('courses', CourseController::class);
/* ->> <<- */
/* Showing Data Routes */
Route::get('/', [CourseController::class, 'index']);
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

Route::get('/courses/trash', [CourseController::class, 'trash'])->name('courses.trash');
// post ? cause we are updating | {course} ? to send the id for restoring it |
Route::get('/courses/{course}/restore', [CourseController::class,'restore'])->name('courses.restore');

Route::get('courses/{course}', [CourseController::class, 'show'])->name('courses.show')->whereNumber('course');
/* ->> End Showing Data Routes <<- */

/* Creating Data Routes */
Route::get('courses/create', [CourseController::class, 'create'])->name('courses.create');
Route::post('courses', [CourseController::class, 'store'])->name('courses.store');
/* ->> End Creating Data Routs <<- */

/* Updating Data Routes */
Route::get('courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
Route::put('courses/{course}', [CourseController::class, 'update'])->name('courses.update');
/* ->> End Updating Data Routes <<- */

/* Deleting Data Route */
Route::delete('courses/{course}', [CourseController::class, 'delete'])->name('courses.delete');
Route::delete('courses/{course}/destroy', [CourseController::class, 'destroy'])->name('courses.destroy');
/* ->> End Deleting Data Route <<- */




//
