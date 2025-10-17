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
        <div class="col-md-8">
            <div class="d-flex align-items-center gap-1">
                <div class="d-flex gap-1">
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

        <div class="col-md-4">
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
                                <div class="column-list-draggable">

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
            <div id="table-section" class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="shipping-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                            <tr class="text-nowrap small">
                                <th><input type="checkbox" class="form-check-input"></th>
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
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let table = $('#shipping-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('shipping.data') }}",
                // data: function (d) {
                //     d.search_value = $('#input-search').val();
                //     d.status = $('#status-search').val();
                //     d.start_date = startDate;
                //     d.end_date = endDate;
                // }
            },
            scrollY: '40vh',
            scrollX: true,
            scrollCollapse: true,
            ordering: false,
            searching: false,
            lengthChange: false,
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
            // createdRow: function(row) {
            //     $(row).addClass('text-nowrap small');
            // }
        });

        // 🔹 Variables for date range
        // let startDate = null;
        // let endDate = null;

        // // 🔹 Text search
        // $('#input-search').on('keyup', function() {
        //     table.ajax.reload();
        // });

        // // 🔹 Status filter
        // $('#status-search').on('change', function() {
        //     table.ajax.reload();
        // });

        // // 🔹 Date range picker (using flatpickr or daterangepicker)
        // $('#dateRangeFilter').daterangepicker({
        //     opens: 'right',
        //     autoUpdateInput: false,
        // }, function(start, end) {
        //     startDate = start.format('YYYY-MM-DD');
        //     endDate = end.format('YYYY-MM-DD');
        //     $('#dateRangeFilter').val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
        //     $('#clearDate').removeClass('d-none');
        //     table.ajax.reload();
        // });

        // // 🔹 Clear date
        // $('#clearDate').on('click', function() {
        //     startDate = null;
        //     endDate = null;
        //     $('#dateRangeFilter').val('');
        //     $(this).addClass('d-none');
        //     table.ajax.reload();
        // });

        // // 🔹 Reset all
        // $('.btn-danger').on('click', function() {
        //     var $btn = $(this);
        //     $btn.prop('disabled', true);
        //     $btn.html('<span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span>Reset');

        //     $('#input-search').val('');
        //     $('#status-search').val('all');
        //     $('#dateRangeFilter').val('');
        //     $('#clearDate').addClass('d-none');
        //     startDate = null;
        //     endDate = null;
        //     table.ajax.reload(function() {
        //         // Re-enable button after table has fully loaded
        //         $btn.prop('disabled', false);
        //         $btn.html('Reset');
        //     });
        // });
    });
</script>
@endsection