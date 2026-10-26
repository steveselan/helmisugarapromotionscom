<?php

use App\Http\Controllers\BuktisiarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LiputanController;
use App\Http\Controllers\MediaplanController;
use App\Http\Controllers\NeweventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatecardController;
use App\Http\Controllers\UndanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class ,'index']);

Route::get('/liputan/listrsvp/{judul}', [LiputanController::class, 'listrsvp']);
Route::get('/liputan/formrsvp/{judul}', [LiputanController::class, 'formrsvp']);
Route::post('/liputan/checkemail', [LiputanController::class, 'checkemail'])->name('liputan.checkemail');
Route::get('/liputan/thankyou/{judul}', [LiputanController::class, 'thankyou']);
Route::delete('/liputan/listrsvp/{id}', [LiputanController::class, 'destroy'])->name('liputan.destroy');

Route::resource('liputan', LiputanController::class);

Route::get('/dashboard', function () {
    return view('pages.beranda');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // --- BAWAAN BREEZE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //--- PUNYA STEVE
    Route::resource('kategori',KategoriController::class); //membuat routing menggunakan resource
    Route::resource('newevent', NeweventController::class);
    Route::get('/newevent/{id}/json', [NeweventController::class, 'getJsonData'])->name('newevent.json');

    Route::resource('undangan', UndanganController::class);
    Route::get('/undangan/{id}/edit', [UndanganController::class, 'edit'])->name('undangan.edit');
    Route::get('/undangan/{id}/update', [UndanganController::class, 'update'])->name('undangan.update');
    Route::get('/undangan/listrsvpundangan/{judul}', [UndanganController::class, 'listrsvpundangan']);

    Route::resource('/ratecard', RatecardController::class);
    Route::get('/ratecard/create', [RatecardController::class, 'create'])->name('media.create');
    Route::post('/ratecard/store', [RatecardController::class, 'store'])->name('media.store');
    Route::get('/ratecard/show/{id}', [RatecardController::class, 'show']);
    Route::get('/ratecard/edit/{id}', [RatecardController::class, 'edit']);

    Route::resource('/mediaplan', MediaplanController::class);
    Route::get('/mediaplan/show/{id}', [MediaplanController::class, 'show'])->name('mediaplan.show');
    Route::get('/mediaplan/{id}/edit', [MediaplanController::class, 'edit'])->name('mediaplan.edit');
    Route::put('/mediaplan/{id}/update', [MediaplanController::class, 'update'])->name('mediaplan.update');


    Route::resource('buktisiar', BuktisiarController::class);

    // Membuka form upload untuk 1 item promosi spesifik
    Route::get('/buktisiar/event/{event_id}/', [BuktisiarController::class, 'detailMediaplan'])->name('buktisiar.gabungan');

    Route::get('/buktisiar/create/{id_detail}', [BuktisiarController::class, 'createPerItem'])->name('buktisiar.item.create');

    // Menyimpan bukti siar untuk item tersebut
    Route::post('/buktisiar/store/{id_detail}', [BuktisiarController::class, 'storePerItem'])->name('buktisiar.item.store');

    // menghapus bukti siar
    Route::delete('buktisiar/{id_buktisiar', [BuktisiarController::class ,'destroy'])->name('buktisiar.destroy');
});

require __DIR__.'/auth.php';
