<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ShgController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\GalleryController;
use App\Models\SHG;
use App\Models\Member;
use App\Models\Event;
use App\Models\Slide;
use App\Models\Director;
use App\Models\Gallery;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $upcomingEvents = Event::upcoming()->take(3)->get();
    $slides = Slide::where('is_active', true)->orderBy('order')->get();
    $directors = Director::where('is_active', true)->orderBy('order')->get();
    $galleryImages = Gallery::where('is_active', true)->orderBy('order')->take(12)->get();
    return view('welcome', compact('upcomingEvents', 'slides', 'directors', 'galleryImages'));
});

// Public member application form
Route::get('/apply', [MemberController::class, 'showApplicationForm'])->name('apply');
Route::post('/apply', [MemberController::class, 'submitApplication'])->name('apply.submit');

// Public ID card download
Route::get('/id-card-download', [MemberController::class, 'showIdCardDownloadForm'])->name('id-card.download');
Route::post('/id-card-download', [MemberController::class, 'searchAndDownloadIdCard'])->name('id-card.search');

Route::get('/dashboard', function () {
    $totalShgs = SHG::count();
    $totalMembers = Member::where('verification_status', 'verified')->count();
    $pendingMembers = Member::where('verification_status', 'pending')->count();

    return view('dashboard', compact('totalShgs', 'totalMembers', 'pendingMembers'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::resource('shgs', ShgController::class);
    Route::resource('shgs.members', MemberController::class);
    Route::get('shgs/{shg}/members/{member}/id-card', [MemberController::class, 'idCard'])->name('shgs.members.id-card');
    Route::get('shgs/{shg}/members/{member}/membership-form', [MemberController::class, 'membershipForm'])->name('shgs.members.membership-form');

    // Standalone member create (with SHG chooser)
    Route::get('members/create', [MemberController::class, 'createStandalone'])->name('members.create');
    Route::post('members', [MemberController::class, 'storeStandalone'])->name('members.store');
    Route::get('members', [MemberController::class, 'indexAll'])->name('members.index');

    // Member verification routes
    Route::get('members/unverified', [MemberController::class, 'unverified'])->name('members.unverified');
    Route::post('members/{member}/verify', [MemberController::class, 'verify'])->name('members.verify');
    Route::post('members/{member}/reject', [MemberController::class, 'reject'])->name('members.reject');

    // Events management
    Route::resource('events', EventController::class);

    // Slides management
    Route::resource('slides', SlideController::class);

    // Directors management
    Route::resource('directors', DirectorController::class);

    // Gallery management
    Route::resource('gallery', GalleryController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
