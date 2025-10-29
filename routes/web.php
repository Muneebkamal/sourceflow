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
use App\Http\Controllers\TagController;
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

    Route::post('/tags/store', [TagController::class, 'store'])->name('tags.store');
    Route::post('/tags/{id}/update', [TagController::class, 'update'])->name('tags.update');
    Route::post('/tags/{id}/delete', [TagController::class, 'destroy'])->name('tags.delete');
    Route::get('smart-data/lead/{id}', [SmartDataController::class, 'showSmartData'])->name('smart.data.lead');



    // Buylists route
    Route::get('/buylists', [BuylistController::class, 'index'])->name('buylists.index');
    Route::get('/buylists/rejected', [BuylistController::class, 'rejected'])->name('buylists.rejected');
    Route::get('/buylist/data', [BuyListController::class, 'getData'])->name('buylist.data');
    Route::get('/buylist/rejected/data', [BuyListController::class, 'getDataRejected'])->name('buylist.data.rejected');
    Route::post('/orders/reject-items-bulk', [BuyListController::class, 'rejectItemsBulk'])->name('orders.rejectItemsBulk');
    Route::delete('/buylist/{id}', [BuylistController::class, 'destroyBuylistItem'])->name('buylist.destroy');
    Route::post('/buylist/bulk-delete', [BuylistController::class, 'bulkDelete'])->name('buylist.bulkDelete');
    Route::post('/buylist/{id}/duplicate', [BuyListController::class, 'duplicateItem'])->name('buylist.duplicateItem');
    Route::post('/buylist/move-items', [BuylistController::class, 'moveItems'])->name('buylist.moveItems');
    Route::post('/buylist/store', [BuylistController::class, 'store'])->name('buylist.store');
    Route::delete('/buylist/{id}/delete', [BuylistController::class, 'destroy'])->name('buylist.destroy');
    Route::post('/items/{itemId?}/create-order', [BuylistController::class, 'createSingleOrder']);
    Route::post('/create/multiple/items/orders', [BuylistController::class, 'createMultipleItemsOrder'])->name('orders.createMultiple');


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
    Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/bulk-update-status', [OrderController::class, 'bulkUpdateStatus'])->name('orders.bulkUpdateStatus');
    Route::post('/orders/bulk-delete', [OrderController::class, 'bulkDelete'])->name('orders.bulkDelete');
    Route::post('/orders/single-delete', [OrderController::class, 'singleDelete'])->name('orders.singleDelete');
    Route::post('/orders/update-item', [OrderController::class, 'updateItem'])->name('orders.updateItem');
    Route::post('/orders/duplicate', [OrderController::class, 'duplicate'])->name('orders.duplicate');
    Route::post('/create-order', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/{order}/update-full', [OrderController::class, 'updateFull'])->name('orders.updateFull');
    Route::post('/orders/delete-line-item', [OrderController::class, 'deleteLineItem'])->name('orders.deleteLineItem');


    // Shipping routes
    Route::get('/shipping-batches', [ShippingController::class, 'index'])->name('shipping.index');
    Route::get('/shipping-data', [ShippingController::class, 'getData'])->name('shipping.data');
    Route::get('/shipping-batches/{id}', [ShippingController::class, 'show'])->name('shipping.show');
    Route::post('/shipping-batch/store', [ShippingController::class, 'store'])->name('shipping-batch.store');
    Route::get('/shipping-batch/{id}', [ShippingController::class, 'showModal']);
    Route::put('/shipping-batch/{id}', [ShippingController::class, 'update']);
    Route::patch('/shipping-batch/{id}/update-status', [ShippingController::class, 'updateStatus'])->name('shipping-batch.update-status');
    Route::patch('/shipping-batch/bulk-status', [ShippingController::class, 'bulkStatus'])->name('shipping-batch.bulk-status');
    Route::delete('/shipping-batch/bulk-delete', [ShippingController::class, 'bulkDelete'])->name('shipping-batch.bulk-delete');
    Route::delete('/shipping-batch/{id}', [ShippingController::class, 'destroy'])->name('shipping-batch.destroy');


    // Leads routes
    Route::get('/team-leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/data', [LeadController::class, 'getData'])->name('leads.data');
    Route::post('/lead-sources/store', [LeadController::class, 'SourceStore'])->name('lead.sources.store');
    Route::post('/leadlist/source/delete', [LeadController::class, 'deleteSource'])->name('leadlist.source.delete');
    Route::get('/leads/show/{id}', [LeadController::class, 'showLead'])->name('leads.show');
    Route::post('/leads/save', [LeadController::class, 'saveLead'])->name('leads.save');
    Route::post('/lead/move-or-delete', [LeadController::class, 'moveOrDeleteLead'])->name('lead.moveOrDelete');
    Route::post('/leads/bulk-delete', [LeadController::class, 'bulkDelete'])->name('lead.bulkDelete');
    Route::post('/leads/bulk-move', [LeadController::class, 'bulkMove'])->name('leads.bulk.move');
    Route::post('/leads/bulk-publish-date', [LeadController::class, 'bulkPublishDate'])->name('leads.bulkPublishDate');

    Route::get('/templates/{id}/details', [LeadController::class, 'details'])->name('templates.details');

    // OAC routes
    Route::get('/oacleads', [OACLeadController::class, 'index'])->name('oac.leads.index');

    // Settings routes
    Route::get('/user/profile', [SettingController::class, 'index'])->name('setting.index');
});

