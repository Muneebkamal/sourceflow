@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="row mt-2">
        <div class="col-md-12 mt-2">
            <form id="order-form">
                <div class="page-title-head d-flex align-items-sm-start flex-sm-row flex-column" style="height: auto;">
                    <div class="d-flex align-items-center flex-grow-1">
                        <a href="{{ route('orders.index') }}" class="btn btn-soft-primary"><i class="ti ti-arrow-left fs-2"></i></a>
                        <div class="ms-2" id="order-info">
                            <h4 class="fs-18 fw-semibold m-0">Order #<span id="order-id">{{ $order->order_id }}</span></h4>
                            <p class="m-0">Order Date: <span id="order-date">{{ \Carbon\Carbon::parse($order->date)->format('m/d/y') }}</span></p>
                        </div>
                        <div class="ms-2 align-top">
                            <i class="ti ti-edit fs-2" id="edit-order" style="cursor:pointer;"></i>
                        </div>
                    </div>

                    
                    <div class="mt-3 mt-sm-0">
                        <div class="row g-4 mb-0 align-items-start">
                            <div class="col-auto">
                                <button class="btn btn-light mt-1" data-bs-toggle="modal" data-bs-target="#attachmentsModal">
                                    <i class="ti ti-paperclip fs-4"></i> Attachments (0)
                                </button>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex justify-content-between align-items-center text-center gap-3 w-100">
                                    <div>
                                        <span class="badge bg-light text-secondary px-2 py-1">{{ $order->total_units_purchased }}</span>
                                        <div class="fw-bold mt-1">Ordered</div>
                                    </div>
                                    <div>
                                        <span class="badge badge-soft-primary px-2 py-1">{{ $order->total_units_received }}</span>
                                        <div class="fw-bold mt-1">Received</div>
                                    </div>
                                    <div>
                                        <span class="badge badge-soft-success px-2 py-1">{{ $order->total_units_shipped }}</span>
                                        <div class="fw-bold mt-1">Listed</div>
                                    </div>
                                    <div>
                                        <span class="badge badge-soft-danger px-2 py-1">{{ $order->unit_errors }}</span>
                                        <div class="fw-bold mt-1">Error</div>
                                    </div>
                                    <div>
                                        <span class="badge badge-soft-warning px-2 py-1">0</span>
                                        <div class="fw-bold mt-1">Fixed</div>
                                    </div>
                                </div>
                                <div class="mt-2 d-flex justify-content-center">
                                    <span class="badge bg-light text-dark py-2 px-3">0 % Completed</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <select class="form-select status-select fw-semibold mt-1" name="status">
                                    <option value="ordered" class="bg-white text-dark" {{ $order->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                                    <option value="partially received" class="bg-white text-dark" {{ $order->status == 'partially received' ? 'selected' : '' }}>Partially Received</option>
                                    <option value="received in full" class="bg-white text-dark" {{ $order->status == 'received in full' ? 'selected' : '' }}>Received in Full</option>
                                    <option value="draft" class="bg-white text-dark" {{ $order->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="closed" class="bg-white text-dark" {{ $order->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                    <option value="canceled" class="bg-white text-dark" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                    <option value="reconcile" class="bg-white text-dark" {{ $order->status == 'reconcile' ? 'selected' : '' }}>Reconcile</option>
                                    <option value="breakage" class="bg-white text-dark" {{ $order->status == 'breakage' ? 'selected' : '' }}>Breakage</option>
                                </select>
                                <div class="mt-2">
                                    <button class="btn btn-primary"><i class="ti ti-calculator fs-4"></i></button>
                                    <button id="save-order-form" class="btn btn-primary" disabled><i class="ti ti-device-floppy me-1 fs-4"></i> Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Order Details
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                                            <h5 class="mb-0">Order Info</h5>
                                            <a href="#" class="text-decoration-none" id="edit-order-info">
                                                <i class="ti ti-pencil" id="edit-icon-order-info"></i>
                                                <span id="edit-text-order-info"> Edit</span>
                                            </a>

                                        </div>

                                        <div class="card-body">
                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Source</span>
                                                <span class="fw-bold text-dark editable-field" id="source-field">
                                                    @php
                                                        $sourceUrl = $order->source;
                                                        if ($sourceUrl && !Str::startsWith($sourceUrl, ['http://', 'https://'])) {
                                                            $sourceUrl = 'https://' . $sourceUrl;
                                                        }
                                                    @endphp
                                                    <a href="{{ $sourceUrl }}" target="_blank" class="text-primary text-decoration-none">
                                                        {{ $order->source }}
                                                        <i class="ti ti-external-link text-primary fs-5 align-middle"></i>
                                                    </a>
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Email Used</span>
                                                <span class="fw-bold text-dark editable-field" id="email-field">{{ $order->email }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Destination</span>
                                                <span class="fw-bold text-dark editable-field" id="destination-field">{{ $order->destination }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Created At</span>
                                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($order->date)->format('m/d/y') }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Last Updated</span>
                                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($order->updated_at)->format('m/d/y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                                            <h5 class="mb-0">Order Totals</h5>
                                            <a href="{{ route('buy.cost.calculator', $order->id) }}" class="text-decoration-none">
                                                <i class="ti ti-calculator"></i> Edit
                                            </a>
                                        </div>

                                        <div class="card-body">
                                            <div class="d-flex justify-content-between  pb-2">
                                                <span class="text-muted">Subtotal (Pre Tax)</span>
                                                <span class="fw-bold text-dark">${{ number_format($order->subtotal,2)}}</span>
                                            </div>

                                            <div class="d-flex justify-content-between  pb-2">
                                                <span class="text-muted">Shipping Total</span>
                                                <span class="fw-bold text-dark">${{ number_format($order->shipping_cost,2) }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between  pb-2">
                                                <span class="text-muted">Sales Tax Paid</span>
                                                <span class="fw-bold text-dark">${{ number_format($order->sales_tax,2) }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between  pb-2">
                                                <span class="text-muted">Sales Tax Rate</span>
                                                <span class="fw-bold text-dark">{{ isset($order->sales_tax_rate) ? number_format($order->sales_tax_rate,2) . '%' : '0.00%' }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Grand Total</span>
                                                <span class="fw-bold text-dark">${{ number_format($order->total,2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                                            <h5 class="mb-0">Payment Details</h5>
                                            <a href="#" class="text-decoration-none" id="edit-payment-info">
                                                <i class="ti ti-pencil" id="edit-icon-payment-info"></i> 
                                                <span id="edit-text-payment-info">Edit</span>
                                            </a>
                                        </div>

                                        <div class="card-body">
                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Card Used</span>
                                                <span class="fw-bold text-dark" id="card-used-field">{{ $order->card_used }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Amount Charged</span>
                                                <span class="fw-bold text-dark" id="amount-charged-field">
                                                    ${{ number_format($order->total,2) }}
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Cash Back Source</span>
                                                <span class="fw-bold text-dark" id="cash-back-source-field">{{ $order->cash_back_source }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Cash Back % ($0.00)</span>
                                                <span class="fw-bold text-dark" id="cash-back-percentage-field">
                                                    {{ isset($order->cash_back_percentage) ? number_format($order->cash_back_percentage,2) . '%' : '0.00%' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between align-items-center border-top">
                                            <p class="mb-0">Gift Cards</p>
                                            <a href="#" class="text-decoration-none">
                                                <i class="ti ti-gift"></i> Add Gift Card
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                                            <h5 class="mb-0">Order Notes</h5>
                                            <a href="#" class="text-decoration-none check-icon" style="display:none;">
                                                <i class="ti ti-check"></i>
                                            </a>
                                        </div>
                                        <div class="card-body note-card">
                                            <div class="note-text">{{ $order->note }}</div>
                                            <textarea name="note" class="form-control" style="display:none;" cols="30" rows="10">{{ $order->note }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header border-bottom">
                                            <h5 class="mb-0">Event Logs</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="responsive-table">
                                                <table class="table">
                                                    <thead>
                                                        <th>Event Type</th>
                                                        <th>ASIN</th>
                                                        <th>Qty</th>
                                                        <th>Created At</th>
                                                        <th>Updated At</th>
                                                        <th>Action</th>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="m-0">Order Items (<span id="items-count">0</span>)</h4>
                <div class="gap-2">
                    <button id="openEditItems" type="button" class="btn btn-soft-primary edit-item-btn" data-id="1" data-bs-toggle="modal" data-bs-target="#editItemsModal">
                        Edit Items
                    </button>
                    <button class="btn btn-soft-primary">Show Events <i class="ti ti-eye"></i></button>
                    <div class="btn-group">
                        <button class="btn btn-soft-primary" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                            Create Event
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    Never Received
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    Mark Order as Fixed
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">
                                    List to FBA
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-soft-primary dropdown-toggle drop-arrow-none" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                            <i class="ti ti-adjustments-horizontal"></i> Customize
                        </button>

                        <div class="dropdown-menu dropdown-menu-md p-0 shadow">
                            <div class="card border-0 mb-0">
                                <div class="card-header bg-light py-2">
                                    <h5 class="mb-0 fw-semibold text-center">Displayed Order Columns</h5>
                                </div>

                                <div class="card-body p-2">
                                    <!-- ✅ Sortable list -->
                                    <div class="column-list-draggable">
                                        <!-- Publish Date -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-publish_time" checked>
                                                <label class="form-check-label ms-2" for="col-publish_time">Publish Date</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Image -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-image" checked>
                                                <label class="form-check-label ms-2" for="col-image">Image</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Type -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-type" checked>
                                                <label class="form-check-label ms-2" for="col-type">Type</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Tags -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-tags" checked>
                                                <label class="form-check-label ms-2" for="col-tags">Tags</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Last Updated -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-latest_updated_at" checked>
                                                <label class="form-check-label ms-2" for="col-latest_updated_at">Last Updated</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Product Title -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-name" checked>
                                                <label class="form-check-label ms-2" for="col-name">Product Title</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- ASIN -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-asin" checked>
                                                <label class="form-check-label ms-2" for="col-asin">ASIN</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Supplier -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-supplier" checked>
                                                <label class="form-check-label ms-2" for="col-supplier">Supplier</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Brand -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-brand">
                                                <label class="form-check-label ms-2" for="col-brand">Brand</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Cost -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-cost" checked>
                                                <label class="form-check-label ms-2" for="col-cost">Cost</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Sale Price -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-selling_price" checked>
                                                <label class="form-check-label ms-2" for="col-selling_price">Sale Price</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Net Profit -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-net_profit_input" checked>
                                                <label class="form-check-label ms-2" for="col-net_profit_input">Net Profit</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- ROI -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-roi_input" checked>
                                                <label class="form-check-label ms-2" for="col-roi_input">ROI</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- BSR 90D Avg -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-bsr_ninety" checked>
                                                <label class="form-check-label ms-2" for="col-bsr_ninety">BSR 90D Avg</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Category -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-category" checked>
                                                <label class="form-check-label ms-2" for="col-category">Category</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Promo -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-promo" checked>
                                                <label class="form-check-label ms-2" for="col-promo">Promo</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Coupon Code -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-coupon_code" checked>
                                                <label class="form-check-label ms-2" for="col-coupon_code">Coupon Code</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Lead Note -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-list_item_note" checked>
                                                <label class="form-check-label ms-2" for="col-list_item_note">Lead Note</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- New Offers -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-new_offers_count">
                                                <label class="form-check-label ms-2" for="col-new_offers_count">New Offers</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Rating -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-rating">
                                                <label class="form-check-label ms-2" for="col-rating">Rating</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Reviews -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-review_count">
                                                <label class="form-check-label ms-2" for="col-review_count">Reviews</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- BSR Current -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-bsr_current" checked>
                                                <label class="form-check-label ms-2" for="col-bsr_current">BSR Current</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Lead Source -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-list_group_id">
                                                <label class="form-check-label ms-2" for="col-list_group_id">Lead Source</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>

                                        <!-- Variations -->
                                        <div class="d-flex justify-content-between align-items-center draggable-item">
                                            <div>
                                                <input class="form-check-input" type="checkbox" id="col-variations">
                                                <label class="form-check-label ms-2" for="col-variations">Variations</label>
                                            </div>
                                            <i class="ti ti-grip-vertical grip-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="order-items-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th><input type="checkbox" class="form-check-input"></th>
                                    <th>Image</th>
                                    <th>Product Title</th>
                                    <th>Variation Details</th>
                                    <th>ASIN</th>
                                    <th>MSKU</th>
                                    <th>QTY</th>
                                    <th>Cost</th>
                                    <th>SKU Total</th>
                                    <th>O-R-L-E-F</th>
                                    <th>Product Note</th>
                                    <th>Buyer Note</th>
                                    <th class="sticky-col text-center">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.order.order-detail.attachment-modal')
    @include('modals.order.order-detail.lineitems-edit-modal')
    @include('modals.order.order-detail.create-event-modal')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let table = $('#order-items-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('order.items', $order->id) }}',
            scrollY: '40vh',
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            searching: false,
            lengthChange: false,
            ordering: false,
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                { data: 'image', name: 'image' },
                { data: 'name', name: 'name' },
                { data: 'variation_details', name: 'variation_details' },
                { data: 'asin', name: 'asin' },
                { data: 'msku', name: 'msku' },
                { data: 'qty', name: 'qty' },
                { data: 'cost', name: 'cost' },
                { data: 'sku_total', name: 'sku_total' },
                { data: 'orlef', name: 'orlef' },
                { data: 'product_note', name: 'product_note' },
                { data: 'buyer_note', name: 'buyer_note' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
            ]
        });

        // Update count label
        table.on('xhr.dt', function(e, settings, json, xhr) {
            $('#items-count').text(json?.recordsTotal ?? 0);
        });

        // -------------------------------
        // Modal & Data Handling
        // -------------------------------
        let itemsData = [];
        let currentIndex = 0;

        // ✅ Populate modal with item data
        function populateModal(item) {
            const data = item.raw || {};
            const modal = $('#editItemsModal');

            modal.find('#editItemsModalLabel').text(data.name ?? '-');
            modal.find('img[alt="Product Image"]').attr('src', 'https://app.sourceflow.io/storage/images/no-image-thumbnail.png');

            modal.find('#name').val(data.name ?? '');
            modal.find('#asin').val(data.asin ?? '');
            modal.find('#variation').val(data.variation_details ?? '');
            modal.find('#msku').val(data.msku ?? '');
            modal.find('#category').val(data.category ?? '');
            modal.find('#supplier').val(data.supplier ?? '');
            modal.find('#unitsPurchased').val(data.qty ?? '');
            modal.find('#costPerUnit').val(data.cost ?? '');
            modal.find('#sellingPrice').val(data.selling_price ?? '');
            modal.find('#netProfit').val(data.net_profit ?? '');
            modal.find('#listPrice').val(data.list_price ?? '');
            modal.find('#minPrice').val(data.min ?? '');
            modal.find('#maxPrice').val(data.max ?? '');
            modal.find('#roi').val(data.roi ?? '');
            modal.find('#bsr_ninety').val(data.bsr ?? '');
            modal.find('#source_url').val(data.source_url ?? '');
            modal.find('#promo').val(data.promo ?? '');
            modal.find('#coupon_code').val(data.coupon_code ?? '');
            modal.find('#product_note').val(data.product_note ?? '');
            modal.find('#buyerNote').val(data.buyer_note ?? '');

            // 🔹 Smart Info (your new section)
            modal.find('#smart-date').text(data.create_at ?? '-');
            modal.find('#smart-supplier').text(data.supplier ?? '-');
            // Supplier link (open in new tab)
            if (data.source_url) {
                modal.find('#supplier-link')
                    .attr('href', data.source_url)
                    .show();
            } else {
                modal.find('#supplier-link')
                    .attr('href', '#')
                    .hide();
            }

            modal.find('#smart-buy-cost').text(data.buy_cost ? `$${parseFloat(data.buy_cost).toFixed(2)}` : '$0');
            modal.find('#smart-net-cost').text(data.net_cost ? `$${parseFloat(data.net_cost).toFixed(2)}` : '$0');
            modal.find('#smart-roi').text(data.roi ? `${data.roi}%` : '0%');
            modal.find('#smart-bsr').text(data.bsr ?? '-');

            // ✅ Update counter & button states
            modal.find('#item-position').text(`${currentIndex + 1} of ${itemsData.length}`);
            modal.find('#prev-item').prop('disabled', currentIndex === 0);
            modal.find('#next-item').prop('disabled', currentIndex === itemsData.length - 1);
        }

        // ✅ Edit button inside DataTable rows
        $(document).on('click', '.edit-item', function(e) {
            e.preventDefault();

            const id = $(this).data('id');
            itemsData = table.rows({ page: 'current' }).data().toArray();
            currentIndex = itemsData.findIndex(item => item.id == id);

            if (currentIndex >= 0) {
                populateModal(itemsData[currentIndex]);
                $('#editItemsModal').modal('show');
            } else {
                console.error('Item not found for ID:', id);
            }
        });

        // ✅ Next button
        $(document).on('click', '#next-item', function() {
            if (currentIndex < itemsData.length - 1) {
                currentIndex++;
                populateModal(itemsData[currentIndex]);
            }
        });

        // ✅ Previous button
        $(document).on('click', '#prev-item', function() {
            if (currentIndex > 0) {
                currentIndex--;
                populateModal(itemsData[currentIndex]);
            }
        });

        // ✅ “Edit Items” main button (first item)
        $(document).on('click', '#openEditItems', function() {
            itemsData = table.rows({ page: 'current' }).data().toArray();
            if (itemsData.length > 0) {
                currentIndex = 0;
                populateModal(itemsData[currentIndex]);
                $('#editItemsModal').modal('show');
            } else {
                alert('No items found in this order.');
            }
        });
    });

    // order_id date and status update
    $(document).ready(function() {
        // Enable inline editing
        $('#edit-order').on('click', function() {
            var orderId = $('#order-id').text().trim();
            var orderDate = $('#order-date').text().trim();

            // Convert "mm/dd/yy" → "yyyy-mm-dd"
            var parts = orderDate.split('/');
            var month = parts[0].padStart(2, '0');
            var day = parts[1].padStart(2, '0');
            var year = '20' + parts[2]; // two-digit year to four-digit
            var formattedDate = `${year}-${month}-${day}`;

            // Replace display with editable inputs
            $('#order-info').html(`
                <h4 class="fs-18 fw-semibold m-0" style="white-space: nowrap;">
                    Order # <input type="text" id="edit-order-id" class="form-control d-inline-block w-auto ms-1" value="${orderId}">
                </h4>
                <p class="m-0 mt-2" style="white-space: nowrap;">
                    Order Date: <input type="date" id="edit-order-date" class="form-control d-inline-block w-auto ms-1" value="${formattedDate}">
                </p>
            `);

            $(this).hide();
            // $('#save-order-form').prop('disabled', false);
        });

        // Enable save button if any field changes
        $('#order-form').on('input change', 'input, select, textarea', function() {
            $('#save-order-form').prop('disabled', false);
        });

        // Handle Save button click
        $('#save-order-form').on('click', function(e) {
            e.preventDefault();

            // If user has edited inline
            let orderId = $('#edit-order-id').length ? $('#edit-order-id').val().trim() : $('#order-id').text().trim();
            let orderDate = $('#edit-order-date').length ? $('#edit-order-date').val().trim() : $('#order-date').text().trim();
            let status = $('select[name="status"]').val();

            $.ajax({
                url: "{{ route('orders.update', $order->id) }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: orderId,
                    date: orderDate,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);

                        // Revert editable fields to static view
                        let displayDate = new Date(orderDate).toLocaleDateString('en-US', {
                            month: '2-digit',
                            day: '2-digit',
                            year: '2-digit'
                        });

                        $('#order-info').html(`
                            <h4 class="fs-18 fw-semibold m-0">Order #<span id="order-id">${orderId}</span></h4>
                            <p class="m-0">Order Date: <span id="order-date">${displayDate}</span></p>
                        `);

                        $('#edit-order').show();
                        $('#save-order-form').prop('disabled', true);
                    }
                },
                error: function(xhr) {
                    toastr.error('Error updating order');
                }
            });
        });
    });

    // order detail info update
    $(document).ready(function() {
        let editing = false;

        $('#edit-order-info').on('click', function(e) {
            e.preventDefault();
            editing = !editing;

            if (editing) {
                // Switch to edit mode
                $('#edit-icon-order-info').removeClass('ti-pencil').addClass('ti-check');
                $('#edit-text-order-info').hide();

                // Convert text spans to editable inputs
                const sourceText = $('#source-field').text().trim();
                const emailText = $('#email-field').text().trim();
                const destinationText = $('#destination-field').text().trim();

                $('#source-field').html(`<input id="source-field-input" type="text" class="form-control" value="${sourceText}">`);
                $('#email-field').html(`<input id="email-field-input" type="email" class="form-control" value="${emailText}">`);
                $('#destination-field').html(`<input id="destination-field-input" type="text" class="form-control" value="${destinationText}">`);

            } else {
                // Switch back from edit mode (save changes)
                $('#edit-icon-order-info').removeClass('ti-check').addClass('ti-pencil');
                $('#edit-text-order-info').show();

                // Get input values
                const sourceVal = $('#source-field-input').val();
                const emailVal = $('#email-field-input').val();
                const destinationVal = $('#destination-field-input').val();

                // Send AJAX request to update the order info
                $.ajax({
                    url: "{{ route('orders.updateInfo', $order->id) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        source: sourceVal,
                        email: emailVal,
                        destination: destinationVal
                    },
                    beforeSend: function() {
                        // Optional: show loader or disable edit button
                        $('#edit-order-info').addClass('disabled');
                    },
                    success: function(response) {
                        $('#edit-order-info').removeClass('disabled');

                        if (response.success) {
                            toastr.success(response.message);

                            // ✅ Update the text display
                            let finalSource = sourceVal.trim();
                            let sourceUrl = finalSource;

                            // Ensure link has http/https prefix
                            if (sourceUrl && !/^https?:\/\//i.test(sourceUrl)) {
                                sourceUrl = 'https://' + sourceUrl;
                            }

                            // Rebuild the clickable link with icon
                            $('#source-field').html(`
                                <a href="${sourceUrl}" target="_blank" class="text-primary text-decoration-none">
                                    ${finalSource}
                                    <i class="ti ti-external-link text-primary fs-5 align-middle"></i>
                                </a>
                            `);
                            $('#email-field').html(emailVal);
                            $('#destination-field').html(destinationVal);
                        } else {
                            toastr.error(response.message || 'Failed to update order info.');
                        }
                    },
                    error: function(xhr) {
                        $('#edit-order-info').removeClass('disabled');
                        toastr.error('Failed to update order info.');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

    // payment details update
    $(document).ready(function() {
        let editingPayment = false;

        $('#edit-payment-info').on('click', function(e) {
            e.preventDefault();
            editingPayment = !editingPayment;

            if (editingPayment) {
                // Switch to edit mode
                $('#edit-icon-payment-info').removeClass('ti-pencil').addClass('ti-check');
                $('#edit-text-payment-info').hide();

                // Convert spans to inputs
                const cardUsed = $('#card-used-field').text().trim();
                const amountCharged = $('#amount-charged-field').text().replace('$', '').trim();
                const cashBackSource = $('#cash-back-source-field').text().trim();
                const cashBackPercentage = $('#cash-back-percentage-field').text().replace('%', '').trim();

                $('#card-used-field').html(`<input id="card-used-input" type="text" class="form-control form-control-sm" value="${cardUsed}">`);
                $('#amount-charged-field').html(`<input id="amount-charged-input" type="number" step="0.01" class="form-control form-control-sm" value="${amountCharged}">`);
                $('#cash-back-source-field').html(`<input id="cash-back-source-input" type="text" class="form-control form-control-sm" value="${cashBackSource}">`);
                $('#cash-back-percentage-field').html(`<input id="cash-back-percentage-input" type="number" step="0.01" class="form-control form-control-sm" value="${cashBackPercentage}">`);

            } else {
                // Switch back to display mode
                $('#edit-icon-payment-info').removeClass('ti-check').addClass('ti-pencil');
                $('#edit-text-payment-info').show();

                // Collect updated values
                const cardUsedVal = $('#card-used-input').val();
                const amountChargedVal = $('#amount-charged-input').val();
                const cashBackSourceVal = $('#cash-back-source-input').val();
                const cashBackPercentageVal = $('#cash-back-percentage-input').val();

                // Send AJAX update request
                $.ajax({
                    url: "{{ route('orders.updatePayment', $order->id) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        card_used: cardUsedVal,
                        total: amountChargedVal,
                        cash_back_source: cashBackSourceVal,
                        cash_back_percentage: cashBackPercentageVal
                    },
                    beforeSend: function() {
                        $('#edit-payment-info').addClass('disabled');
                    },
                    success: function(response) {
                        $('#edit-payment-info').removeClass('disabled');

                        if (response.success) {
                            toastr.success(response.message);

                            // Update the visible fields
                            $('#card-used-field').text(cardUsedVal);
                            $('#amount-charged-field').text(`$${parseFloat(amountChargedVal).toFixed(2)}`);
                            $('#cash-back-source-field').text(cashBackSourceVal);
                            $('#cash-back-percentage-field').text(`${parseFloat(cashBackPercentageVal).toFixed(2)}%`);
                        } else {
                            toastr.error(response.message || 'Failed to update payment info.');
                        }
                    },
                    error: function(xhr) {
                        $('#edit-payment-info').removeClass('disabled');
                        toastr.error('Failed to update payment info.');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

    // $(document).ready(function() {
    //     $('.note-card').on('click', function() {
    //         // Hide the text div and show textarea
    //         $(this).find('.note-text').hide();
    //         $(this).find('textarea').show().focus();

    //         // Show check icon
    //         $(this).closest('.card').find('.check-icon').show();
    //     });

    //     // Optional: hide textarea and show text again on check icon click
    //     $('.check-icon').on('click', function(e) {
    //         e.preventDefault();
    //         var card = $(this).closest('.card');
    //         var textarea = card.find('textarea');
    //         var noteText = card.find('.note-text');

    //         // Update the text div with textarea value
    //         noteText.text(textarea.val());

    //         // Hide textarea, show text
    //         textarea.hide();
    //         noteText.show();

    //         // Hide check icon again
    //         $(this).hide();
    //     });
    // });
    $(document).ready(function() {
        // Click to edit note
        $('.note-card').on('click', function() {
            const card = $(this).closest('.card');

            // Hide note text and show textarea
            card.find('.note-text').hide();
            card.find('textarea').show().focus();

            // Show check icon
            card.find('.check-icon').show();
        });

        // Click to save note
        $('.check-icon').on('click', function(e) {
            e.preventDefault();

            const card = $(this).closest('.card');
            const textarea = card.find('textarea');
            const noteText = card.find('.note-text');
            const noteValue = textarea.val();

            // Optional: disable icon while saving
            const icon = $(this).find('i');
            icon.removeClass('ti-check').addClass('ti-loader ti-spin');

            // Send AJAX update request
            $.ajax({
                url: "{{ route('orders.updateNote', $order->id) }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    note: noteValue
                },
                success: function(response) {
                    icon.removeClass('ti-loader ti-spin').addClass('ti-check');

                    if (response.success) {
                        toastr.success(response.message);

                        // Update visible note text
                        noteText.text(noteValue);
                    } else {
                        toastr.error(response.message || 'Failed to update note.');
                    }

                    // Hide textarea and check icon
                    textarea.hide();
                    noteText.show();
                    card.find('.check-icon').hide();
                },
                error: function(xhr) {
                    icon.removeClass('ti-loader ti-spin').addClass('ti-check');
                    toastr.error('Failed to update note.');
                    console.error(xhr.responseText);
                }
            });
        });
    });

    $(document).ready(function () {
        function updateSelectColor($select) {
            let status = $select.val();

            let colors = {
                'partially received': 'warning',
                'received in full': 'success',
                'ordered': 'primary',
                'draft': 'secondary',
                'closed': 'info',
                'canceled': 'danger',
                'reconcile': 'dark',
                'breakage': 'light'
            };

            // Remove old Bootstrap color classes
            $.each(colors, function (key, color) {
                $select.removeClass('bg-soft-' + color + ' text-' + color);
            });

            // Add new color class
            let newColor = colors[status] || 'secondary';
            $select.addClass('bg-soft-' + newColor + ' text-' + newColor);
        }

        // Run on change
        $(document).on('change', '.status-select', function () {
            updateSelectColor($(this));
        });

        // ✅ Run once on page load for all selects
        $('.status-select').each(function () {
            updateSelectColor($(this));
        });
    });

</script>
@endsection