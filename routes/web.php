<?php

use App\Http\Controllers\ContactController;
use App\Models\Contact;
use Illuminate\Support\Facades\Route;

Route::get('/contact', function () {
    return view('welcome');
})->name('contact');
Route::get('/contact-list', function () {
    $contacts = Contact::all();
    return view('pdflist',compact('contacts'));
})->name('contact.list');
Route::get('/contact-download/{id}',[ContactController::class,'download'])->name('contact.download');

Route::post('/contact',[ContactController::class,'store'])->name('contact.store');
