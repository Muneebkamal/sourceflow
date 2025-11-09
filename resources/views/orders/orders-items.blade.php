@extends('layouts.app')

@section('title', 'Ordered Items')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Ordered Items</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                    <form action="javascript:void(0);">
                        <div class="row g-2 mb-0 align-items-center">
                            <div class="col-auto">
                                <button class="btn btn-soft-primary">
                                    <i class="ti ti-download"></i>
                                    Export
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
            <div class="d-flex align-items-center w-100 gap-1">
                <div class="d-flex w-100 gap-1">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                    </div>
                    <select id="statusFilter" class="form-select status-select w-50">
                        <option value="all" class="bg-white text-dark">All</option>
                        <option value="partially received" class="bg-white text-dark">Partially Received</option>
                        <option value="received in full" class="bg-white text-dark">Received in Full</option>
                        <option value="ordered" class="bg-white text-dark">Ordered</option>
                        <option value="draft" class="bg-white text-dark">Draft</option>
                        <option value="closed" class="bg-white text-dark">Closed</option>
                        <option value="canceled" class="bg-white text-dark">Canceled</option>
                        <option value="reconcile" class="bg-white text-dark">Reconcile</option>
                        <option value="breakage" class="bg-white text-dark">Breakage</option>
                    </select>
                    <div class="input-group position-relative">
                        <span class="input-group-text">
                            <i class="ti ti-calendar"></i>
                        </span>
                        <!-- Input opens the calendar -->
                        <input type="text" id="dateRangeFilter" class="form-control pe-3 rounded-end" placeholder="Date Range">
                        <!-- Clear (X) icon -->
                        <button type="button" id="clearDate" class="btn position-absolute end-0 top-50 translate-middle-y me-1 p-0 border-0 bg-transparent d-none">
                            <i class="ti ti-x text-muted"></i>
                        </button>
                    </div>
                </div>

                <!-- Filter + Reset Buttons -->
                <div class="d-flex">
                    <button id="resetFilters" class="btn btn-danger">Reset</button>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="d-flex align-items-end justify-content-md-end gap-1 mt-2 mt-md-0">
                <div class="btn-group" role="group" id="viewToggle">
                    <a href="{{ route('orders.index') }}" 
                        class="btn {{ request()->routeIs('orders.index') ? 'btn-primary' : 'btn-soft-primary' }}">
                        Orders View
                    </a>
                    <a href="{{ route('orders.items') }}" 
                        class="btn {{ request()->routeIs('orders.items') ? 'btn-primary' : 'btn-soft-primary' }}">
                        Items View
                    </a>
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
                                    <!-- Created -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-created_at">
                                            <label class="form-check-label ms-2" for="col-created_at">Created</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Order Date -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-ordered_at" checked>
                                            <label class="form-check-label ms-2" for="col-ordered_at">Order Date</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Updated -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-updated_at">
                                            <label class="form-check-label ms-2" for="col-updated_at">Updated</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Closed -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-closed_at">
                                            <label class="form-check-label ms-2" for="col-closed_at">Closed</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Order # (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-order_ref_number" checked disabled>
                                            <label class="form-check-label ms-2" for="col-order_ref_number">Order #</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Email -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-email_used">
                                            <label class="form-check-label ms-2" for="col-email_used">Email</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Supplier -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-source" checked>
                                            <label class="form-check-label ms-2" for="col-source">Supplier</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Subtotal (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-sub_total" disabled>
                                            <label class="form-check-label ms-2" for="col-sub_total">Subtotal</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Tax (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-tax_paid" disabled>
                                            <label class="form-check-label ms-2" for="col-tax_paid">Tax</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Tax Rate (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-tax_percent" disabled>
                                            <label class="form-check-label ms-2" for="col-tax_percent">Tax Rate</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Shipping -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-shipping_total">
                                            <label class="form-check-label ms-2" for="col-shipping_total">Shipping</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Order Total (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-order_total" checked disabled>
                                            <label class="form-check-label ms-2" for="col-order_total">Order Total</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Card Used -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-card_used">
                                            <label class="form-check-label ms-2" for="col-card_used">Card Used</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Amount Charged -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-amount_charged">
                                            <label class="form-check-label ms-2" for="col-amount_charged">Amount Charged</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Order Status -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-awd_status" checked>
                                            <label class="form-check-label ms-2" for="col-awd_status">Order Status</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Destination -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-destination">
                                            <label class="form-check-label ms-2" for="col-destination">Destination</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- O-R-L-E-F (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-orse" checked disabled>
                                            <label class="form-check-label ms-2" for="col-orse">O-R-L-E-F</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Order Note -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-note" checked>
                                            <label class="form-check-label ms-2" for="col-note">Order Note</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Events -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-itemEvents" checked>
                                            <label class="form-check-label ms-2" for="col-itemEvents">Events</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Cash Back Src -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-cash_back_source">
                                            <label class="form-check-label ms-2" for="col-cash_back_source">Cash Back Src</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Cash Back % -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-cash_back_percent">
                                            <label class="form-check-label ms-2" for="col-cash_back_percent">Cash Back %</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Cash Back -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-cash_back_amount">
                                            <label class="form-check-label ms-2" for="col-cash_back_amount">Cash Back</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="order-items-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th><input type="checkbox" class="form-check-input"></th>
                                    <th>Supplier</th>
                                    <th>Estimated Selling Price</th>
                                    <th>Order Date</th>
                                    <th>Order #</th>
                                    <th>Bsr</th>
                                    <th>Email</th>
                                    <th>Product Title</th>
                                    <th>Asin</th>
                                    <th>Variation Details</th>
                                    <th>UCP Code</th>
                                    <th>AsinRecord</th>
                                    <th>Cost per Unit</th>
                                    <th>SKU Total Cost</th>
                                    <th>Subtotal</th>
                                    <th>Order Total</th>
                                    <th>Card Used</th>
                                    <th>Order Status</th>
                                    <th>Destination</th>
                                    <th>Units Purchased</th>
                                    <th>Units Recorded</th>
                                    <th>Units Shipped</th>
                                    <th>Units Fixed</th>
                                    <th>Unit Errors</th>
                                    <th>O-R-L-E-F</th>
                                    <th>Order Note</th>
                                    <th>Item Events</th>
                                    <th>Product Note</th>
                                    <th>List Price</th>
                                    <th>Min List Price</th>
                                    <th>Max List Price</th>
                                    <th>Parent Order Note</th>
                                    <th>Buyer Note</th>
                                    <th>Created</th>
                                    <th>Last Update</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                    {{-- <th class="sticky-col text-center">Actions</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.order.order-detail.create-event-modal')
    @include('modals.order.order-detail.lineitems-edit-modal')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var table = $('#order-items-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            stateDuration: -1,
            ajax: {
                url: '{{ route("data.orders.items") }}',
                data: function(d) {
                    d.search = $('#searchInput').val();
                    d.status = $('#statusFilter').val();
                    d.dateRange = $('#dateRangeFilter').val();
                }
            },
            drawCallback: function () {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
            },
            scrollY: '40vh',
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            searching: false,
            lengthChange: false,
            ordering: false,
            colReorder: true,
            columns: [
                { data: 'checkbox', orderable: false, searchable: false }, // 0 ✅ DO NOT SHOW IN LIST

                { data: 'supplier', name: 'supplier' },
                { data: 'selling_price', name: 'estimated_selling_price' },
                { data: 'date', name: 'date' },
                { data: 'order_id', name: 'order_id' },
                { data: 'bsr', name: 'bsr' },
                { data: 'email', name: 'email' },
                { data: 'name', name: 'name' },
                { data: 'asin', name: 'asin' },
                { data: 'variation_details', defaultContent: '--', name: 'variation_details' },
                { data: 'upc', name: 'upc' },
                { data: 'asin', name: 'asin' },
                { data: 'buy_cost', name: 'buy_cost' },
                { data: 'sku_total', name: 'sku_total' },
                { data: 'subtotal', name: 'subtotal' },
                { data: 'order_total', name: 'order_total' },
                { data: 'card_used', name: 'card_used' },
                { data: 'status', name: 'status' },
                { data: 'destination', name: 'destination' },
                { data: 'total_units_purchased', name: 'total_units_purchased' },
                { data: 'total_units_received', name: 'total_units_received' },
                { data: 'total_units_shipped', name: 'total_units_shipped' },
                { data: 'total_units_fixed', defaultContent: '--', name: 'total_units_fixed' },
                { data: 'unit_errors', name: 'unit_errors' },
                { data: 'order_item_count', name: 'order_item_count' },
                { data: 'order_note', name: 'order_note' },
                { data: 'item_events', defaultContent: '--', name: 'item_events' },
                { data: 'order_note', name: 'order_note' },
                { data: 'list_price', name: 'list_price' },
                { data: 'min', name: 'min' },
                { data: 'max', name: 'max' },
                { data: 'parent_order_note', name: 'parent_order_note' },
                { data: 'product_buyer_notes', name: 'product_buyer_notes' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'image', name: 'image' },

                { data: 'actions', orderable: false, searchable: false } // 36 ✅ DO NOT SHOW IN LIST
            ]
        });

        function generateColumnList() {
            const list = $('.column-list-draggable');
            list.find(".dynamic-col").remove(); // remove old

            table.columns().every(function (index) {
                if (index === 0 || index === table.columns().count() - 1) return; // skip first & last

                const col = table.column(index);
                const title = $(col.header()).text().trim() || `Column ${index}`;
                const visible = col.visible() ? "checked" : "";
                let disabled = '';
                if (title.toLowerCase() === 'product title') {
                    disabled = 'disabled checked';
                }

                list.append(`
                    <div class="d-flex justify-content-between align-items-center draggable-item dynamic-col" data-col="${index}">
                        <div>
                            <input class="form-check-input column-toggle" type="checkbox" data-col="${index}" ${visible} ${disabled}>
                            <label class="form-check-label ms-2">${title}</label>
                        </div>
                        <i class="ti ti-grip-vertical grip-icon"></i>
                    </div>
                `);
            });

            enableDrag();
        }

        function enableDrag() {
            $(".column-list-draggable").sortable({
                handle: ".grip-icon",
                update: function () {
                    let newOrder = [];

                    $(".dynamic-col").each(function () {
                        newOrder.push($(this).data("col"));
                    });

                    table.colReorder.order([0, ...newOrder, 36]); // keep first & last fixed
                }
            });
        }

        $(document).on("change", ".column-toggle", function () {
            const index = $(this).data("col");
            table.column(index).visible(this.checked);
        });

        table.on("init", function () {
            generateColumnList();
        });

        // Reload table when search or status changes
        $('#searchInput, #statusFilter').on('change keyup', function() {
            table.ajax.reload();
        });

        // Reload table when date range applied
        $('#dateRangeFilter').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            $('#clearDate').removeClass('d-none');
            table.ajax.reload(); // 🔹 Reload table here
        });

        // Clear date filter
        $('#dateRangeFilter').on('cancel.daterangepicker', function() {
            $(this).val('');
            $('#clearDate').addClass('d-none');
            table.ajax.reload(); // 🔹 Reload table here
        });

        $('#clearDate').on('click', function() {
            $('#dateRangeFilter').val('');
            $(this).addClass('d-none');
            table.ajax.reload(); // 🔹 Reload table here
        });

        $('#resetFilters').on('click', function() {
            var $btn = $(this);
            
            // Add spinner and disable button
            $btn.prop('disabled', true);
            $btn.html('<span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span>Reset');

            // Clear filters
            $('#searchInput').val('');
            $('#statusFilter').val('all');
            $('#dateRangeFilter').val('');
            $('#clearDate').addClass('d-none');

            // Reload DataTable
            table.ajax.reload(function() {
                // Re-enable button after table has fully loaded
                $btn.prop('disabled', false);
                $btn.html('Reset');
            });
        });

        $(document).on('submit', '#edit-items-form', function (e) {
            e.preventDefault();

            const itemId = modal.data('item-id');
            if (!itemId) {
                toastr.error('No item selected.');
                return;
            }

            const formData = $(this).serializeArray();
            formData.push({ name: 'id', value: itemId });

            $.ajax({
                url: '{{ route("orders.updateItem") }}',
                method: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message ?? 'Item updated successfully');
                        modal.modal('hide');
                        table.ajax.reload(null, false);
                    } else {
                        toastr.error(response.message ?? 'Failed to update item');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    toastr.error('Server error. Please try again.');
                }
            });
        });
    });

    // ✅ When user clicks "Create Event"
    $(document).on('click', '.create-event-btn', function () {
        let orderId = $(this).data('order-id');
        let itemId  = $(this).data('order-item-id');

        let minPrice  = $(this).data('min');
        let maxPrice  = $(this).data('max');
        let listPrice = $(this).data('list-price');

        // Reset modal fields
        $("#createEventForm")[0].reset();

        $("#order_id").val(orderId);
        $("#order_item_id").val(itemId);

        $('#list_price').val(listPrice);
        $('#max_list_price').val(maxPrice);
        $('#min_list_price').val(minPrice);

        // Open modal
        $("#createEventModal").modal("show");
    });

    // ✅ Show/Hide Sections Based on Event Type
    $("#eventType").on("change", function () {
        let type = $(this).val();

        // ✅ First hide ALL sections
        $("#section-listing").addClass("d-none");
        $("#section-replacement").addClass("d-none");
        $("#section-refund").addClass("d-none");
        $("#section-never").addClass("d-none");

        // ✅ Show ONLY the selected one
        if (type === "listing") {
            $("#section-listing").removeClass("d-none");
        }
        else if (type === "replace") {
            $("#section-replacement").removeClass("d-none");
        }
        else if (type === "return") {
            $("#section-refund").removeClass("d-none");
        }
        else if (type === "received") {
            $("#section-never").removeClass("d-none");
        }
    });

    // ✅ Auto trigger on modal open (default type=listing)
    $('#createEventModal').on('shown.bs.modal', function () {
        $("#eventType").trigger('change');
    });

    $('#createEventForm').on('submit', function (e) {
        e.preventDefault();

        let eventType = $('#eventType').val();

        // 1️⃣ Disable all inputs first
        $('#section-listing :input').prop('disabled', true);
        $('#section-replacement :input').prop('disabled', true);
        $('#section-refund :input').prop('disabled', true);
        $('#section-never :input').prop('disabled', true);

        // 2️⃣ Enable only the active section inputs
        if (eventType === 'listing') {
            $('#section-listing :input').prop('disabled', false);
        } else if (eventType === 'replace') {
            $('#section-replacement :input').prop('disabled', false);
        } else if (eventType === 'return') {
            $('#section-refund :input').prop('disabled', false);
        } else if (eventType === 'received') {
            $('#section-never :input').prop('disabled', false);
        }

        // 3️⃣ Now serialize – this will include ONLY enabled inputs
        let formData = $('#createEventForm').serialize();
        formData += '&_token={{ csrf_token() }}';

        // 4️⃣ Select correct route
        let url =
            eventType === 'listing'
                ? "{{ route('ship-events.store') }}"
                : "{{ route('event-logs.store') }}";

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function (response) {
                $('#createEventModal').modal('hide');
                // $('#order-items-table').DataTable().ajax.reload();

                // Reset form
                $('#createEventForm')[0].reset();

                // Reset QC button
                $('#qcCheckText').text("Options");
                $('.qc-btn').removeClass("btn-success text-white").addClass("btn-light");

                // ✅ Re-enable ALL inputs again
                $('#section-listing :input').prop('disabled', false);
                $('#section-replacement :input').prop('disabled', false);
                $('#section-refund :input').prop('disabled', false);
                $('#section-never :input').prop('disabled', false);

                toastr.success("Event created successfully");
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    });

    const modal = $('#editItemsModal');

    $(document).on('click', '.edit-order-item', function (e) {
        e.preventDefault();

        const item = $(this).data();
        itemsData = [item]; // only one item
        currentIndex = 0;

        populateModal(item);
        modal.modal('show');
    });

    function formatShortDate(dateString) {
        if (!dateString) return '-';
        const d = new Date(dateString);
        if (isNaN(d)) return dateString; // in case parsing fails

        let day = String(d.getDate()).padStart(2, '0');
        let month = String(d.getMonth() + 1).padStart(2, '0');
        let year = String(d.getFullYear()).slice(-2); // last 2 digits

        return `${day}/${month}/${year}`;
    }


    // ✅ Populate modal with data
    function populateModal(data) {

        modal.find('#editItemsModalLabel').text(data.name ?? '-');

        modal.find('img[alt="Product Image"]').attr('src',
            'https://app.sourceflow.io/storage/images/no-image-thumbnail.png'
        );
        modal.find('#asin-label').text(data.asin ?? '-');

        modal.find('#name').val(data.name ?? '');
        modal.find('#asin').val(data.asin ?? '');
        modal.find('#variation').val(data.variation_details ?? '');
        modal.find('#msku').val(data.msku ?? '');
        modal.find('#category').val(data.category ?? '');
        modal.find('#supplier').val(data.supplier ?? '');
        modal.find('#unitsPurchased').val(data.unit_purchased ?? '');
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
        modal.find('#coupon_code').val(data.coupon ?? '');
        modal.find('#product_note').val(data.product_notes ?? '');
        modal.find('#buyerNote').val(data.buyer_notes ?? '');

        // ✅ Smart info
        modal.find('#smart-date').text(formatShortDate(data.date));
        modal.find('#smart-supplier').text(data.supplier ?? '-');
        modal.find('#smart-buy-cost').text(data.cost ? `$${parseFloat(data.cost).toFixed(2)}` : '$0');
        modal.find('#smart-net-cost').text(data.selling_price ? `$${parseFloat(data.selling_price).toFixed(2)}` : '$0');
        modal.find('#smart-roi').text(data.roi ? `${data.roi}%` : '0%');
        modal.find('#smart-bsr').text(data.bsr ?? '-');
        modal.find('#supplier-link').attr('href', data.source_url ?? '#');

        modal.data('item-id', data.id ?? '');
    }

    $(document).on('click', '#open-links-btn', function () {
        let url = $('#supplier-link').attr('href');

        if (url && url !== '#') {
            window.open(url, '_blank');
        }
    });

    $(document).on('click', '#asin-copy', function () {
        let asin = $('#asin-label').text().trim();

        if (!asin || asin === '-') {
            toastr.error("No ASIN found!");
            return;
        }

        navigator.clipboard.writeText(asin);

        // ✅ Icon small feedback
        $(this).addClass('text-success');
        setTimeout(() => {
            $(this).removeClass('text-success');
        }, 600);

        // ✅ Toastr popup
        toastr.success("ASIN copied to clipboard!");
    });

</script>
@endsection