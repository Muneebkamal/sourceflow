<?php

use App\Http\Controllers\BuylistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\OACLeadController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SmartDataController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'index'])->name('profile.update');
    //dashboard route
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    //Smart Data route
    Route::get('/smart-data', [SmartDataController::class, 'index'])->name('smart.data');
    Route::get('/get-smart-data', [SmartDataController::class, 'getSmartData'])->name('get.smart.data');


    // Buylists route
    Route::get('/buylists', [BuylistController::class, 'index'])->name('buylists.index');
    Route::get('/buylists/rejected', [BuylistController::class, 'rejected'])->name('buylists.rejected');
    Route::get('/buylist/data', [BuyListController::class, 'getData'])->name('buylist.data');
    Route::get('/buylist/rejected/data', [BuyListController::class, 'getDataRejected'])->name('buylist.data.rejected');

    // Orders routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders-items', [OrderController::class, 'ordersItems'])->name('orders.items');
    Route::get('/orders/data', [OrderController::class, 'getData'])->name('orders.data');
     Route::get('/orders-items/data', [OrderController::class, 'getDataOrdersItems'])->name('data.orders.items');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/order/{order}/items', [OrderController::class, 'getOrderItems'])->name('order.items');
    Route::get('buy-cost-calculator/{order}', [OrderController::class, 'buyCostCalculator'])->name('buy.cost.calculator');
    Route::post('/orders/update/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::post('/orders/{id}/update-info', [OrderController::class, 'updateInfo'])->name('orders.updateInfo');
    Route::post('/orders/{id}/update-payment', [OrderController::class, 'updatePayment'])->name('orders.updatePayment');
    Route::post('/orders/{id}/update-note', [OrderController::class, 'updateNote'])->name('orders.updateNote');



    // Shipping routes
    Route::get('/shipping-batches', [ShippingController::class, 'index'])->name('shipping.index');
    Route::get('/shipping-data', [ShippingController::class, 'getData'])->name('shipping.data');

    // Leads routes
    Route::get('/team-leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/data', [LeadController::class, 'getData'])->name('leads.data');

    Route::get('/templates/{id}/details', [LeadController::class, 'details'])->name('templates.details');

    // OAC routes
    Route::get('/oacleads', [OACLeadController::class, 'index'])->name('oac.leads.index');

    // Settings routes
    Route::get('/user/profile', [SettingController::class, 'index'])->name('setting.index');
});

