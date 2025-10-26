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
                                {{-- <button class="btn btn-soft-primary">
                                    Export
                                </button> --}}
                                <button type="button" class="btn btn-soft-primary" data-bs-toggle="modal" data-bs-target="#createBuylistModal">
                                New Buy List
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
        <div id="select-count-section" class="col-md-12 d-flex mb-2 align-items-center d-none">
            <div class="dropdown">
                <button class="btn btn-sm btn-light" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                    <i class="ti ti-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item bulkMoveBtn" href="#">Move to Buylist</a></li>
                    <li><a class="dropdown-item text-danger bulkDelBtn" href="#">Delete</a></li>
                </ul>
            </div>
            <span class="fw-bold ms-3">Selected: <span id="selectedCount">0</span></span>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body border border-4 border-danger p-0">
                    <div class="table-responsive">
                        <table id="rejected-buylist-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
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
                                    {{-- <th class="sticky-col">Actions</th> --}}
                                    <th>Actions</th>
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
    @include('modals.buylists.move-other-buylist-modal')
    @include('modals.order.order-detail.lineitems-edit-modal')
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
                    {
                        data: 'id',
                        orderable: false,
                        render: function(data, type, row) {
                            return `<input type="checkbox" class="form-check-input buylist-checkbox" data-id="${row.id}">`;
                        }
                    },
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
                            $('#rejected-buylist-table').DataTable().ajax.reload(null, false);
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

                selectedItemIds = $('#rejected-buylist-table tbody input.buylist-checkbox:checked')
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
                            $('#rejected-buylist-table').DataTable().ajax.reload();
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
                $('#rejected-buylist-table tbody input.buylist-checkbox').prop('checked', checked);
                updateSelectionUI();
            });

            // ✅ Handle single checkbox
            $(document).on('change', '#rejected-buylist-table tbody input.buylist-checkbox', function () {
                const allChecked =
                    $('#rejected-buylist-table tbody input.buylist-checkbox').length ===
                    $('#rejected-buylist-table tbody input.buylist-checkbox:checked').length;

                $('#selectAll').prop('checked', allChecked);
                updateSelectionUI();
            });

            // ✅ Update selection count and button
            function updateSelectionUI() {
                const count = $('#rejected-buylist-table tbody input.buylist-checkbox:checked').length;
                $('#selectedCount').text(count);

                if (count > 0) {
                    $('#select-count-section').removeClass('d-none');
                } else {
                    $('#select-count-section').addClass('d-none');
                }
            }

            // ✅ Reset when DataTable reloads
            $('#rejected-buylist-table').on('draw.dt', function () {
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
                                    $('#rejected-buylist-table').DataTable().ajax.reload();
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

                let ids = $('#rejected-buylist-table tbody input.buylist-checkbox:checked')
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
                                    $('#rejected-buylist-table').DataTable().ajax.reload();
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
                                $('#rejected-buylist-table').DataTable().ajax.reload();
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

                let selectedIds = $('#rejected-buylist-table tbody input[type="checkbox"]:checked')
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
                            $('#rejected-buylist-table').DataTable().ajax.reload();
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
    </script>
@endsection