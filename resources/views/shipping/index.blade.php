@extends('layouts.app')

@section('title', 'Shipping Batches')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Shipping Batch List</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                    <form action="javascript:void(0);">
                        <div class="row g-2 mb-0 align-items-center">
                            <div class="col-auto">
                                <button class="btn btn-soft-primary">
                                    Export
                                </button>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShippingBatchModal">
                                    Create Shipping Batch
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
                <div class="d-flex gap-1 w-100">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input id="input-search" type="text" class="form-control" placeholder="Search...">
                    </div>
                    <select id="status-search" class="form-select w-50">
                        <option value="all">All</option>
                        <option value="open">Open</option>
                        <option value="in transit">In transit</option>
                        <option value="closed">Closed</option>
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
                    <button class="btn btn-danger">Reset</button>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="d-flex align-items-end justify-content-end">
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

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-oac_id">
                                            <label class="form-check-label" for="col-oac_id">Oac ID</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-name" checked>
                                            <label class="form-check-label" for="col-name">Name</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-status" checked>
                                            <label class="form-check-label" for="col-status">Status</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-shipped" checked>
                                            <label class="form-check-label" for="col-shipped">Shipped Date</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-1 opacity-75 draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-items" checked disabled>
                                            <label class="form-check-label" for="col-items"># Items</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-1 opacity-75 draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-tracking" checked disabled>
                                            <label class="form-check-label" for="col-tracking">Tracking #</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-note" checked>
                                            <label class="form-check-label" for="col-note">Note</label>
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
        <div class="col-md-12">
            <div id="table-section" class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="shipping-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                            <tr class="text-nowrap small">
                                <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Shipping Date</th>
                                <th>Marketplace</th>
                                <th># Items</th>
                                <th>Tracking #</th>
                                <th>Note</th>
                                <th class="sticky-col text-center">Actions</th>
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

    @include('modals.shipping.create-shipping-batch-modal')
    @include('modals.shipping.bulk-status-update-modal')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var table = $('#shipping-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "{{ route('shipping.data') }}",
                data: function (d) {
                    d.search_value = $('#input-search').val() || '';
                    d.status = $('#status-search').val() || '';
                    d.dateRange = $('#dateRangeFilter').val();
                }
            },
            scrollY: '40vh',
            scrollX: true,
            scrollCollapse: true,
            ordering: false,
            searching: false,
            lengthChange: false,
            colReorder: true,
            paging: true,
            columns: [
                { data: 'checkbox', orderable: false, searchable: false },
                { data: 'name' },
                { data: 'status' },
                { data: 'date' },
                { data: 'market_place' },
                { data: 'items' },
                { data: 'tracking_number' },
                { data: 'notes' },
                { data: 'actions', orderable: false, searchable: false }
            ],
            createdRow: function(row) {
                $(row).addClass('text-nowrap small');
            },
            initComplete: function () {
                generateColumnList(); // generate the list once table is ready
            }
        });

        function generateColumnList() {
            const columnList = $('.column-list-draggable');
            columnList.empty();

            // Columns that should be always visible (disabled)
            const lockedColumns = ['items', 'tracking_number'];

            table.columns().every(function (index) {
                // Skip first (checkbox) and last (actions)
                if (index === 0 || index === table.columns().count() - 1) return;

                const col = table.column(index);
                const title = $(col.header()).text().trim() || 'Column ' + index;
                const checked = col.visible() ? 'checked' : '';
                const colName = col.dataSrc();
                const isLocked = lockedColumns.includes(colName);

                columnList.append(`
                    <div class="d-flex justify-content-between align-items-center draggable-item ${isLocked ? 'opacity-75' : ''}" 
                        data-column-index="${index}">
                        <div>
                            <input class="form-check-input col-toggle" type="checkbox"
                                ${checked} ${isLocked ? 'checked disabled' : ''} id="col-${index}">
                            <label class="form-check-label ms-2" for="col-${index}">${title}</label>
                        </div>
                        <i class="ti ti-grip-vertical grip-icon"></i>
                    </div>
                `);
            });

            enableColumnListFeatures();
        }

        function enableColumnListFeatures() {
            // Handle show/hide
            $(document).off('change', '.col-toggle').on('change', '.col-toggle', function () {
                const index = $(this).closest('.draggable-item').data('column-index');
                const visible = $(this).is(':checked');
                table.column(index).visible(visible);
            });

            // Enable drag & drop reordering
            $('.column-list-draggable').sortable({
                handle: '.grip-icon',
                update: function() {
                    const newOrder = $('.column-list-draggable .draggable-item').map(function () {
                        return $(this).data('column-index');
                    }).get();

                    const fullOrder = [0, ...newOrder, table.columns().count() - 1];
                    table.colReorder.order(fullOrder);
                }
            });
        }

        // 🔹 Reload when search or status changes
        $('#input-search, #status-search').on('change keyup', function() {
            table.ajax.reload();
        });

        // 🔹 Date Range applied
        $('#dateRangeFilter').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            $('#clearDate').removeClass('d-none');
            table.ajax.reload(); // reload with new range
        });

        // 🔹 Date Range cancelled
        $('#dateRangeFilter').on('cancel.daterangepicker', function() {
            $(this).val('');
            $('#clearDate').addClass('d-none');
            table.ajax.reload();
        });

        // 🔹 Clear date filter
        $('#clearDate').on('click', function() {
            $('#dateRangeFilter').val('');
            $(this).addClass('d-none');
            table.ajax.reload();
        });

        // 🔹 Reset all filters
        $('.btn-danger').on('click', function() {
            var $btn = $(this);
            $btn.prop('disabled', true);
            $btn.html('<span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span>Reset');

            // clear all inputs
            $('#input-search').val('');
            $('#status-search').val('all');
            $('#dateRangeFilter').val('');
            $('#clearDate').addClass('d-none');

            table.ajax.reload(function() {
                $btn.prop('disabled', false);
                $btn.html('Reset');
            });
        });
    });

    let editBatchId = null;

    // Open modal for Add
    $('#addNewShippingBtn').on('click', function() {
        editBatchId = null;
        $('#addShippingBatchLabel').text('Add New Shipping Batch');
        $('#saveShippingBatchBtn').text('Save');

        // Clear all fields
        $('#addShippingBatchModal input, #addShippingBatchModal textarea, #addShippingBatchModal select').val('');
        $('#batchStatus').prop('selectedIndex', 0); // reset select
        $('#addShippingBatchModal').modal('show');
    });

    // Open modal for Edit
    $(document).on('click', '.editShippingBtn', function(e) {
        e.preventDefault();
        editBatchId = $(this).data('id');

        $('#addShippingBatchLabel').text('Edit Shipping Batch');
        $('#saveShippingBatchBtn').text('Update');

        $.ajax({
            url: '/shipping-batch/' + editBatchId,
            type: 'GET',
            success: function(response) {
                if(response.success) {
                    const batch = response.batch;
                    $('#batchName').val(batch.name);
                    $('#batchStatus').val(batch.status).trigger('change');
                    $('#shippedAt').val(batch.date);
                    $('#trackingNumber').val(batch.tracking_number);
                    $('#marketplace').val(batch.market_place);
                    $('#note').val(batch.notes);

                    $('#addShippingBatchModal').modal('show');
                } else {
                    toastr.error('Failed to fetch batch data.');
                }
            },
            error: function() {
                toastr.error('Something went wrong while fetching batch.');
            }
        });
    });

    // Save or Update
    $('#saveShippingBatchBtn').on('click', function() {
        const data = {
            _token: '{{ csrf_token() }}',
            name: $('#batchName').val(),
            status: $('#batchStatus').val(),
            shipped_at: $('#shippedAt').val(),
            tracking_number: $('#trackingNumber').val(),
            marketplace: $('#marketplace').val(),
            note: $('#note').val()
        };

        let url = "{{ route('shipping-batch.store') }}";
        let type = "POST";

        if(editBatchId) {
            url = '/shipping-batch/' + editBatchId;
            type = "PUT";
        }

        $.ajax({
            url: url,
            type: type,
            data: data,
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    $('#addShippingBatchModal').modal('hide');

                    // Clear fields after closing
                    $('#addShippingBatchModal input, #addShippingBatchModal textarea, #addShippingBatchModal select').val('');
                    $('#batchStatus').prop('selectedIndex', 0);

                    // Reset modal heading and button
                    $('#addShippingBatchLabel').text('Add New Shipping Batch');
                    $('#saveShippingBatchBtn').text('Save');

                    editBatchId = null;

                    $('#shipping-table').DataTable().ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                if(errors) {
                    Object.values(errors).forEach(msg => toastr.error(msg[0]));
                } else {
                    toastr.error('Something went wrong!');
                }
            }
        });
    });

    $(document).on('change', '.shipping-status', function() {
        const status = $(this).val();
        const id = $(this).data('id');

        $.ajax({
            url: '/shipping-batch/' + id + '/update-status', // new route
            type: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                if(response.success) {
                    toastr.success('Status updated successfully.');
                } else {
                    toastr.error('Failed to update status.');
                }
            },
            error: function() {
                toastr.error('Something went wrong!');
            }
        });
    });

    $(document).ready(function () {

        // Select all
        $(document).on('change', '#selectAll', function () {
            const checked = $(this).is(':checked');
            $('#shipping-table tbody .shipping-checkbox').prop('checked', checked);
            updateSelectedCount();
        });

        // Single checkbox change
        $(document).on('change', '#shipping-table tbody .shipping-checkbox', function () {
            const allChecked =
                $('#shipping-table tbody .shipping-checkbox').length ===
                $('#shipping-table tbody .shipping-checkbox:checked').length;

            $('#selectAll').prop('checked', allChecked);
            updateSelectedCount();
        });

        // Update counter and bar
        function updateSelectedCount() {
            const count = $('#shipping-table tbody .shipping-checkbox:checked').length;
            $('#selectedCount').text(count);
            if (count > 0) {
                $('#select-count-section').removeClass('d-none');
            } else {
                $('#select-count-section').addClass('d-none');
            }
        }

        // Reset on table redraw
        $('#shipping-table').on('draw.dt', function () {
            $('#selectAll').prop('checked', false);
            updateSelectedCount();
        });
    });

    $(document).ready(function() {

        // Open bulk status modal
        $(document).on('click', '.updateStatusBtn', function() {
            const selectedCount = $('#shipping-table tbody .shipping-checkbox:checked').length;
            if(selectedCount === 0) {
                toastr.warning('Please select at least one row.');
                return;
            }
            $('#bulkStatusModal').modal('show');
        });

        // Save bulk status
        $('#bulkStatusSaveBtn').on('click', function() {
            const status = $('#bulkStatusSelect').val();
            const ids = $('#shipping-table tbody .shipping-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if(!status || ids.length === 0) return;

            $.ajax({
                url: "{{ route('shipping-batch.bulk-status') }}",
                type: "PATCH",
                data: {
                    _token: '{{ csrf_token() }}',
                    ids: ids,
                    status: status
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        $('#bulkStatusModal').modal('hide');
                        $('#shipping-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Something went wrong!');
                }
            });
        });

        // Bulk delete
        $(document).on('click', '.bulkDelBtn', function() {
            const ids = $('#shipping-table tbody .shipping-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if(ids.length === 0) {
                toastr.warning('Please select at least one row.');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: `You are deleting ${ids.length} selected items!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('shipping-batch.bulk-delete') }}",
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: ids
                        },
                        success: function(response) {
                            if(response.success) {
                                toastr.success(response.message);
                                $('#shipping-table').DataTable().ajax.reload();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function() {
                            toastr.error('Something went wrong!');
                        }
                    });
                }
            });
        });

    });

    $(document).on('click', '.DelSingleBtn', function(e) {
        e.preventDefault();

        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: `You are deleting this record!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: '/shipping-batch/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.success) {
                            toastr.success(response.message);
                            $('#shipping-table').DataTable().ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong!');
                    }
                });
            }
        });
    });
</script>
@endsection