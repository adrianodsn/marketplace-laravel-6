<?php

use App\Models\Store;
use App\Notifications\StoreReceiveNewOrder;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('product/{slug}', 'HomeController@single')->name('product.single');
Route::get('category/{slug}', 'CategoryController@index')->name('category.single');
Route::get('store/{slug}', 'StoreController@index')->name('store.single');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('', 'CartController@index')->name('index');
    Route::post('add', 'CartController@add')->name('add');
    Route::delete('remove', 'CartController@remove')->name('remove');
    Route::delete('cancel', 'CartController@cancel')->name('cancel');
});

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('', 'CheckoutController@index')->name('index');
    Route::post('proccess', 'CheckoutController@proccess')->name('proccess');
    Route::get('thanks', 'CheckoutController@thanks')->name('thanks');
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('orders', 'OrdersController@index')->name('orders');

    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {

        Route::get('', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('notifications', 'NotificationsController@index')->name('notifications');

        Route::get('notifications/read/{notification}', 'NotificationsController@read')->name('notifications.read');

        Route::get('notifications/read-all', 'NotificationsController@readAll')->name('notifications.read.all');

        Route::resource('stores', 'StoreController');
        Route::resource('products', 'ProductController');
        Route::resource('categories', 'CategoryController');

        Route::delete('photos/remove', 'ProductPhotoController@removePhoto')->name('photo.remove');

        Route::get('orders', 'OrdersController@index')->name('orders');
    });
});

Route::get('not', function () {
    $user = User::find(40);

    //$user->notify(new StoreReceiveNewOrder());
    //$notifications = $user->unreadNotifications;
    // $notification = $notifications->first();
    // $notification->markAsRead();

    return $user->readNotifications;
});

Auth::routes();
