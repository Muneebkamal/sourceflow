@extends('layouts.app')

@section('title', 'Orders')

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
                                <div class="column-list-draggable">
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
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="order-items-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th><input type="checkbox" class="form-check-input"></th>
                                    <th>Order Date</th>
                                    <th>Order #</th>
                                    <th>Product Title</th>
                                    <th>Cost per Unit</th>
                                    <th>SKU Total Cost</th>
                                    <th>Order Total</th>
                                    <th>Order Status</th>
                                    <th>O-R-L-E-F</th>
                                    <th>Order Note</th>
                                    <th>Item Events</th>
                                    {{-- <th>Product Note</th>
                                    <th>Parent Order Note</th> --}}
                                    <th>Image</th>
                                    <th class="sticky-col text-center">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var table = $('#order-items-table').DataTable({
            processing: true,
            serverSide: true,
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
            columns: [
                { data: 'checkbox', orderable: false, searchable: false },
                { data: 'date', name: 'date' },
                { data: 'order_id', name: 'order_id' },
                { data: 'name', name: 'name' },
                { data: 'buy_cost', name: 'buy_cost' },
                { data: 'sku_total', name: 'sku_total' },
                { data: 'sku_total', name: 'sku_total' },
                { data: 'status', name: 'status' },
                { data: 'order_item_count', name: 'order_item_count' },
                { data: 'order_note', name: 'order_note' },
                { data: 'event', name: 'event' },
                // { data: 'total', name: 'total' },
                // { data: 'note', name: 'note' },
                { data: 'image', name: 'image' },
                { data: 'actions', orderable: false, searchable: false }
            ]
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

    });
</script>
@endsection