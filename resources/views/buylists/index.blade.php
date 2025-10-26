@extends('layouts.app')

@section('title', 'BuyList')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.6.2/css/colReorder.dataTables.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Buy Lists</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                    <form action="javascript:void(0);">
                        <div class="row g-2 mb-0 align-items-center">
                            <div class="col-auto">
                                <a class="" href="#" target="_blank">
                                    <p class="text-success m-0">🎉 To Add Leads to a Buy List, Use the SF Extension!</p>
                                </a>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-soft-primary">
                                    Export
                                </button>
                                <button type="button" class="btn btn-soft-primary" data-bs-toggle="modal" data-bs-target="#createBuylistModal">
                                New Buy List
                                </button>
                                <button id="buylist-order-create" class="btn btn-primary" disabled>
                                    Create Order (<span id="buylist-item-count">0</span>)
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row align-items-end mb-3">
        <div class="col-md-7">
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input id="searchInput" type="text" class="form-control" placeholder="Search...">
                    </div>
                </div>

                <!-- Filter + Reset Buttons -->
                <div class="d-flex gap-1">
                    <button id="reset-btn" class="btn btn-danger">Reset</button>
                    <a href="{{ route('orders.items') }}" class="btn btn-soft-primary">View Ordered Leads</a>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="d-flex align-items-end justify-content-md-end gap-1 mt-2 mt-md-0">
                <a href="{{ route('buylists.rejected') }}" class="btn btn-soft-primary">
                    Rejected List <i class="ti ti-ban fs-4"></i>
                </a>

                <div class="btn-group drop-down">
                    <button type="button" class="btn btn-soft-primary dropdown-toggle drop-arrow-none" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                        Select Buy List <i class="ti ti-chevron-down align-middle ms-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-md p-0 shadow">
                        <div class="card border-0 mb-0">
                            <div class="card-header bg-light py-2">
                                <h5 class="mb-0 fw-semibold">Select Buylists</h5>
                            </div>

                            <div class="card-body p-2">
                                <div class="column-list">
                                    <!-- Buy Lists -->
                                    @foreach ($buylist as $list)
                                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                                            <div class="d-flex align-items-center">
                                                <input class="form-check-input me-2 buylist-filter" type="checkbox" value="{{ $list->id }}" id="list-{{ $list->id }}" checked>
                                                <label class="form-check-label mb-0" for="list-{{ $list->id }}">{{ $list->name }}</label>
                                            </div>
                                            <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y">
                                                <button class="btn btn-sm btn-outline-danger delete-buylist" data-id="{{ $list->id }}"><i class="ti ti-trash"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-soft-primary" data-bs-toggle="modal" data-bs-target="#createBuylistModal">Create Buylist <i class="ti ti-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                {{-- <div class="column-list-draggable">
                                    <div class="draggable-item hidden-placeholder" style="display:none">
                                        <input type="checkbox" id="col-id" checked>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-order_note">
                                            <label class="form-check-label ms-2" for="col-order_note">Order note</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-created_at">
                                            <label class="form-check-label ms-2" for="col-created_at">Date Added</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-asin" checked>
                                            <label class="form-check-label ms-2" for="col-asin">ASIN</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-image" checked>
                                            <label class="form-check-label ms-2" for="col-image">Image</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-name" checked disabled>
                                            <label class="form-check-label ms-2" for="col-name">Product Title</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-variations" checked>
                                            <label class="form-check-label ms-2" for="col-variations">Variation Details</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-supplier" checked>
                                            <label class="form-check-label ms-2" for="col-supplier">Supplier</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-cost" checked>
                                            <label class="form-check-label ms-2" for="col-cost">Buy Cost</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-selling_price" checked>
                                            <label class="form-check-label ms-2" for="col-selling_price">Estimated Selling Price</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-unit_purchased">
                                            <label class="form-check-label ms-2" for="col-unit_purchased">Quantity (To Purchase)</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-bsr" checked>
                                            <label class="form-check-label ms-2" for="col-bsr">BSR 90D Avg</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-promo">
                                            <label class="form-check-label ms-2" for="col-promo">Promo</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-coupon_code">
                                            <label class="form-check-label ms-2" for="col-coupon_code">Coupon Code</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-product_buyer_notes" checked>
                                            <label class="form-check-label ms-2" for="col-product_buyer_notes">Buyer Note</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-upc">
                                            <label class="form-check-label ms-2" for="col-upc">UPC/GTIN</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-brand">
                                            <label class="form-check-label ms-2" for="col-brand">Brand</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-monthly_sold">
                                            <label class="form-check-label ms-2" for="col-monthly_sold">Monthly Sold</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-offers">
                                            <label class="form-check-label ms-2" for="col-offers">Offers</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-rating">
                                            <label class="form-check-label ms-2" for="col-rating">Rating</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-reviews">
                                            <label class="form-check-label ms-2" for="col-reviews">Reviews</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-buylist_name">
                                            <label class="form-check-label ms-2" for="col-buylist_name">Buy List Name</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-lead_type">
                                            <label class="form-check-label ms-2" for="col-lead_type">Lead Type</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-sku_total">
                                            <label class="form-check-label ms-2" for="col-sku_total">SKU Total Cost</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-roi_est">
                                            <label class="form-check-label ms-2" for="col-roi_est">ROI Est</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-net_profit_est">
                                            <label class="form-check-label ms-2" for="col-net_profit_est">Net Profit Est</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-bsr_current">
                                            <label class="form-check-label ms-2" for="col-bsr_current">BSR Current</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-category">
                                            <label class="form-check-label ms-2" for="col-category">Category</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="draggable-item hidden-placeholder" style="display:none">
                                        <input type="checkbox" id="col-actions" checked>
                                    </div>
                                </div> --}}
                                <div class="column-list-draggable"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="select-count-section" class="col-md-12 d-flex mb-2 align-items-center d-none">
            <div class="dropdown">
                <button class="btn btn-sm btn-light" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                    <i class="ti ti-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item createOrderMultiItem" href="#">Create Order</a></li>
                    <li><a class="dropdown-item bulkMoveBtn" href="#">Move to Buylist</a></li>
                    <li><a class="dropdown-item rejectItemsBtn" href="#">Reject Items</a></li>
                    <li><a class="dropdown-item text-danger bulkDelBtn" href="#">Delete</a></li>
                </ul>
            </div>
            <span class="fw-bold ms-3">Selected: <span id="selectedCount">0</span></span>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="buylist-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                    <th>Order Note</th>
                                    <th>Date Added</th>
                                    <th>Asin</th>
                                    <th>Image</th>
                                    <th>Product Title</th>
                                    <th>Variations</th>
                                    <th>Supplier</th>
                                    <th>Cost</th>
                                    <th>Selling Price</th>
                                    <th>Qty</th>
                                    <th>BSR 90D Avg</th>
                                    <th>Promo</th>
                                    <th>Coupon Code</th>
                                    <th>Product Note</th>
                                    <th>Buyer Note</th>
                                    <th>UPC/GTIN</th>
                                    <th>Brand</th>
                                    <th>Monthly Sold</th>
                                    <th>Offers</th>
                                    <th>Rating</th>
                                    <th>Reviews</th>
                                    <th>Buy List Name</th>
                                    <th>Lead Type</th>
                                    <th>SKU Total Cost</th>
                                    <th>ROI Est</th>
                                    <th>Net Profit Est</th>
                                    <th>BSR Current</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                    {{-- <th class="sticky-col">Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.buylists.create-buylist-modal')
    @include('modals.order.order-detail.lineitems-edit-modal')
    @include('modals.buylists.reject-item')
    @include('modals.buylists.move-other-buylist-modal')
@endsection
    
@section('scripts')
    <!-- DataTables ColReorder extension -->
    <script src="https://cdn.datatables.net/colreorder/1.6.2/js/dataTables.colReorder.min.js"></script>
    <script>
        // $(document).ready(function () {
        //     const table = $('#buylist-table').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         stateSave: true,
        //         colReorder: true,
        //         ajax: {
        //             url: "{{ route('buylist.data') }}",
        //             data: function (d) {
        //                 d.buylist_ids = $('.buylist-filter:checked').map(function () {
        //                     return $(this).val();
        //                 }).get();
        //                 d.search = $('#searchInput').val();
        //             }
        //         },
        //         drawCallback: function () {
        //             const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        //             tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
        //         },
        //         scrollY: '40vh',
        //         scrollX: true,
        //         paging: true,
        //         searching: false,
        //         ordering: true,
        //         lengthChange: false,
        //         order: [],
        //         columns: [
        //             { data: 'id', orderable: false, render: data => `<input type="checkbox" class="form-check-input buylist-checkbox" data-id="${data}">` },
        //             { data: 'order_note', defaultContent: '--' },
        //             { data: 'created_at', defaultContent: '--' },
        //             { data: 'asin', defaultContent: '--' },
        //             { data: 'image', defaultContent: '--', orderable: false, searchable: false },
        //             { data: 'name', defaultContent: '--' },
        //             { data: 'variations', defaultContent: '--' },
        //             { data: 'supplier', defaultContent: '--' },
        //             { data: 'cost', defaultContent: '--' },
        //             { data: 'selling_price', defaultContent: '$0.00', render: d => d ? `$${parseFloat(d).toFixed(2)}` : '$0.00' },
        //             { data: 'unit_purchased', defaultContent: '--' },
        //             { data: 'bsr', defaultContent: '--' },
        //             { data: 'promo', defaultContent: '--' },
        //             { data: 'coupon_code', defaultContent: '--' },
        //             { data: 'order_note', defaultContent: '--' },
        //             { data: 'product_buyer_notes', defaultContent: '--' },
        //             { data: 'upc', defaultContent: '--' },
        //             { data: 'brand', defaultContent: '--' },
        //             { data: 'monthly_sold', defaultContent: '--' },
        //             { data: 'offers', defaultContent: '--' },
        //             { data: 'rating', defaultContent: '--' },
        //             { data: 'reviews', defaultContent: '--' },
        //             { data: 'buylist_name', defaultContent: '--' },
        //             { data: 'lead_type', defaultContent: '--' },
        //             { data: 'sku_total', defaultContent: '$0.00', render: d => d ? `$${parseFloat(d).toFixed(2)}` : '$0.00' },
        //             { data: 'roi_est', defaultContent: '--' },
        //             { data: 'net_profit_est', defaultContent: '--' },
        //             { data: 'bsr_current', defaultContent: '--' },
        //             { data: 'category', defaultContent: '--' },
        //             { data: 'actions', orderable: false, searchable: false, defaultContent: '' },
        //         ],
        //     });

        //     /** 🔹 Helper: Get column index by data name */
        //     function getColumnIndexByData(dataName) {
        //         const columns = table.settings().init().columns;
        //         return columns.findIndex(col => col.data === dataName);
        //     }

        //     /** 🧹 Clear invalid saved state if column count changed */
        //     table.on('stateLoaded.dt', function (e, settings, data) {
        //         const currentCount = table.columns().count();
        //         const savedCount = data?.columns?.length ?? 0;
        //         if (currentCount !== savedCount) {
        //             console.warn('⚠️ State cleared: column count mismatch');
        //             table.state.clear();
        //             location.reload();
        //         }
        //     });

        //     /** ✅ Sync column visibility checkboxes */
        //     function syncCheckboxStates() {
        //         table.columns().every(function () {
        //             const checkbox = $(`#col-${this.dataSrc()}`);
        //             if (checkbox.length) checkbox.prop('checked', this.visible());
        //         });
        //     }
        //     table.on('init.dt stateLoaded.dt', syncCheckboxStates);

        //     /** ✅ Sortable drag setup (only 1 → 28 allowed) */
        //     $(".column-list-draggable").sortable({
        //         handle: ".grip-icon",
        //         update: function () {
        //             const totalCols = table.columns().count();
        //             const firstFixed = 0;
        //             const lastFixed = totalCols - 1;
        //             const newOrder = [firstFixed];

        //             $(".column-list-draggable .form-check-input").each(function () {
        //                 const colId = $(this).attr('id').replace('col-', '');
        //                 const idx = getColumnIndexByData(colId);

        //                 // only allow drag between 1–28
        //                 if (idx >= 1 && idx <= 28) newOrder.push(idx);
        //             });

        //             newOrder.push(lastFixed);
        //             const safeOrder = [...new Set(newOrder.filter(i => i >= 0 && i < totalCols))];

        //             if (safeOrder.length !== totalCols) {
        //                 console.warn('⚠️ Reorder skipped: mismatch column count', { safeOrder, totalCols });
        //                 return;
        //             }

        //             table.colReorder.order(safeOrder, true);
        //             table.state.save();
        //             console.log("✅ Reordered (1–28 only):", safeOrder);
        //         }
        //     });

        //     /** 🔄 Keep draggable list synced when user drags in DataTable */
        //     table.on('column-reorder', function () {
        //         const order = table.colReorder.order();
        //         const sortedItems = order
        //             .filter(i => i >= 1 && i <= 28)
        //             .map(i => $(`.column-list-draggable .draggable-item:has(#col-${table.column(i).dataSrc()})`));

        //         $(".column-list-draggable .draggable-item").not('.hidden-placeholder').remove();
        //         $(".column-list-draggable").append(sortedItems);
        //         console.log("🔁 Synced drag order:", order);
        //     });

        //     /** 🔹 Filters & Search */
        //     $(document).on('change', '.buylist-filter', () => table.ajax.reload());
        //     $('#searchInput').on('keyup', () => table.ajax.reload());

        //     /** 🔹 Reset Button */
        //     $('#reset-btn').on('click', function () {
        //         const $btn = $(this);
        //         $btn.prop('disabled', true).html('<span class="spinner-grow spinner-grow-sm me-1"></span>Reset');
        //         $('#searchInput').val('');
        //         table.state.clear();
        //         table.ajax.reload(() => {
        //             syncCheckboxStates();
        //             $btn.prop('disabled', false).html('Reset');
        //         });
        //     });
        // });

        $(document).ready(function () {
            if ($.fn.DataTable.isDataTable('#buylist-table')) {
                $('#buylist-table').DataTable().destroy();
                $('#buylist-table').empty(); // removes cloned thead/tbody
            }

            const table = $('#buylist-table').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                stateSave: true,
                colReorder: true,
                ajax: {
                    url: "{{ route('buylist.data') }}",
                    data: function (d) {
                        d.buylist_ids = $('.buylist-filter:checked').map(function () {
                            return $(this).val();
                        }).get();
                        d.search = $('#searchInput').val();
                    }
                },
                scrollY: '40vh',
                scrollX: true,
                paging: true,
                searching: false,
                autoWidth: false,
                ordering: true,
                lengthChange: false,
                order: [],
                columns: [
                    { data: 'id', orderable: false, render: data => `<input type="checkbox" class="form-check-input buylist-checkbox" data-id="${data}">` },
                    { data: 'order_note', title: 'Order Note', defaultContent: '--' },
                    { data: 'created_at', title: 'Date Added', defaultContent: '--' },
                    { data: 'asin', title: 'ASIN', defaultContent: '--' },
                    { data: 'image', title: 'Image', defaultContent: '--', orderable: false, searchable: false },
                    { data: 'name', title: 'Product Title', defaultContent: '--' },
                    { data: 'variations', title: 'Variation Details', defaultContent: '--' },
                    { data: 'supplier', title: 'Supplier', defaultContent: '--' },
                    { data: 'cost', title: 'Buy Cost', defaultContent: '--' },
                    { data: 'selling_price', title: 'Estimated Selling Price', defaultContent: '$0.00', render: d => d ? `$${parseFloat(d).toFixed(2)}` : '$0.00' },
                    { data: 'unit_purchased', title: 'Quantity (To Purchase)', defaultContent: '--' },
                    { data: 'bsr', title: 'BSR 90D Avg', defaultContent: '--' },
                    { data: 'promo', title: 'Promo', defaultContent: '--' },
                    { data: 'coupon_code', title: 'Coupon Code', defaultContent: '--' },
                    { data: 'product_note', title: 'Product Note', defaultContent: '--' },
                    { data: 'product_buyer_notes', title: 'Buyer Note', defaultContent: '--' },
                    { data: 'upc', title: 'UPC/GTIN', defaultContent: '--' },
                    { data: 'brand', title: 'Brand', defaultContent: '--' },
                    { data: 'monthly_sold', title: 'Monthly Sold', defaultContent: '--' },
                    { data: 'offers', title: 'Offers', defaultContent: '--' },
                    { data: 'rating', title: 'Rating', defaultContent: '--' },
                    { data: 'reviews', title: 'Reviews', defaultContent: '--' },
                    { data: 'buylist_name', title: 'Buy List Name', defaultContent: '--' },
                    { data: 'lead_type', title: 'Lead Type', defaultContent: '--' },
                    { data: 'sku_total', title: 'SKU Total Cost', defaultContent: '$0.00', render: d => d ? `$${parseFloat(d).toFixed(2)}` : '$0.00' },
                    { data: 'roi_est', title: 'ROI Est', defaultContent: '--' },
                    { data: 'net_profit_est', title: 'Net Profit Est', defaultContent: '--' },
                    { data: 'bsr_current', title: 'BSR Current', defaultContent: '--' },
                    { data: 'category', title: 'Category', defaultContent: '--' },
                    { data: 'actions', title: 'Actions', orderable: false, searchable: false, defaultContent: '' },
                ],
            });

            /** 🧩 1. Dynamically build checkbox + drag list */
            const $list = $(".column-list-draggable").empty();
            table.columns().every(function (index) {
                const col = this;
                const data = col.dataSrc();
                const title = col.header().textContent.trim();

                // skip hidden placeholders (first and last column)
                if (data === 'id' || data === 'actions') return;

                const checked = col.visible() ? 'checked' : '';
                const disabled = data === 'name' ? 'disabled' : '';

                const item = `
                    <div class="d-flex justify-content-between align-items-center draggable-item" data-col="${data}">
                        <div>
                            <input class="form-check-input" type="checkbox" id="col-${data}" ${checked} ${disabled}>
                            <label class="form-check-label ms-2" for="col-${data}">${title}</label>
                        </div>
                        <i class="ti ti-grip-vertical grip-icon"></i>
                    </div>`;
                $list.append(item);
            });

            /** 🧭 Helper: get index by data name */
            function getColIndex(dataName) {
                const columns = table.settings().init().columns;
                return columns.findIndex(c => c.data === dataName);
            }

            /** ✅ 2. Checkbox show/hide logic */
            $(document).on('change', '.column-list-draggable .form-check-input', function () {
                const dataName = $(this).attr('id').replace('col-', '');
                const colIndex = getColIndex(dataName);
                const visible = $(this).is(':checked');
                if (colIndex >= 0) table.column(colIndex).visible(visible);
                table.state.save();
            });

            /** ✅ 3. Make list draggable and reorder columns properly */
            $(".column-list-draggable").sortable({
                handle: ".grip-icon",
                update: function () {
                    const totalCols = table.columns().count();
                    const firstFixed = 0;
                    const lastFixed = totalCols - 1;

                    const newOrder = [firstFixed];
                    $(".column-list-draggable .draggable-item").each(function () {
                        const dataName = $(this).data("col");
                        const colIndex = getColIndex(dataName);
                        if (colIndex >= 1 && colIndex <= lastFixed - 1) {
                            newOrder.push(colIndex);
                        }
                    });
                    newOrder.push(lastFixed);

                    // Apply new order to DataTable
                    table.colReorder.order(newOrder, true);
                    table.state.save();

                    // Sync list visually after reorder
                    syncListWithTable();
                }
            });

            /** 🔁 4. Sync list order when columns are reordered from table */
            table.on('column-reorder', function () {
                syncListWithTable();
            });

            /** 🧭 Helper: sync draggable list order with current table order */
            function syncListWithTable() {
                const order = table.colReorder.order();
                const $list = $(".column-list-draggable");
                const $items = [];

                order.forEach(function (i) {
                    const col = table.column(i);
                    const data = col.dataSrc();
                    if (data !== 'id' && data !== 'actions') {
                        const $item = $list.find(`.draggable-item[data-col="${data}"]`);
                        if ($item.length) $items.push($item);
                    }
                });

                // Rebuild list in same order as DataTable
                $list.append($items);
            }

            /** 🔍 5. Search + filter reload */
            $(document).on('change', '.buylist-filter', () => table.ajax.reload());
            $('#searchInput').on('keyup', () => table.ajax.reload());

            /** 🔄 6. Reset button */
            $('#reset-btn').on('click', function () {
                const $btn = $(this);
                $btn.prop('disabled', true).html('<span class="spinner-grow spinner-grow-sm me-1"></span>Reset');
                $('#searchInput').val('');
                table.state.clear();
                table.ajax.reload(() => {
                    $btn.prop('disabled', false).html('Reset');
                });
            });
        });

        // Open edit modal from Buylist DataTable
        $(document).ready(function () {
            let editItemId = null;

            // 🟦 Handle Edit Button Click
            $(document).on('click', '.edit-smart-item', function (e) {
                e.preventDefault();

                const modal = $('#editItemsModal');
                const data = $(this).data();
                editItemId = data.id; // store item ID

                // 🧾 Optional summary fields
                let formattedDate = '-';
                if (data.date) {
                    const dateObj = new Date(data.date);
                    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                    const day = String(dateObj.getDate()).padStart(2, '0');
                    const year = dateObj.getFullYear();
                    formattedDate = `${month}/${day}/${year}`;
                }

                modal.find('#smart-date').text(formattedDate);
                modal.find('#smart-supplier').text(data.supplier ?? '-');
                modal.find('#smart-buy-cost').text(data.cost ? `$${parseFloat(data.cost).toFixed(2)}` : '$0');
                modal.find('#smart-net-cost').text(data.selling_price ? `$${parseFloat(data.selling_price).toFixed(2)}` : '$0');
                modal.find('#smart-roi').text(data.roi ? `${data.roi}%` : '0%');
                modal.find('#smart-bsr').text(data.bsr ?? '-');

                if (data.source_url) {
                    modal.find('#supplier-link').attr('href', data.source_url).show();
                } else {
                    modal.find('#supplier-link').attr('href', '#').hide();
                }

                // 📝 Fill form fields
                modal.find('#editItemsModalLabel').text(data.name ?? '-');
                modal.find('#name').val(data.name ?? '');
                modal.find('#asin').val(data.asin ?? '');
                modal.find('#category').val(data.category ?? '');
                modal.find('#unitsPurchased').val(data.unit_purchased ?? '');
                modal.find('#costPerUnit').val(data.cost ?? '');
                modal.find('#sellingPrice').val(data.selling_price ?? '');
                modal.find('#netProfit').val(data.net_profit ?? '');
                modal.find('#roi').val(data.roi ?? '');
                modal.find('#bsr_ninety').val(data.bsr ?? '');
                modal.find('#msku').val(data.msku ?? '');
                modal.find('#listPrice').val(data.list_price ?? '');
                modal.find('#minPrice').val(data.min ?? '');
                modal.find('#maxPrice').val(data.max ?? '');
                modal.find('#supplier').val(data.supplier ?? '');
                modal.find('#source_url').val(data.source_url ?? '');
                modal.find('#brand').val(data.brand ?? '');
                modal.find('#variation').val(data.variation ?? '');
                modal.find('#promo').val(data.promo ?? '');
                modal.find('#coupon_code').val(data.coupon ?? '');
                modal.find('#product_note').val(data.product_notes ?? '');
                modal.find('#buyerNote').val(data.buyer_notes ?? '');

                // 🪟 Show modal
                modal.modal('show');
            });

            // 🟩 Handle AJAX Form Submit
            $('#edit-items-form').on('submit', function (e) {
                e.preventDefault();

                if (!editItemId) {
                    toastr.error('No item selected for editing.');
                    return;
                }

                const formData = $(this).serializeArray();
                formData.push({ name: 'id', value: editItemId });

                $.ajax({
                    url: '{{ route("orders.updateItem") }}', // <-- Your update route
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            $('#editItemsModal').modal('hide');
                            toastr.success(response.message);
                            $('#buylist-table').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error(response.message || 'Failed to update item.');
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        toastr.error('Server error occurred.');
                    }
                });
            });
        });

        $(document).ready(function () {
            let selectedItemIds = [];

            // ✅ Single reject click
            $(document).on('click', '.reject-item', function (e) {
                e.preventDefault();
                selectedItemIds = [$(this).data('id')];
                $('#rejectItemModal').modal('show');
            });

            // ✅ Bulk reject click
            $(document).on('click', '.rejectItemsBtn', function (e) {
                e.preventDefault();

                selectedItemIds = $('#buylist-table tbody input.buylist-checkbox:checked')
                    .map(function () { return $(this).data('id'); }).get();

                if (selectedItemIds.length === 0) {
                    toastr.error('Please select at least one item to reject.');
                    return;
                }

                $('.dropdown-menu').removeClass('show');
                $('#rejectItemModal').modal('show');
            });

            // ✅ Toggle custom reason input
            $(document).on('change', '#select-rejection-reason', function () {
                if ($(this).val() === 'Custom') {
                    $('#customReasonContainer').removeClass('d-none');
                } else {
                    $('#customReasonContainer').addClass('d-none');
                }
            });

            // ✅ Save reject reason (single or bulk)
            $('#rejectItemSave').on('click', function () {
                const selectedReason = $('#select-rejection-reason').val();
                const customReason = $('#customReason').val();
                const finalReason = selectedReason === 'Custom' ? customReason : selectedReason;

                if (!finalReason) {
                    toastr.error('Please select or enter a reason.');
                    return;
                }

                if (selectedItemIds.length === 0) {
                    toastr.error('No items selected.');
                    return;
                }

                $.ajax({
                    url: '{{ route("orders.rejectItemsBulk") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedItemIds,
                        reason: finalReason
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#rejectItemModal').modal('hide');
                            toastr.success('Items rejected successfully.');
                            $('#buylist-table').DataTable().ajax.reload();
                        } else {
                            toastr.error('Failed to reject items.');
                        }
                    },
                    error: function () {
                        toastr.error('Server error.');
                    }
                });
            });

            // ✅ Select all checkboxes
            $(document).on('change', '#selectAll', function () {
                const checked = $(this).is(':checked');
                $('#buylist-table tbody input.buylist-checkbox').prop('checked', checked);
                updateSelectionUI();
            });

            // ✅ Handle single checkbox
            $(document).on('change', '#buylist-table tbody input.buylist-checkbox', function () {
                const allChecked =
                    $('#buylist-table tbody input.buylist-checkbox').length ===
                    $('#buylist-table tbody input.buylist-checkbox:checked').length;

                $('#selectAll').prop('checked', allChecked);
                updateSelectionUI();
            });

            // ✅ Update selection count and button
            function updateSelectionUI() {
                const count = $('#buylist-table tbody input.buylist-checkbox:checked').length;
                $('#selectedCount').text(count);
                $('#buylist-item-count').text(count);

                if (count > 0) {
                    $('#select-count-section').removeClass('d-none');
                    $('#buylist-order-create').prop('disabled', false);
                } else {
                    $('#select-count-section').addClass('d-none');
                    $('#buylist-order-create').prop('disabled', true);
                }
            }

            // ✅ Reset when DataTable reloads
            $('#buylist-table').on('draw.dt', function () {
                $('#selectAll').prop('checked', false);
                updateSelectionUI();
            });

            // ✅ SINGLE DELETE
            $(document).on('click', '.delete-buylist-item', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This item will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/buylist/${id}`,
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire('Deleted!', response.message || 'Item deleted.', 'success');
                                    $('#buylist-table').DataTable().ajax.reload();
                                } else {
                                    Swal.fire('Failed!', response.message || 'Could not delete the item.', 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error', 'Server error. Please try again later.', 'error');
                            }
                        });
                    }
                });
            });

            // ✅ BULK DELETE
            $(document).on('click', '.bulkDelBtn', function (e) {
                e.preventDefault();

                let ids = $('#buylist-table tbody input.buylist-checkbox:checked')
                    .map(function () { return $(this).data('id'); }).get();

                if (ids.length === 0) {
                    toastr.error('Please select at least one item to delete.');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete ${ids.length} item(s).`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete all!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("buylist.bulkDelete") }}', // ✅ create this route
                            method: 'POST',
                            data: { _token: '{{ csrf_token() }}', ids: ids },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire('Deleted!', response.message || 'Items deleted successfully.', 'success');
                                    $('#buylist-table').DataTable().ajax.reload();
                                    updateSelectionUI();
                                } else {
                                    Swal.fire('Failed!', response.message || 'Failed to delete items.', 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error', 'Server error. Please try again later.', 'error');
                            }
                        });
                    }
                });
            });
        });

        // ✅ Single duplicate click
        $(document).on('click', '.duplicate-item', function (e) {
            e.preventDefault();
            const id = $(this).data('id');

            Swal.fire({
                title: 'Duplicate this item?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, duplicate it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/buylist/${id}/duplicate`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $('#buylist-table').DataTable().ajax.reload();
                            } else {
                                toastr.error(response.message || 'Duplication failed.');
                            }
                        },
                        error: function () {
                            toastr.error('Server error.');
                        }
                    });
                }
            });
        });

        $(document).ready(function () {

            $(document).on('click', '.move-item', function (e) {
                e.preventDefault();

                let itemId = $(this).data('id');

                $('#selectedItemIds').val(itemId);
                $('#moveItemCount').text('(1)');
                $('#moveToBuylistModal').modal('show');
            });

            // Bulk move click
            $(document).on('click', '.bulkMoveBtn', function (e) {
                e.preventDefault();

                let selectedIds = $('#buylist-table tbody input[type="checkbox"]:checked')
                    .map(function () { return $(this).data('id'); }).get();

                if (selectedIds.length === 0) {
                    Swal.fire('No Items Selected', 'Please select at least one item to move.', 'warning');
                    return;
                }

                $('#selectedItemIds').val(selectedIds.join(','));
                $('#moveItemCount').text(`(${selectedIds.length})`);
                $('#moveToBuylistModal').modal('show');
            });

            // Submit form
            $('#moveToBuylistForm').submit(function (e) {
                e.preventDefault();

                let buylistId = $('#targetBuylist').val();
                let itemIds = $('#selectedItemIds').val();

                if (!buylistId) {
                    Swal.fire('Required', 'Please select a target buylist.', 'error');
                    return;
                }

                $.ajax({
                    url: "{{ route('buylist.moveItems') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        buylist_id: buylistId,
                        item_ids: itemIds
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire('Moved!', res.message, 'success');
                            $('#moveToBuylistModal').modal('hide');
                            $('#buylist-table').DataTable().ajax.reload();
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                });
            });
        });

        $(document).ready(function () {
            $('#createBuylistBtn').on('click', function () {
                let name = $('#buylist_name').val().trim();

                if (!name) {
                    Swal.fire('Required', 'Please enter a buylist name.', 'warning');
                    return;
                }

                $.ajax({
                    url: "{{ route('buylist.store') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: name
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire('Created!', res.message, 'success');
                            $('#createBuylistModal').modal('hide');
                            $('#buylist_name').val('');

                            // Append new buylist to dropdown instantly
                            $('.column-list').append(`
                                <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                                    <div class="d-flex align-items-center">
                                        <input class="form-check-input me-2 buylist-filter" type="checkbox" value="${res.data.id}" id="list-${res.data.id}" checked>
                                        <label class="form-check-label mb-0" for="list-${res.data.id}">${res.data.name}</label>
                                    </div>
                                    <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y">
                                        <button class="btn btn-sm btn-outline-danger delete-buylist" data-id="${res.data.id}"><i class="ti ti-trash"></i></button>
                                    </div>
                                </div>
                            `);
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong while creating buylist.', 'error');
                    }
                });
            });

            // Delete Buylist
            $(document).on('click', '.delete-buylist', function (e) {
                e.preventDefault();
                let btn = $(this);
                let id = btn.data('id');

                Swal.fire({
                    title: 'Delete Buylist?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/buylist/${id}/delete`, // ✅ your delete route
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (res) {
                                if (res.success) {
                                    Swal.fire('Deleted!', res.message, 'success');
                                    btn.closest('.column-item').remove();
                                } else {
                                    Swal.fire('Error', res.message, 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error', 'Failed to delete buylist.', 'error');
                            }
                        });
                    }
                });
            });
        });

        // ✅ Common function for creating multiple orders
        function createMultipleOrder(selectedItems, $button) {
            // Validate selection
            if (selectedItems.length === 0) {
                toastr.error('Please select at least one item to create an order.');
                return;
            }

            // Confirm action
            Swal.fire({
                title: 'Create Order?',
                text: `You are about to create an order with ${selectedItems.length} selected item(s).`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, create order'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ✅ Disable button + show loader
                    const originalText = $button.html();
                    $button.prop('disabled', true).html('<span class="spinner-grow spinner-grow-sm me-1"></span>Creating...');

                    $.ajax({
                        url: '{{ route("orders.createMultiple") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: selectedItems
                        },
                        success: function (response) {
                            if (response.success === true) {
                                Swal.fire('Success!', response.message || 'Order created successfully.', 'success');
                                const orderId = response.order_id;
                                window.location.href = `/buy-cost-calculator/${orderId}`;
                            } else {
                                Swal.fire('Failed!', response.message || 'Failed to create order.', 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Server error. Please try again later.', 'error');
                        },
                        complete: function () {
                            // ✅ Re-enable button and restore text
                            $button.prop('disabled', false).html(originalText);
                        }
                    });
                }
            });
        }

        // ✅ Dropdown "Create Order" button
        $(document).on('click', '.createOrderMultiItem', function (e) {
            e.preventDefault();
            let selectedItems = $('#buylist-table tbody input.buylist-checkbox:checked')
                .map(function () { return $(this).data('id'); }).get();
            createMultipleOrder(selectedItems, $(this));
        });

        // ✅ Main "Create Order" button
        $(document).on('click', '#buylist-order-create', function (e) {
            e.preventDefault();
            let selectedItems = $('#buylist-table tbody input.buylist-checkbox:checked')
                .map(function () { return $(this).data('id'); }).get();
            createMultipleOrder(selectedItems, $(this));
        });
    </script>
@endsection