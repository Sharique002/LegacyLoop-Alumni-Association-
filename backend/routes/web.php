<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\AlumniController;
use App\Http\Controllers\Web\JobController;
use App\Http\Controllers\Web\EventController;
use App\Http\Controllers\Web\NetworkingController;
use App\Http\Controllers\Web\SuccessStoryController;
use App\Http\Controllers\Web\DonationController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// Theme Switch: Visit /switch-theme/modern or /switch-theme/classic
// ==========================================
Route::get('/switch-theme/{theme}', function ($theme) {
    session(['ui_theme' => $theme === 'modern' ? 'modern' : 'classic']);
    return back()->with('success', 'Theme switched to ' . $theme);
})->name('switch.theme');

// ==========================================
// MODERN UI Routes (New Tailwind Design)
// ==========================================
Route::prefix('modern')->name('modern.')->group(function () {
    // Landing
    Route::get('/', fn() => view('modern.landing'))->name('landing');
    
    // Auth
    Route::get('/login', fn() => view('modern.auth.login'))->name('login');
    Route::get('/register', fn() => view('modern.auth.register'))->name('register');
});

Route::middleware('auth')->prefix('modern')->name('modern.')->group(function () {
    Route::get('/dashboard', fn() => view('modern.dashboard'))->name('dashboard');
    Route::get('/jobs', fn() => view('modern.jobs'))->name('jobs');
    Route::get('/events', fn() => view('modern.events'))->name('events');
    Route::get('/network', fn() => view('modern.network'))->name('network');
    Route::get('/chat', fn() => view('modern.chat'))->name('chat');
    Route::get('/feed', fn() => view('modern.feed'))->name('feed');
    Route::get('/mentorship', fn() => view('modern.mentorship'))->name('mentorship');
    Route::get('/profile', fn() => view('modern.profile'))->name('profile');
});

// ==========================================
// ORIGINAL Routes (Classic Dark Theme)
// ==========================================

// Landing page
Route::get('/', function () {
    // Check session for theme preference
    if (session('ui_theme') === 'modern') {
        return view('modern.landing');
    }
    return view('landing');
})->name('home');

// ==========================================
// Minimal Frontend Routes (Blade)
// ==========================================
Route::prefix('minimal')->name('minimal.')->group(function () {
    Route::get('/', fn() => view('minimal.home'))->name('home');
    Route::get('/status', fn() => view('minimal.status'))->name('status');
    Route::get('/about', fn() => view('minimal.about'))->name('about');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        if (session('ui_theme') === 'modern') {
            return view('modern.auth.login');
        }
        return app(AuthController::class)->showLoginForm();
    })->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    
    Route::get('/register', function () {
        if (session('ui_theme') === 'modern') {
            return view('modern.auth.register');
        }
        return app(AuthController::class)->showRegisterForm();
    })->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        if (session('ui_theme') === 'modern') {
            return view('modern.dashboard');
        }
        return app(DashboardController::class)->index();
    })->name('dashboard');

    // Alumni Directory
    Route::get('/alumni', function (Request $request) {
        if (session('ui_theme') === 'modern') {
            return view('modern.network');
        }
        return app(AlumniController::class)->index($request);
    })->name('alumni.index');
    Route::get('/alumni/{alumni}', [AlumniController::class, 'show'])->name('alumni.show');

    // Jobs
    Route::get('/jobs', function (Request $request) {
        if (session('ui_theme') === 'modern') {
            return view('modern.jobs');
        }
        return app(JobController::class)->index($request);
    })->name('jobs.index');
    Route::resource('jobs', JobController::class)->except(['index']);
    Route::post('/jobs/{job}/apply', [JobController::class, 'apply'])->name('jobs.apply');
    Route::get('/jobs/{job}/applications', [JobController::class, 'applications'])->name('jobs.applications');
    Route::patch('/jobs/{job}/application/{application}/status', [JobController::class, 'updateApplicationStatus'])
        ->name('jobs.application.status');

    // Events
    Route::get('/events', function (Request $request) {
        if (session('ui_theme') === 'modern') {
            return view('modern.events');
        }
        return app(EventController::class)->index($request);
    })->name('events.index');
    Route::resource('events', EventController::class)->except(['index']);
    Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');
    Route::post('/events/{event}/unregister', [EventController::class, 'unregister'])->name('events.unregister');

    // Networking & Connections
    Route::prefix('networking')->name('networking.')->group(function () {
        Route::get('/', function () {
            if (session('ui_theme') === 'modern') {
                return view('modern.chat');
            }
            return app(NetworkingController::class)->index();
        })->name('index');
        Route::get('/connections', [NetworkingController::class, 'connections'])->name('connections');
        Route::post('/connect/{user}', [NetworkingController::class, 'sendRequest'])->name('send');
        Route::post('/accept/{connection}', [NetworkingController::class, 'acceptRequest'])->name('accept');
        Route::post('/reject/{connection}', [NetworkingController::class, 'rejectRequest'])->name('reject');

        // Messages
        Route::get('/messages', function () {
            if (session('ui_theme') === 'modern') {
                return view('modern.chat');
            }
            return app(NetworkingController::class)->messages();
        })->name('messages');
        Route::get('/messages/{user}', [NetworkingController::class, 'conversation'])->name('conversation');
        Route::post('/messages/{user}', [NetworkingController::class, 'sendMessage'])->name('send-message');
    });

    // Connection endpoints
    Route::post('/connections/send', [NetworkingController::class, 'sendRequest'])->name('connections.send');

    // Success Stories
    Route::resource('stories', SuccessStoryController::class);

    // Donations
    Route::resource('donations', DonationController::class)->only(['index', 'show', 'create', 'store']);

    // Feed & Mentorship (Modern UI only)
    Route::get('/feed', fn() => view('modern.feed'))->name('feed');
    Route::get('/mentorship', fn() => view('modern.mentorship'))->name('mentorship');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
        Route::delete('/avatar', [ProfileController::class, 'removeAvatar'])->name('avatar.remove');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
        Route::put('/settings', [ProfileController::class, 'updateSettings'])->name('settings.update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
        Route::get('/view', fn() => view('modern.profile'))->name('view');
    });

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::patch('/users/{user}/status', [AdminController::class, 'toggleUserStatus'])->name('users.status');
        Route::resource('stories', AdminController::class)->only(['index', 'update', 'destroy']);
        Route::post('/stories/{story}/approve', [AdminController::class, 'approveStory'])->name('stories.approve');
        Route::post('/stories/{story}/reject', [AdminController::class, 'rejectStory'])->name('stories.reject');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    });
});

// ==========================================
// ORGANIZATION/UNIVERSITY Routes
// ==========================================
use App\Http\Controllers\Web\OrganizationAuthController;
use App\Http\Controllers\Web\OrganizationController;

// Organization Auth (Guest)
Route::middleware('guest:organization')->prefix('organization')->name('organization.')->group(function () {
    Route::get('/login', [OrganizationAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [OrganizationAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [OrganizationAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [OrganizationAuthController::class, 'register'])->name('register.submit');
});

// Organization Protected Routes
Route::middleware('auth.organization')->prefix('organization')->name('organization.')->group(function () {
    Route::post('/logout', [OrganizationAuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [OrganizationController::class, 'dashboard'])->name('dashboard');
    
    // Alumni
    Route::get('/alumni', [OrganizationController::class, 'alumni'])->name('alumni');
    
    // Events
    Route::get('/events', [OrganizationController::class, 'events'])->name('events');
    Route::get('/events/create', [OrganizationController::class, 'createEvent'])->name('events.create');
    Route::post('/events', [OrganizationController::class, 'storeEvent'])->name('events.store');
    Route::get('/events/{id}/edit', [OrganizationController::class, 'editEvent'])->name('events.edit');
    Route::put('/events/{id}', [OrganizationController::class, 'updateEvent'])->name('events.update');
    Route::delete('/events/{id}', [OrganizationController::class, 'deleteEvent'])->name('events.destroy');

    // Announcements
    Route::get('/announcements', [OrganizationController::class, 'announcements'])->name('announcements');
    Route::get('/announcements/create', [OrganizationController::class, 'createAnnouncement'])->name('announcements.create');
    Route::post('/announcements', [OrganizationController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::get('/announcements/{id}/edit', [OrganizationController::class, 'editAnnouncement'])->name('announcements.edit');
    Route::put('/announcements/{id}', [OrganizationController::class, 'updateAnnouncement'])->name('announcements.update');
    Route::delete('/announcements/{id}', [OrganizationController::class, 'deleteAnnouncement'])->name('announcements.destroy');

    // Job Postings
    Route::get('/jobs', [OrganizationController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/create', [OrganizationController::class, 'createJob'])->name('jobs.create');
    Route::post('/jobs', [OrganizationController::class, 'storeJob'])->name('jobs.store');
    Route::get('/jobs/{id}/edit', [OrganizationController::class, 'editJob'])->name('jobs.edit');
    Route::put('/jobs/{id}', [OrganizationController::class, 'updateJob'])->name('jobs.update');
    Route::delete('/jobs/{id}', [OrganizationController::class, 'deleteJob'])->name('jobs.destroy');
    Route::get('/jobs/{id}/applications', [OrganizationController::class, 'jobApplications'])->name('jobs.applications');

    // Donation Campaigns
    Route::get('/donations', [OrganizationController::class, 'donations'])->name('donations');
    Route::get('/donations/create', [OrganizationController::class, 'createDonation'])->name('donations.create');
    Route::post('/donations', [OrganizationController::class, 'storeDonation'])->name('donations.store');
    Route::get('/donations/{id}/edit', [OrganizationController::class, 'editDonation'])->name('donations.edit');
    Route::get('/donations/{id}', [OrganizationController::class, 'showDonation'])->name('donations.show');

    // Alumni Messages
    Route::get('/messages', [OrganizationController::class, 'messages'])->name('messages');
    Route::get('/messages/create', [OrganizationController::class, 'createMessage'])->name('messages.create');
    Route::post('/messages', [OrganizationController::class, 'storeMessage'])->name('messages.store');
    Route::get('/messages/{id}', [OrganizationController::class, 'showMessage'])->name('messages.show');

    // Success Stories Management
    Route::get('/stories', [OrganizationController::class, 'stories'])->name('stories');
    Route::get('/stories/{id}', [OrganizationController::class, 'showStory'])->name('stories.show');
    Route::post('/stories/{id}/approve', [OrganizationController::class, 'approveStory'])->name('stories.approve');
    Route::post('/stories/{id}/feature', [OrganizationController::class, 'featureStory'])->name('stories.feature');

    // Analytics
    Route::get('/analytics', [OrganizationController::class, 'analytics'])->name('analytics');
    Route::get('/analytics/export', [OrganizationController::class, 'exportAnalytics'])->name('analytics.export');
    
    // Profile
    Route::get('/profile', [OrganizationController::class, 'profile'])->name('profile');
    Route::put('/profile', [OrganizationController::class, 'updateProfile'])->name('profile.update');
});
