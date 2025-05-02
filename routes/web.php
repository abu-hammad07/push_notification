<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PushNotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/keys', [NotificationController::class, 'storeKeys'])->name('notifications.storeKeys');
Route::post('/notifications/send', [NotificationController::class, 'send'])->name('notifications.send');


Route::view('push-notification', 'PushNotification/index');
Route::post('save-push-notification-sub', [PushNotificationController::class, 'saveSubscription']);
Route::post('send-push-notification', [PushNotificationController::class, 'sendNotification']);
