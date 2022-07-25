<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TwoFAController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "webdevice.create" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth','twoFace']], function ($router) {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', UserController::class);
    Route::get('user-list', [UserController::class, 'userList']);
    Route::post('profile/{id}', [UserController::class, 'profileUpdate']);
    Route::get('profile-edit/{id}', [UserController::class, 'profileChange'])->name('profile.change');
    Route::post('profile-image-update/{id}', [UserController::class, 'profileImage'])->name('profile.image');
    Route::resource('device', DeviceController::class);
    Route::post('device-update', [DeviceController::class,'deviceUpdate']);
    Route::post('device-not-update', [DeviceController::class,'deviceNotUpdate']);
    Route::get('device-types', [DeviceController::class, 'deviceTypes']);
    Route::get('all-device-list', [DeviceController::class,'allDeviceList']);
    Route::resource('email', MailController::class);
    Route::get('notifications', [NotificationController::class, 'unreadNotifications']);
    Route::get('notifications', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('notification/{id}', [NotificationController::class, 'show'])->name('notification.show');
    Route::resource('activity', ActivityController::class);
    Route::post('activity-status/{id}', [ActivityController::class,'activityStatus']);
    Route::get('activity-list', [ActivityController::class, 'activityList']);

    Route::resource('ticket', TicketController::class);
    Route::get('ticket-solved/{id}', [TicketController::class,'solveTicket'])->name('ticket.solved');
    Route::get('ticket-unsolved/{id}', [TicketController::class,'unsolveTicket'])->name('ticket.unsolved');

    Route::get('setting', [ConfigController::class, 'index'])->name('config.index');
    Route::post('setting', [ConfigController::class, 'store'])->name('config.store');
    Route::resource('pdf', PdfController::class);
    Route::resource('video', VideoController::class);
    Route::get('pdf-delete/{id}', [PdfController::class,'destroy'])->name('pdf.delete');
    Route::get('video-delete/{id}', [VideoController::class,'destroy'])->name('video.delete');
//    Route::get('video', [ConfigController::class, 'videoPage'])->name('create.video');
//    Route::post('video-store', [ConfigController::class, 'videoStore'])->name('video.store');

    Route::get('device-category/{id}', [DeviceController::class, 'getDeviceByCategory'])->name('device.category.show');
    Route::get('device-list-by-type/{id}', [DeviceController::class, 'deviceListByType']);

    Route::get('not-updated-device', [DeviceController::class, 'notUpdatedDeviceView'])->name('device.not.updated');
    Route::get('not-updated-device-list', [DeviceController::class, 'notUpdatedDeviceList']);
});
Route::resource('two-step-verification', TwoFAController::class);
Route::get('reset', [AuthenticatedSessionController::class, 'resend'])->name('resend');
