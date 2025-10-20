@extends('layouts.app')

@section('title', 'BuyList')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0 text-danger">Buy Lists (Rejected)</h4>
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
                                <button class="btn btn-primary" disabled>
                                    Create Order
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
                <a href="{{ route('buylists.index') }}" class="btn btn-soft-danger">
                    Back to Buy List <i class="ti ti-ban fs-4"></i>
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
                                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
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
                                <div class="column-list-draggable">
                                    <!-- Order note -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-order_note">
                                            <label class="form-check-label ms-2" for="col-order_note">Order note</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Date Added -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-created_at" checked>
                                            <label class="form-check-label ms-2" for="col-created_at">Date Added</label>
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

                                    <!-- Image -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-image" checked>
                                            <label class="form-check-label ms-2" for="col-image">Image</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Product Title (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-name" checked disabled>
                                            <label class="form-check-label ms-2" for="col-name">Product Title</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Variation Details -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-variation_details" checked>
                                            <label class="form-check-label ms-2" for="col-variation_details">Variation Details</label>
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

                                    <!-- Buy Cost -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-cost_per_unit" checked>
                                            <label class="form-check-label ms-2" for="col-cost_per_unit">Buy Cost</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Estimated Selling Price -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-estimated_sale_price" checked>
                                            <label class="form-check-label ms-2" for="col-estimated_sale_price">Estimated Selling Price</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Quantity (To Purchase) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-units_purchased">
                                            <label class="form-check-label ms-2" for="col-units_purchased">Quantity (To Purchase)</label>
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

                                    <!-- Promo -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-promo">
                                            <label class="form-check-label ms-2" for="col-promo">Promo</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Coupon Code -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-coupon_code">
                                            <label class="form-check-label ms-2" for="col-coupon_code">Coupon Code</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Product Note -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-product_note" checked>
                                            <label class="form-check-label ms-2" for="col-product_note">Product Note</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Buyer Note -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-buyer_note" checked>
                                            <label class="form-check-label ms-2" for="col-buyer_note">Buyer Note</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- UPC/GTIN -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-upc_code">
                                            <label class="form-check-label ms-2" for="col-upc_code">UPC/GTIN</label>
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

                                    <!-- Monthly Sold -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-monthly_sold">
                                            <label class="form-check-label ms-2" for="col-monthly_sold">Monthly Sold</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Offers -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-new_offers_count">
                                            <label class="form-check-label ms-2" for="col-new_offers_count">Offers</label>
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

                                    <!-- Buy List Name -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-buy_list_name">
                                            <label class="form-check-label ms-2" for="col-buy_list_name">Buy List Name</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Lead Type -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-lead_type">
                                            <label class="form-check-label ms-2" for="col-lead_type">Lead Type</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- SKU Total Cost -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-sku_total_cost">
                                            <label class="form-check-label ms-2" for="col-sku_total_cost">SKU Total Cost</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- ROI Est -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-roi_estimated">
                                            <label class="form-check-label ms-2" for="col-roi_estimated">ROI Est</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Net Profit Est -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-net_profit_estimated">
                                            <label class="form-check-label ms-2" for="col-net_profit_estimated">Net Profit Est</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- BSR Current -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-bsr_current">
                                            <label class="form-check-label ms-2" for="col-bsr_current">BSR Current</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Category -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-category">
                                            <label class="form-check-label ms-2" for="col-category">Category</label>
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
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body border border-4 border-danger p-0">
                    <div class="table-responsive">
                        <table id="rejected-buylist-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th><input type="checkbox" class="form-check-input"></th>
                                    <th>Rejected at</th>
                                    <th>Rejected By</th>
                                    <th>Rejected Reason</th>
                                    <th>Asin</th>
                                    <th>Image</th>
                                    <th>Product Title</th>
                                    <th>Variations</th>
                                    <th>Supplier</th>
                                    <th>Cost</th>
                                    <th>BSR 90D Avg</th>
                                    <th>Product Note</th>
                                    <th>Buyer Note</th>
                                    <th class="sticky-col">Actions</th>
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
@endsection
    
@section('scripts')
    <script>
        $(document).ready(function() {
            let table = $('#rejected-buylist-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('buylist.data.rejected') }}",
                    data: function (d) {
                        d.buylist_ids = $('.buylist-filter:checked').map(function() {
                            return $(this).val();
                        }).get();
                        d.search = $('#searchInput').val();
                    }
                },
                drawCallback: function () {
                    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
                },
                scrollY: '40vh',
                scrollX: true,
                paging: true,
                searching: false,
                ordering: true,
                lengthChange: false,
                columns: [
                    { data: null, orderable: false, render: function(){ return '<input type="checkbox" class="form-check-input">'; } },
                    { data: 'created_at' },
                    { data: 'created_by' },
                    { data: 'rejection_reason' },
                    { data: 'asin' },
                    { data: 'image', orderable: false, searchable: false },
                    { data: 'name' },
                    { data: 'variations' },
                    { data: 'supplier' },
                    { data: 'bsr' },
                    { data: 'cost' },
                    { data: 'order_note' },
                    { data: 'product_buyer_notes' },
                    { data: 'actions', orderable: false, searchable: false },
                ]
            });

            // 🔹 When Buy List checkboxes change, reload the table
            $(document).on('change', '.buylist-filter', function() {
                table.ajax.reload();
            });

            // 🔹 Optional: Search + Reset buttons
            $('#searchInput').on('keyup', function() {
                table.ajax.reload();
            });

            $('#reset-btn').on('click', function() {
                var $btn = $(this);
                $btn.prop('disabled', true);
                $btn.html('<span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span>Reset');

                $('#searchInput').val('');
                // $('.buylist-filter').prop('checked', false);

                table.ajax.reload(function() {
                    // Re-enable button after table has fully loaded
                    $btn.prop('disabled', false);
                    $btn.html('Reset');
                });
            });
        });
    </script>
@endsection