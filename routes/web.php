<?php

use App\Http\Controllers\AttachmentController;
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

    Route::get('/notifications/list', [HomeController::class, 'list'])->name('notifications.list');
    Route::post('/notifications/mark-read', [HomeController::class, 'markRead'])
        ->name('notifications.markRead');
    Route::get('download/report/{file}', [HomeController::class, 'download'])->name('download.report');


    //Smart Data route
    Route::get('/smart-data', [SmartDataController::class, 'index'])->name('smart.data');
    Route::get('/get-smart-data', [SmartDataController::class, 'getSmartData'])->name('get.smart.data');

    Route::post('/tags/store', [TagController::class, 'store'])->name('tags.store');
    Route::post('/tags/{id}/update', [TagController::class, 'update'])->name('tags.update');
    Route::post('/tags/{id}/delete', [TagController::class, 'destroy'])->name('tags.delete');
    Route::get('smart-data/lead/{id}', [SmartDataController::class, 'showSmartData'])->name('smart.data.lead');
    Route::post('/buylist/add-item', [SmartDataController::class, 'addItem'])->name('buylist.addItem');
    Route::post('/lead/save-tags', [SmartDataController::class, 'saveTags'])->name('lead.save.tags');
    Route::post('/leads/save-type', [SmartDataController::class, 'saveType'])->name('leads.saveType');
    Route::delete('/smart-data/{id}', [SmartDataController::class, 'destroy'])
    ->name('smart-data.destroy');
    Route::post('/leads/bulk-tags', [SmartDataController::class, 'bulkTags'])->name('save.bulk.tags');
    Route::post('/smart-data/lead/update', [SmartDataController::class, 'updateLead'])->name('smartdata.leads.update');
    Route::get('/smartdata/export', [SmartDataController::class, 'export'])->name('smartdata.export');
    
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
    Route::get('/buylist/export', [BuylistController::class, 'export'])->name('buylist.export');


    // Orders routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders-items', [OrderController::class, 'ordersItems'])->name('orders.items');
    Route::get('/orders/data', [OrderController::class, 'getData'])->name('orders.data');
    Route::post('/orders-items/data', [OrderController::class, 'getDataOrdersItems'])->name('data.orders.items');
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
    Route::post('/order-items/duplicate/{id}', [OrderController::class, 'duplicateItem'])
    ->name('order.items.duplicate');
    Route::post('/order-items/delete/{id}', [OrderController::class, 'deleteItem'])
    ->name('order.items.delete');
    Route::post('/order-items/bulk-delete', [OrderController::class, 'bulkDeleteItems'])
    ->name('order.items.bulk.delete');
    Route::post('/orders/mark-fixed', [OrderController::class, 'markFixed'])
    ->name('orders.markFixed');
    Route::get('/orders/export', [OrderController::class, 'export'])->name('orders.export');
    Route::get('/order/items/export', [OrderController::class, 'ItemsExport'])->name('order.items.export');

    Route::post('/save-attachment', [AttachmentController::class, 'store'])->name('attachments.store');
    Route::get('/orders/{order}/attachments', [AttachmentController::class, 'list'])->name('orders.attachments.list');
    Route::delete('/orders/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('orders.attachments.delete');
    Route::get('/attachments/{id}/download', [AttachmentController::class, 'download'])->name('attachments.download');


    // event routes
    Route::post('/ship-events/store', [OrderController::class, 'shipEventStore'])
    ->name('ship-events.store');
    Route::post('/event-logs/store', [OrderController::class, 'logEventStore'])
    ->name('event-logs.store');
    Route::get('/orders/{id}/events', [OrderController::class, 'getEvents'])->name('orders.events');
    Route::delete('/event-log/{id}', [OrderController::class, 'destroyEvent'])->name('event-log.delete');
    Route::delete('/ship-event/{id}', [OrderController::class, 'destroyShipEvent'])->name('ship-event.delete');
    Route::get('/orders/items/{orderId}/events', [OrderController::class, 'getEventsForItem'])
     ->name('orders.items.events');
    Route::get('/events/get/{type}/{id}', [OrderController::class, 'getEventEdit']);
    Route::post('/events/update/{id}', [OrderController::class, 'updateEvent']);


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
    Route::get('/shipping/export', [ShippingController::class, 'export'])->name('shipping.export');


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
    Route::get('/leads/export', [LeadController::class, 'export'])->name('leads.export');

    Route::get('/templates/{id}/details', [LeadController::class, 'details'])->name('templates.details');
    Route::delete('/template/{id}', [LeadController::class, 'TempDestroy'])->name('template.destroy');
    Route::put('/update/template/{id}', [LeadController::class, 'updateTemp'])->name('template.update');

    Route::get('/templates/{id}/mapping', [LeadController::class, 'getTemplateMapping'])
     ->name('templates.mapping');
    Route::post('/leads/upload', [LeadController::class, 'uploadFile'])->name('leads.upload');
    Route::post('/save-mapping-template', [LeadController::class, 'saveTemplate'])->name('save-mapping-template');
    Route::post('/leads/import', [LeadController::class, 'importLeadsFile'])->name('leads.import.file');
    Route::post('/leads/failed/new', [LeadController::class, 'storeNewLead'])->name('leads.failed.new');
    Route::delete('/delete-uploaded-file', [LeadController::class, 'deleteUploadedFile'])->name('leads.delete.upload');


    // OAC routes
    Route::get('/oacleads', [OACLeadController::class, 'index'])->name('oac.leads.index');

    // Settings routes
    Route::get('/user/profile', [SettingController::class, 'index'])->name('setting.index');

    Route::post('/profile/update', [SettingController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [SettingController::class, 'updatePassword'])->name('profile.password');
});

