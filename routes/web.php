<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ShgController;
use App\Models\SHG;
use App\Models\Member;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalShgs = SHG::count();
    $totalMembers = Member::count();

    return view('dashboard', compact('totalShgs', 'totalMembers'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::resource('shgs', ShgController::class);
    Route::resource('shgs.members', MemberController::class);
    Route::get('shgs/{shg}/members/{member}/id-card', [MemberController::class, 'idCard'])->name('shgs.members.id-card');
    Route::get('shgs/{shg}/members/{member}/membership-form', [MemberController::class, 'membershipForm'])->name('shgs.members.membership-form');

    // Standalone member create (with SHG chooser)
    Route::get('members/create', [MemberController::class, 'createStandalone'])->name('members.create');
    Route::post('members', [MemberController::class, 'storeStandalone'])->name('members.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
