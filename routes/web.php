<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ShgController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DonationController;
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
    $galleryImages = Gallery::where('is_active', true)->orderBy('order')->take(6)->get();
    return view('welcome', compact('upcomingEvents', 'slides', 'directors', 'galleryImages'));
});

// Public gallery page
Route::get('/photos', function () {
    $galleryImages = Gallery::where('is_active', true)->orderBy('order')->get();
    return view('gallery.public', compact('galleryImages'));
})->name('gallery.public');

// About Us page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Us page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Public donation routes
Route::get('/donate', [DonationController::class, 'showDonationForm'])->name('donate');
Route::post('/donate/initiate', [DonationController::class, 'initiatePayment'])->name('donation.initiate');
Route::post('/donate/verify', [DonationController::class, 'verifyPayment'])->name('donation.verify');
Route::get('/donate/success/{id}', [DonationController::class, 'success'])->name('donation.success');
Route::get('/donate/failed', [DonationController::class, 'failed'])->name('donation.failed');

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
    // Donations management (Admin)
    Route::get('donations', [DonationController::class, 'index'])->name('donations.index');
    Route::get('donations/{donation}', [DonationController::class, 'show'])->name('donations.show');


    // Directors management
    Route::resource('directors', DirectorController::class);

    // Gallery management
    Route::resource('gallery', GalleryController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
