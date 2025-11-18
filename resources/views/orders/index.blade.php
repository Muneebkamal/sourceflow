@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Orders</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                    <form action="javascript:void(0);">
                        <div class="row g-2 mb-0 align-items-center">
                            <div class="col-auto">
                                <button class="btn btn-soft-primary export-orders">
                                    Export
                                </button>
                                <button class="btn btn-primary" id="createNewOrderButton">
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
            <div class="d-flex justify-content-between mb-2" id="table-info-top"></div>

            <div id="select-count-section" class="col-md-12 d-flex mb-2 align-items-center d-none">
                <div class="dropdown">
                    <button class="btn btn-sm btn-light" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item updateStatusBtn" href="#">Update Status</a></li>
                        <li><a class="dropdown-item text-danger bulkDelBtn" href="#">Delete</a></li>
                    </ul>
                </div>
                <span class="fw-bold ms-3">Selected: <span id="selectedCount">0</span></span>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="orders-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                    <th>Created</th>
                                    <th>Order Date</th>
                                    <th>Updated</th>
                                    <th>Closed</th>
                                    <th>Order #</th>
                                    <th>Email</th>
                                    <th>Supplier</th>
                                    <th>Shipping</th>
                                    <th>Order Total</th>
                                    <th>Card Used</th>
                                    <th>Amount Charged</th>
                                    <th>Order Status</th>
                                    <th>Destination</th>
                                    <th>O-R-L-E-F</th>
                                    <th>Order Note</th>
                                    <th>Events</th>
                                    <th>Cash Back Src</th>
                                    <th>Cash Back %</th>
                                    <th>Cash Back</th>
                                    <th class="sticky-col text-center">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between my-2" id="table-info-bottom"></div>
        </div>
    </div>

    @include('modals.order.bulk-status-modal')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var table = $('#orders-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: '{{ route("orders.data") }}',
                data: function(d) {
                    d.search = $('#searchInput').val();
                    d.status = $('#statusFilter').val();
                    d.dateRange = $('#dateRangeFilter').val();
                }
            },
            // drawCallback: function () {
            //     const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            //     tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
            // },
            scrollY: '50vh',
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            searching: false,
            lengthChange: true,
            ordering: false,
            colReorder: true, // 🔹 enable column reordering
            columns: [
                { data: 'checkbox', orderable: false, searchable: false }, // fixed, hidden from list
                { data: 'created_at', name: 'created_at' },
                { data: 'date', name: 'date' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'closed', name: 'closed' },
                { data: 'order_id', name: 'order_id' },
                { data: 'email', name: 'email' },
                { data: 'supplier', name: 'supplier' },
                { data: 'shipping_cost', name: 'shipping_cost' },
                { data: 'total', name: 'total' },
                { data: 'card_used', name: 'card_used' },
                { data: 'amount_charged', name: 'amount_charged' },
                { data: 'status', name: 'status' },
                { data: 'destination', name: 'destination' },
                { data: 'order_item_count', name: 'order_item_count' },
                { data: 'note', name: 'note' },
                { data: 'event', name: 'event' },
                { data: 'cash_back_source', name: 'cash_back_source' },
                { data: 'cash_back_percentage', name: 'cash_back_percentage' },
                { data: 'cashback', name: 'cashback' },
                { data: 'actions', orderable: false, searchable: false } // fixed, hidden from list
            ],
            dom: `<'d-flex justify-content-between'<'info-top'i><'d-flex'<'paginate-top'p><'length-top'l>>>t<'d-flex justify-content-between'<'info-bottom'i><'d-flex'<'paginate-bottom'p><'length-bottom'l>>>`,
            initComplete: function() {
                // Move elements to external containers once
                $('#table-info-top').append(
                    $('<div class="d-flex justify-content-between w-100"></div>').append(
                        $('.info-top'),
                        $('<div class="d-flex"></div>').append($('.paginate-top').addClass('me-1'), $('.length-top'))
                    )
                );

                $('#table-info-bottom').append(
                    $('<div class="d-flex justify-content-between w-100"></div>').append(
                        $('.info-bottom'),
                        $('<div class="d-flex"></div>').append($('.paginate-bottom').addClass('me-1'), $('.length-bottom'))
                    )
                );

                // Remove default text and padding
                $('.length-top label, .length-bottom label').contents().filter(function() { return this.nodeType === 3; }).remove();
                $('.paginate-top ul, .paginate-bottom ul').addClass('p-0 m-0');
                $('.dataTables_info, #buylist-table_info, .dataTables_paginate, .paging_simple_numbers').css({ padding: 0, margin: 0 });
            },
            drawCallback: function() {
                // Re-init tooltips
                $('[data-bs-toggle="tooltip"]').each(function() { new bootstrap.Tooltip(this); });
            }
        });

        function generateColumnList() {
            const columnList = $('.column-list-draggable');
            columnList.empty();

            const lockedColumns = ['order_id', 'total', 'order_item_count'];

            table.columns().every(function (index) {
                if (index === 0 || index === table.columns().count() - 1) return; // skip first & last

                const col = table.column(index);
                const title = $(col.header()).text().trim() || 'Column ' + index;
                const checked = col.visible() ? 'checked' : '';

                // get the column data name
                const colName = col.dataSrc();

                // check if column should be locked
                const isLocked = lockedColumns.includes(colName);

                columnList.append(`
                    <div class="d-flex justify-content-between align-items-center draggable-item" data-column-index="${index}">
                        <div>
                            <input class="form-check-input col-toggle" type="checkbox" ${checked} ${isLocked ? 'disabled' : ''} id="col-${index}">
                            <label class="form-check-label ms-2" for="col-${index}">${title}</label>
                        </div>
                        <i class="ti ti-grip-vertical grip-icon"></i>
                    </div>
                `);
            });
        }

        table.on('init.dt', generateColumnList);

        $(document).on('change', '.col-toggle', function() {
            const index = $(this).closest('.draggable-item').data('column-index');
            table.column(index).visible($(this).is(':checked'));
        });

        $('.column-list-draggable').sortable({
            handle: '.grip-icon',
            update: function() {
                const newMiddle = $('.column-list-draggable .draggable-item').map(function () {
                    return $(this).data('column-index');
                }).get();
                const fullOrder = [0, ...newMiddle, table.columns().count() - 1];
                table.colReorder.order(fullOrder);
            }
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
                $btn.prop('disabled', false);
                $btn.html('Reset');
            });
        });

    });

    $(document).on('click', '.export-orders', function() {
        toastr.info('Report is generating...');

        $.ajax({
            url: "{{ route('orders.export') }}",
            type: "GET",
            success: function(res) {
                if(res.status === 'success') {
                    toastr.success(res.message);
                    loadNotifications();
                }
            },
            error: function() {
                toastr.error('Failed to generate report. Please try again.');
            }
        });
    });

    $(document).ready(function () {
        function updateSelectColor($select) {
            let status = $select.val();

            if (status === 'all') {
                $select.removeClass().addClass('form-select status-select w-50');
                return;
            }

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

    $(document).ready(function () {
        function updateSelectColor($select) {
            let status = $select.val();

            if (status === 'all') {
                $select.removeClass().addClass('form-select status-select w-50');
                return;
            }

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

        // ✅ Status change event (includes AJAX)
        $(document).on('change', '.status-select', function () {
            const $select = $(this);
            const newStatus = $select.val();
            const orderId = $select.data('id');

            // Instantly update color visually
            updateSelectColor($select);

            $.ajax({
                url: `/orders/${orderId}/update-status`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus
                },
                beforeSend: function () {
                    $select.prop('disabled', true);
                },
                success: function (response) {
                    $select.prop('disabled', false);

                    if (response.success) {
                        toastr.success(response.message || 'Status updated successfully');
                    } else {
                        toastr.error(response.message || 'Failed to update status');
                    }
                },
                error: function (xhr) {
                    $select.prop('disabled', false);
                    toastr.error('Something went wrong while updating status');
                    console.error(xhr.responseText);
                }
            });
        });

        // ✅ Run once on page load for all existing selects
        $('.status-select').each(function () {
            updateSelectColor($(this));
        });
    });

    $(document).ready(function () {
        // Select all checkboxes
        $(document).on('change', '#selectAll', function () {
            const checked = $(this).is(':checked');
            $('#orders-table tbody input[type="checkbox"]').prop('checked', checked);
            updateSelectedCount();
        });

        // Handle individual checkbox selection
        $(document).on('change', '#orders-table tbody input[type="checkbox"]', function () {
            const allChecked =
                $('#orders-table tbody input[type="checkbox"]').length ===
                $('#orders-table tbody input[type="checkbox"]:checked').length;

            $('#selectAll').prop('checked', allChecked);
            updateSelectedCount();
        });

        // Function to update the count and toggle visibility
        function updateSelectedCount() {
            const count = $('#orders-table tbody input[type="checkbox"]:checked').length;
            $('#selectedCount').text(count);

            if (count > 0) {
                $('#select-count-section').removeClass('d-none');
            } else {
                $('#select-count-section').addClass('d-none');
            }
        }

        // Reset select-all and hide bar when table redraws
        $('#orders-table').on('draw.dt', function () {
            $('#selectAll').prop('checked', false);
            updateSelectedCount();
        });

        // ✅ Open modal when "Update Status" clicked
        $(document).on('click', '.updateStatusBtn', function (e) {
            e.preventDefault();
            $('.dropdown-menu').removeClass('show'); // close dropdown menu
            $('#bulkStatusModal').modal('show');
        });

        // ✅ Submit new status
        $('#bulkStatusSave').on('click', function () {
            const selectedIds = $('#orders-table tbody input[type="checkbox"]:checked')
                .map(function () { return $(this).data('id'); }).get();

            const newStatus = $('#bulkStatusSelect').val();

            if (selectedIds.length === 0 || !newStatus) {
                toastr.error('Please select rows and choose a status.');
                return;
            }

            $.ajax({
                url: '{{ route("orders.bulkUpdateStatus") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: selectedIds,
                    status: newStatus
                },
                success: function (response) {
                    if (response.success) {
                        $('#bulkStatusModal').modal('hide');
                        toastr.success('Status updated successfully');
                        $('#orders-table').DataTable().ajax.reload();
                    } else {
                        toastr.error('Failed to update status');
                    }
                },
                error: function () {
                    toastr.error('Server error');
                }
            });
        });
    });

    // $(document).on('click', '.bulkDelBtn', function (e) {
    //     e.preventDefault();

    //     const selectedIds = $('#orders-table tbody input[type="checkbox"]:checked')
    //         .map(function () { return $(this).data('id'); }).get();

    //     if (selectedIds.length === 0) {
    //         toastr.error('Please select at least one row to delete.');
    //         return;
    //     }

    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You won't be able to revert this action!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#d33',
    //         cancelButtonColor: '#6c757d',
    //         confirmButtonText: 'Yes, delete it!',
    //         cancelButtonText: 'Cancel'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 url: '{{ route("orders.bulkDelete") }}',
    //                 type: 'POST',
    //                 data: {
    //                     _token: '{{ csrf_token() }}',
    //                     ids: selectedIds
    //                 },
    //                 beforeSend: function () {
    //                     Swal.fire({
    //                         title: 'Deleting...',
    //                         text: 'Please wait a moment.',
    //                         allowOutsideClick: false,
    //                         didOpen: () => Swal.showLoading()
    //                     });
    //                 },
    //                 success: function (response) {
    //                     Swal.close();
    //                     if (response.success) {
    //                         Swal.fire({
    //                             icon: 'success',
    //                             title: 'Deleted!',
    //                             text: 'Selected orders have been deleted.',
    //                             timer: 1500,
    //                             showConfirmButton: false
    //                         });
    //                         $('#orders-table').DataTable().ajax.reload();
    //                         $('#selectAll').prop('checked', false);
    //                         $('#select-count-section').addClass('d-none');
    //                     } else {
    //                         Swal.fire({
    //                             icon: 'error',
    //                             title: 'Error!',
    //                             text: 'Failed to delete selected orders.'
    //                         });
    //                     }
    //                 },
    //                 error: function () {
    //                     Swal.close();
    //                     Swal.fire({
    //                         icon: 'error',
    //                         title: 'Server Error!',
    //                         text: 'Something went wrong. Please try again later.'
    //                     });
    //                 }
    //             });
    //         }
    //     });
    // });
    $(document).on('click', '.bulkDelBtn', function (e) {
        e.preventDefault();

        const selectedIds = $('#orders-table tbody input[type="checkbox"]:checked')
            .map(function () { return $(this).data('id'); }).get();

        if (selectedIds.length === 0) {
            toastr.error('Please select at least one row to delete.');
            return;
        }

        Swal.fire({
            title: 'Delete or Move?',
            html: `
                <p class="mb-2">Do you want to delete these orders or move their items back to the Buylist?</p>
                <div class="form-check d-flex align-items-start justify-content-center">
                    <input class="form-check-input me-2" type="checkbox" id="moveBulkToBuylist">
                    <label class="form-check-label" for="moveBulkToBuylist">
                        Move all items to Buylist instead of deleting
                    </label>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, continue!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const moveToBuylist = $('#moveBulkToBuylist').is(':checked') ? 1 : 0;

                $.ajax({
                    url: '{{ route("orders.bulkDelete") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedIds,
                        move_to_buylist: moveToBuylist
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: moveToBuylist ? 'Moving to Buylist...' : 'Deleting...',
                            text: 'Please wait a moment.',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },
                    success: function (response) {
                        Swal.close();
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Done!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            $('#orders-table').DataTable().ajax.reload();
                            $('#selectAll').prop('checked', false);
                            $('#select-count-section').addClass('d-none');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to process request.'
                            });
                        }
                    },
                    error: function () {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error!',
                            text: 'Something went wrong. Please try again later.'
                        });
                    }
                });
            }
        });
    });

    // $(document).on('click', '.singleDelBtn', function (e) {
    //     e.preventDefault();

    //     const orderId = $(this).data('id');

    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "This order will be permanently deleted.",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#d33',
    //         cancelButtonColor: '#6c757d',
    //         confirmButtonText: 'Yes, delete it!',
    //         cancelButtonText: 'Cancel'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 url: '{{ route("orders.singleDelete") }}',
    //                 type: 'POST',
    //                 data: {
    //                     _token: '{{ csrf_token() }}',
    //                     id: orderId
    //                 },
    //                 beforeSend: function () {
    //                     Swal.fire({
    //                         title: 'Deleting...',
    //                         text: 'Please wait a moment.',
    //                         allowOutsideClick: false,
    //                         didOpen: () => Swal.showLoading()
    //                     });
    //                 },
    //                 success: function (response) {
    //                     Swal.close();
    //                     if (response.success) {
    //                         Swal.fire({
    //                             icon: 'success',
    //                             title: 'Deleted!',
    //                             text: 'Order deleted successfully.',
    //                             timer: 1500,
    //                             showConfirmButton: false
    //                         });
    //                         $('#orders-table').DataTable().ajax.reload();
    //                     } else {
    //                         Swal.fire({
    //                             icon: 'error',
    //                             title: 'Error!',
    //                             text: response.message || 'Failed to delete order.'
    //                         });
    //                     }
    //                 },
    //                 error: function () {
    //                     Swal.close();
    //                     Swal.fire({
    //                         icon: 'error',
    //                         title: 'Server Error!',
    //                         text: 'Something went wrong. Please try again later.'
    //                     });
    //                 }
    //             });
    //         }
    //     });
    // });

    $(document).on('click', '.singleDelBtn', function (e) {
        e.preventDefault();

        const orderId = $(this).data('id');

        Swal.fire({
            title: 'Delete or Move?',
            html: `
                <p class="mb-2">Do you want to delete this order or move its items back to the Buylist?</p>
                <div class="form-check d-flex align-items-start justify-content-center">
                    <input class="form-check-input me-2" type="checkbox" id="moveOrderToBuylist">
                    <label class="form-check-label" for="moveOrderToBuylist">
                        Move all order items to Buylist instead of deleting
                    </label>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, continue!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const moveToBuylist = $('#moveOrderToBuylist').is(':checked') ? 1 : 0;

                $.ajax({
                    url: '{{ route("orders.singleDelete") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: orderId,
                        move_to_buylist: moveToBuylist
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait a moment.',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },
                    success: function (response) {
                        Swal.close();
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Done!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            $('#orders-table').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Something went wrong.'
                            });
                        }
                    },
                    error: function () {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error!',
                            text: 'Something went wrong. Please try again later.'
                        });
                    }
                });
            }
        });
    });

    $(document).on('click', '.duplicateBtn', function (e) {
        e.preventDefault();

        const orderId = $(this).data('id');

        Swal.fire({
            title: 'Duplicate this order?',
            text: 'A new order will be created as a copy of this one.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, duplicate it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("orders.duplicate") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: orderId
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Duplicating...',
                            text: 'Please wait a moment.',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });
                    },
                    success: function (response) {
                        Swal.close();
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Duplicated!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            $('#orders-table').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message || 'Failed to duplicate order.'
                            });
                        }
                    },
                    error: function () {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error!',
                            text: 'Something went wrong. Please try again later.'
                        });
                    }
                });
            }
        });
    });

    $('#createNewOrderButton').on('click', function () {
        $.ajax({
            url: "{{ url('/create-order') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                $('#createNewOrderButton').prop('disabled', true).text('Creating...');
            },
            success: function (data) {
                if (data.success) {
                    const orderId = data.orderId;
                    window.location.href = `/buy-cost-calculator/${orderId}`;
                } else {
                    alert(data.message || 'Something went wrong.');
                }
            },
            error: function (xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Failed to create order.'));
            },
            complete: function() {
                $('#createNewOrderButton').prop('disabled', false).text('Create Order');
            }
        });
    });
</script>
@endsection