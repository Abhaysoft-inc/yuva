<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ShgController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DataManagementController;
use App\Http\Controllers\StaffApplicationController;
use App\Models\SHG;
use App\Models\Member;
use App\Models\Event;
use App\Models\Slide;
use App\Models\Director;
use App\Models\Gallery;
use App\Models\StaffApplication;
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
Route::post('/donate/mark-failed/{id}', [DonationController::class, 'markAsFailed'])->name('donation.markFailed');
Route::get('/donate/success/{id}', [DonationController::class, 'success'])->name('donation.success');
Route::get('/donate/failed', [DonationController::class, 'failed'])->name('donation.failed');
Route::get('/donate/receipt/{id}', [DonationController::class, 'downloadReceipt'])->name('donation.receipt');

// Public staff application form
Route::get('/apply', [StaffApplicationController::class, 'showApplicationForm'])->name('apply');
Route::post('/apply', [StaffApplicationController::class, 'submitApplication'])->name('apply.submit');

// Public ID card download (staff)
Route::get('/id-card-download', [StaffApplicationController::class, 'showIdCardDownloadForm'])->name('id-card.download');
Route::post('/id-card-download', [StaffApplicationController::class, 'searchAndDownloadIdCard'])->name('id-card.search');

Route::get('/dashboard', function () {
    $totalShgs = SHG::count();
    $totalMembers = Member::where('verification_status', 'verified')->count();
    $pendingMembers = Member::where('verification_status', 'pending')->count();
    $pendingStaffApplications = StaffApplication::where('verification_status', 'pending')->count();

    return view('dashboard', compact('totalShgs', 'totalMembers', 'pendingMembers', 'pendingStaffApplications'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // Staff-only routes (SHG and SHG Members management)
    Route::middleware('staff')->group(function () {
        Route::resource('shgs', ShgController::class);
        Route::resource('shgs.members', MemberController::class);
        Route::post('shgs/{shg}/members/{member}/create-fd', [MemberController::class, 'createFd'])->name('shgs.members.create-fd');
        Route::get('shgs/{shg}/members/{member}/fd-card', [MemberController::class, 'fdCard'])->name('shgs.members.fd-card');
        Route::get('shgs/{shg}/members/{member}/fd-card-pdf', [MemberController::class, 'fdCardPdf'])->name('shgs.members.fd-card.pdf');
        Route::get('shgs/{shg}/members/{member}/membership-form', [MemberController::class, 'membershipForm'])->name('shgs.members.membership-form');

        // Standalone member create (with SHG chooser)
        Route::get('members/create', [MemberController::class, 'createStandalone'])->name('members.create');
        Route::post('members', [MemberController::class, 'storeStandalone'])->name('members.store');
        Route::get('members', [MemberController::class, 'indexAll'])->name('members.index');

        // Member verification routes
        Route::get('members/unverified', [MemberController::class, 'unverified'])->name('members.unverified');
        Route::post('members/{member}/verify', [MemberController::class, 'verify'])->name('members.verify');
        Route::post('members/{member}/reject', [MemberController::class, 'reject'])->name('members.reject');

        // CSV exports
        Route::get('exports/members-csv', [DataManagementController::class, 'exportMembersCsv'])->name('exports.members.csv');
        Route::get('exports/shgs-csv', [DataManagementController::class, 'exportShgsCsv'])->name('exports.shgs.csv');
    });

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        // Events management
        Route::resource('events', EventController::class);

        // Slides management
        Route::resource('slides', SlideController::class);

        // Donations management
        Route::get('donations', [DonationController::class, 'index'])->name('donations.index');
        Route::get('donations/{donation}', [DonationController::class, 'show'])->name('donations.show');
        Route::post('donations/{donation}/send-receipt', [DonationController::class, 'sendReceipt'])->name('donations.sendReceipt');

        // Directors management
        Route::resource('directors', DirectorController::class);

        // Gallery management
        Route::delete('gallery/bulk-delete', [GalleryController::class, 'bulkDelete'])->name('gallery.bulk-delete');
        Route::resource('gallery', GalleryController::class);

        // Staff management
        Route::resource('staff', StaffController::class);

        // Staff applications management
        Route::get('staff-applications', [StaffApplicationController::class, 'index'])->name('staff-applications.index');
        Route::get('staff-applications/{staffApplication}', [StaffApplicationController::class, 'show'])->name('staff-applications.show');
        Route::post('staff-applications/{staffApplication}/verify', [StaffApplicationController::class, 'verify'])->name('staff-applications.verify');
        Route::post('staff-applications/{staffApplication}/reject', [StaffApplicationController::class, 'reject'])->name('staff-applications.reject');
        Route::delete('staff-applications/{staffApplication}', [StaffApplicationController::class, 'destroy'])->name('staff-applications.destroy');
        Route::get('staff-applications/{staffApplication}/id-card', [StaffApplicationController::class, 'idCard'])->name('staff-applications.id-card');
        Route::get('staff-applications/{staffApplication}/id-card-pdf', [StaffApplicationController::class, 'idCardPdf'])->name('staff-applications.id-card.pdf');

        // Full exports / backup
        Route::get('exports/all-csv', [DataManagementController::class, 'exportAllCsvZip'])->name('exports.all.csv');
        Route::get('backup/all-data', [DataManagementController::class, 'backupAllData'])->name('backup.all-data');
        Route::post('backup/restore', [DataManagementController::class, 'restoreBackup'])->name('backup.restore');

        // Settings
        Route::get('settings/contact', [SettingController::class, 'contactInfo'])->name('settings.contact');
        Route::put('settings/contact', [SettingController::class, 'updateContactInfo'])->name('settings.contact.update');
        Route::get('settings/appearance', [SettingController::class, 'appearance'])->name('settings.appearance');
        Route::put('settings/appearance', [SettingController::class, 'updateAppearance'])->name('settings.appearance.update');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
