@extends('layouts.app')

@section('title', 'My Leads')

@section('styles')
    <!-- dropzone css -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/dropzone/min/dropzone.min.css') }}" type="text/css" />
    <style>
        .column-item.active {
            background-color: var(--osen-primary-bg-subtle);
            color: var(--osen-primary);
            padding: 8px 5px;
            border-radius: 5px;
            /* border-left: 3px solid var(--osen-primary); */
        }

        /* Wizard Step Design */
        .wizard-steps .step-number {
            width: 45px;
            height: 45px;
            line-height: 43px;
            background: #fff;
            font-weight: 600;
        }
        .wizard-steps .step.active .step-number {
            border: 2px solid var(--osen-success) !important;
        }
        .wizard-steps .step-line {
            flex: 0 0 90px;
            height: 2px;
            background-color: #dee2e6;
        }
        .wizard-steps .step.disabled .step-number {
            opacity: 0.5;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">My Leads</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                </div>
            </div>
        </div>
    </div>

    <div class="row g-2">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body py-2 px-1">
                    <div class="d-flex flex-wrap">
                        <button id="upload-leads" class="btn btn-primary w-100">Upload File <i class="ti ti-cloud-up fs-4 ms-1"></i></button>
                        <button type="button" class="btn btn-primary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#templateModal">
                            View/Edit Template
                        </button>
                        <button class="btn btn-outline-primary w-100 mt-2" id="addLeadModalBtn" data-bs-toggle="modal" data-bs-target="#addLeadModal">Add Lead <i class="ti ti-plus fs-4 ms-1"></i></button>
                    </div>
                    <hr>
                    <button type="button" class="btn btn-soft-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#leadListSourceModal">
                        Lead List Sources <i class="ti ti-plus"></i>
                    </button>
                    {{-- <div class="column-list ps-2">
                        @foreach ($sources as $key => $source)
                            <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative {{ $key === 0 ? 'active' : '' }}" data-source-id="{{ $source->id }}">
                                <span class="fw-bold">{{ $source->list_name }}</span>
                                <div class="column-actions d-none">
                                    <i class="ti ti-trash text-danger fs-3"></i>
                                </div>
                            </div>
                        @endforeach
                    </div> --}}
                    <div class="column-list ps-2">
                        @foreach ($sources as $key => $source)
                            <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative {{ $key === 0 ? 'active' : '' }}" data-source-id="{{ $source->id }}">
                                <span class="fw-bold">{{ $source->list_name }}</span>
                                <div class="column-actions d-none">
                                    <i class="ti ti-trash text-danger fs-3 delete-source" 
                                    data-source-id="{{ $source->id }}" 
                                    style="cursor:pointer;"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
        </div>

        {{-- for table --}}
        <div class="col-md-10" id="table-leads-section">
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
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-flex align-items-end justify-content-end">
                        <button class="btn btn-soft-primary me-1"><i class="ti ti-download fs-4 me-1"></i>Export</button>
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
                            <li><a class="dropdown-item bulkMoveLeads" href="#">Move to Lead List...</a></li>
                            <li><a class="dropdown-item updatepublishdate" href="#">Change Publish Date</a></li>
                            <li><a class="dropdown-item text-danger bulkDelBtn" href="#">Delete</a></li>
                        </ul>
                    </div>
                    <span class="fw-bold ms-3">Selected: <span id="selectedCount">0</span></span>
                </div>
                <div class="col-md-12">
                    <div id="table-section" class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="leads-table" class="table align-middle w-100 mb-0 table-hover">
                                    <thead class="table-light">
                                    <tr class="text-nowrap small">
                                        <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                        <th>Product Title</th>
                                        <th>ASIN</th>
                                        <th>Cost</th>
                                        <th>Selling Price</th>
                                        <th>Supplier</th>
                                        <th>Current BSR</th>
                                        <th>Category</th>
                                        <th>Latest ROI</th>
                                        <th>Latest Net Profit</th>
                                        <th>Brand</th>
                                        <th>90-Day BSR</th>
                                        <th>Promo</th>
                                        <th>Coupon Code</th>
                                        <th>Product Note</th>
                                        <th>Type</th>
                                        <th>Created</th>
                                        <th>updated</th>
                                        <th>Publish Time</th>
                                        <th>ROI</th>
                                        <th>Net Profit</th>
                                        <th>Amazon Fees</th>
                                        <th>Latest Low FBA Price</th>
                                        <th>Latest Rank</th>
                                        <th>Latest Updated</th>
                                        <th>Parent ASIN</th>
                                        <th>Note</th>
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
        </div>

        {{-- for upload file --}}
        <div class="col-md-10 d-none" id="upload-leads-section">
            <!-- Wizard Steps -->
            <div class="wizard-steps d-flex justify-content-center align-items-center mb-4">
                <div class="step text-center active d-flex align-items-center" data-step="1">
                    <div class="step-number border border-success rounded mx-auto">1</div>
                    <div class="fw-semibold ms-2">Upload CSV</div>
                </div>
                <div class="step-line mx-2"></div>
                <div class="step text-center d-flex align-items-center disabled" data-step="2">
                    <div class="step-number border border-2 rounded mx-auto">2</div>
                    <div class="fw-semibold ms-2">Configure Settings</div>
                </div>
                <div class="step-line mx-2"></div>
                <div class="step text-center d-flex align-items-center disabled" data-step="3">
                    <div class="step-number border border-2 rounded mx-auto">3</div>
                    <div class="fw-semibold ms-2">Review</div>
                </div>
            </div>

            <!-- STEP CONTENTS -->
            <div class="wizard-content">

                <!-- Step 1 -->
                <div class="step-content" data-step="1">
                    <div class="row g-2">
                        <!-- Upload Box -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <form action="#" 
                                        method="POST" 
                                        class="dropzone border border-2 border-dashed rounded-3 text-center"
                                        id="myAwesomeDropzone">
                                        
                                        @csrf
                                        <div class="dz-message needsclick">
                                            <i class="ti ti-cloud-upload h1 text-muted"></i>
                                            <h4 class="mt-2">Drag & Drop your file here or</h4>
                                            <button type="button" class="btn btn-outline-primary">Choose File</button>
                                        </div>
                                    </form>

                                    <!-- File Previews -->
                                    <div class="dropzone-previews" id="file-previews"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Lead Source -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <label for="lead_source" class="form-label fw-semibold">Lead List Source</label>
                                    <select class="form-select mb-3" id="lead_source">
                                        <option value="">Select Source</option>
                                        @foreach ($sources as $source)
                                            <option value="{{ $source->id }}">{{ $source->list_name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="text-center my-2 text-secondary">OR</div>

                                    <div class="text-center">
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#leadListSourceModal">
                                            Create Lead List Source <i class="bi bi-plus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button class="btn btn-primary next-btn" disabled>Next</button>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="step-content d-none" data-step="2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="fw-semibold d-flex justify-centert-center align-items-center">Select Template</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="fw-semibold d-flex justify-centert-center align-items-center">Create New Template</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 d-flex justify-content-between">
                        <button class="btn btn-outline-secondary prev-btn">Back</button>
                        <button class="btn btn-primary next-btn">Next</button>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step-content d-none" data-step="3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="fw-semibold mb-3">Review & Confirm</h5>
                            <p class="text-muted">Final review before submission.</p>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-between">
                        <button class="btn btn-outline-secondary prev-btn">Back</button>
                        <button class="btn btn-success finish-btn">Finish</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Dropzone Preview Template -->
    <div id="uploadPreviewTemplate" class="d-none">
        <div class="dz-preview dz-file-preview border rounded p-2 mb-2 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="dz-image">
                    <i class="ti ti-file-spreadsheet text-success fs-4"></i>
                </div>
                <div class="dz-details text-start">
                    <div class="dz-filename fw-semibold" data-dz-name></div>
                    <small class="text-muted" data-dz-size></small>
                </div>
            </div>
            <div>
                <button class="btn btn-sm btn-outline-danger" data-dz-remove>Remove</button>
            </div>
        </div>
    </div>


    @include('modals.leads.lead-list-sources-modal')
    @include('modals.leads.temp-edit-view-modal')
    @include('modals.leads.temp-detail-modal')
    @include('modals.leads.add-lead-modal')
    @include('modals.leads.bulk-move-leads-modal')
    @include('modals.leads.leads-bulk-date-update-modal')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let selectedSourceId = $('.column-item.active').data('source-id');

        var table = $('#leads-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            colReorder: true,
            ajax: {
                url: "{{ route('leads.data') }}",
                data: function (d) {
                    d.source_id = selectedSourceId;
                    d.search_text = $('#input-search').val();
                },
            },
            drawCallback: function () {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (el) {
                    return new bootstrap.Tooltip(el);
                });
            },
            scrollY: '40vh',
            scrollX: true,
            scrollCollapse: true,
            ordering: true,
            lengthChange: false,
            searching: false,

            columns: [
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `<input type="checkbox" class="form-check-input lead-checkbox" data-id="${row.id}">`;
                    },
                    orderable: false,
                    searchable: false
                },
                { data: 'name', name: 'name', title: 'Product Title' },
                { data: 'asin', name: 'asin', title: 'ASIN' },
                { data: 'cost', name: 'cost', title: 'Cost' },
                { data: 'sell_price', name: 'sell_price', title: 'Selling Price' },
                { data: 'supplier', name: 'supplier', title: 'Supplier' },
                { data: 'bsr', name: 'bsr', title: 'Current BSR' },
                { data: 'category', name: 'category', title: 'Category' },
                { data: 'roi', name: 'roi', title: 'Latest ROI' },
                { data: 'net_profit', name: 'net_profit', title: 'Latest Net Profit' },
                { data: null, defaultContent: '-', title: 'Brand' }, // static
                { data: null, defaultContent: '-', title: '90-Day BSR' }, // static
                { data: 'promo', name: 'promo', title: 'Promo' },
                { data: 'coupon', name: 'coupon', title: 'Coupon Code' },
                { data: 'notes', name: 'notes', title: 'Product Note' },
                { data: null, defaultContent: '-', title: 'Type' },
                { data: 'created_at', name: 'created_at', title: 'Created' },
                { data: 'updated_at', name: 'updated_at', title: 'Updated' },
                { data: 'date', name: 'publish_time', title: 'Publish Time' },
                { data: 'roi', name: 'roi', title: 'ROI' },
                { data: 'net_profit', name: 'net_profit', title: 'Net Profit' },
                { data: null, defaultContent: '-', title: 'Amazon Fees' },
                { data: null, defaultContent: '-', title: 'Latest Low FBA Price' },
                { data: null, defaultContent: '-', title: 'Latest Rank' },
                { data: 'updated_at', name: 'latest_updated_at', title: 'Latest Updated' },
                { data: null, defaultContent: '-', title: 'Parent ASIN' },
                { data: 'notes', name: 'note', title: 'Note' },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    title: 'Actions'
                }
            ],

            initComplete: function () {
                generateColumnList();
            }
        });
        table.on('draw.dt', function () {
            // Force min-height when table is empty
            $('.dataTables_scrollBody').css('min-height', '40vh');
        });

        // 🔹 Generate dynamic column list
        function generateColumnList() {
            const columnList = $('.column-list-draggable');
            columnList.empty();

            table.columns().every(function (index) {
                // Skip first (checkbox) and last (actions)
                if (index === 0 || index === table.columns().count() - 1) return;

                const col = table.column(index);
                const title = $(col.header()).text().trim() || 'Column ' + index;
                const checked = col.visible() ? 'checked' : '';

                // Columns that must always be visible and disabled
                const alwaysVisible = ['Product Title', 'ASIN', 'Cost', 'Selling Price'];

                const isDisabled = alwaysVisible.includes(title);
                const disableAttr = isDisabled ? 'disabled' : '';

                columnList.append(`
                    <div class="d-flex justify-content-between align-items-center draggable-item" 
                        data-column-index="${index}">
                        <div>
                            <input class="form-check-input col-toggle" type="checkbox" ${checked} ${disableAttr} id="col-${index}">
                            <label class="form-check-label ms-2" for="col-${index}">${title}</label>
                        </div>
                        <i class="ti ti-grip-vertical grip-icon"></i>
                    </div>
                `);
            });

            enableColumnListFeatures();
        }

        // 🔹 Enable hide/show + drag reorder
        function enableColumnListFeatures() {
            // Show/Hide columns
            $(document).off('change', '.col-toggle').on('change', '.col-toggle', function () {
                const index = $(this).closest('.draggable-item').data('column-index');
                const visible = $(this).is(':checked');
                table.column(index).visible(visible);
            });

            // Drag reorder using jQuery UI sortable
            $('.column-list-draggable').sortable({
                handle: '.grip-icon',
                update: function () {
                    const newOrder = $('.column-list-draggable .draggable-item').map(function () {
                        return $(this).data('column-index');
                    }).get();

                    // Always keep checkbox (0) first, and actions (last)
                    const fullOrder = [0, ...newOrder, table.columns().count() - 1];
                    table.colReorder.order(fullOrder, true);
                }
            });
        }


        // Click on source to filter table
        $('.column-item').on('click', function() {
            $('.column-item').removeClass('active'); // remove previous active
            $(this).addClass('active'); // mark clicked as active
            selectedSourceId = $(this).data('source-id');

            table.ajax.reload(); // reload table with new source_id
        });

        // Trigger search on input
        $('#input-search').on('keyup', function() {
            table.ajax.reload();
        });
    });

    // Template modal js
    $(document).ready(function () {
        $(document).on('click', '.view-template-btn', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');

            // Reset modal content
            $('#template_name_edit').val(name);
            $('#templateDetailModal .modal-body .list-group-item:not(:first)').remove();

            $.ajax({
                url: `/templates/${id}/details`,
                type: 'GET',
                success: function (response) {
                    if (response.success && response.data.length > 0) {
                        response.data.forEach(item => {
                            $('#templateDetailModal .modal-body').append(`
                                <li class="list-group-item border-top p-0">
                                    <div class="row">
                                        <div class="col-md-6">${item.column}</div>
                                        <div class="col-md-6">${item.value}</div>
                                    </div>
                                </li>
                            `);
                        });
                    } else {
                        $('#templateDetailModal .modal-body').append(`
                            <li class="list-group-item text-center text-muted p-2">
                                No mapping found.
                            </li>
                        `);
                    }

                    // Show modal
                    $('#templateDetailModal').modal('show');
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Failed to load template details.');
                }
            });
        });
    });

    $(document).ready(function() {
        $('#upload-leads').on('click', function() {
            const uploadSection = $('#upload-leads-section');
            const tableSection = $('#table-leads-section');
            const btn = $(this);

            if (tableSection.is(':visible')) {
                // Hide upload, show table
                tableSection.addClass('d-none');
                uploadSection.removeClass('d-none');

                // Change button text to "Back to Upload"
                btn.html('Back to Leads <i class="ti ti-arrow-left fs-4 ms-1"></i>');
            } else {
                // Show upload, hide table
                tableSection.removeClass('d-none');
                uploadSection.addClass('d-none');
                
                // Change button text to "Upload File"
                btn.html('Upload File <i class="ti ti-cloud-up fs-4 ms-1"></i>');
            }
        });
    });

    $(document).ready(function () {
        $('#leadListSourceForm').on('submit', function (e) {
            e.preventDefault();

            let formData = {
                name: $('#leadListSourceName').val(),
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: "{{ route('lead.sources.store') }}",
                method: "POST",
                data: formData,
                beforeSend: function () {
                    $('#leadListSourceForm button[type="submit"]').prop('disabled', true).text('Saving...');
                },
                success: function (response) {
                    if (response.success) {
                        $('#leadListSourceModal').modal('hide');
                        $('#leadListSourceForm')[0].reset();
                        toastr.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 2000); 
                    } else {
                        toastr.error(response.message || 'Something went wrong.');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    toastr.error('An error occurred. Please try again.');
                },
                complete: function () {
                    $('#leadListSourceForm button[type="submit"]').prop('disabled', false).text('Save Source');
                }
            });
        });
    });

    $(document).on('click', '.delete-source', function (e) {
        e.stopPropagation(); // prevent activating list item

        const sourceId = $(this).data('source-id');
        const $columnItem = $(this).closest('.column-item');

        // remove 'active' class from the deleted item
        $columnItem.removeClass('active');

        // build other sources list for move option
        let sourceOptions = '';
        $('.column-item').each(function () {
            const id = $(this).data('source-id');
            const name = $(this).find('span').text();
            if (id !== sourceId) {
                sourceOptions += `<option value="${id}">${name}</option>`;
            }
        });

        Swal.fire({
            title: 'Delete Lead List Source?',
            html: `
                <div class="form-check text-start">
                    <input class="form-check-input" type="checkbox" id="moveLeadsCheck">
                    <label class="form-check-label" for="moveLeadsCheck">
                        Move items to another Team Lead List
                    </label>
                </div>
                <div id="moveLeadsSelectDiv" class="mt-3" style="display:none;">
                    <label for="moveLeadsSelect" class="form-label">Select Team Lead List</label>
                    <select id="moveLeadsSelect" class="form-select">
                        <option value="">-- Select Source --</option>
                        ${sourceOptions}
                    </select>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                const isMove = $('#moveLeadsCheck').is(':checked');
                const targetSourceId = $('#moveLeadsSelect').val();

                if (isMove && !targetSourceId) {
                    Swal.showValidationMessage('Please select a Team Lead List to move leads.');
                    return false;
                }
                return { isMove, targetSourceId };
            },
            didOpen: () => {
                $('#moveLeadsCheck').on('change', function () {
                    $('#moveLeadsSelectDiv').toggle(this.checked);
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { isMove, targetSourceId } = result.value;

                $.ajax({
                    url: "{{ route('leadlist.source.delete') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        source_id: sourceId,
                        move_leads: isMove,
                        target_source_id: targetSourceId
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            // remove item from list without reload
                            $columnItem.fadeOut(300, function () { $(this).remove(); });
                        } else {
                            toastr.error(response.message || 'Something went wrong.');
                        }
                    },
                    error: function () {
                        toastr.error('Server error, please try again.');
                    }
                });
            }
        });
    });

    $(document).on('submit', '#addLeadForm', function (e) {
        e.preventDefault();

        const form = $(this);
        let formData = form.serialize();
        formData += '&_token={{ csrf_token() }}';

        $.ajax({
            url: "{{ route('leads.save') }}", // same route for add/update
            method: "POST",
            data: formData,
            beforeSend: function () {
                form.find('button[type="submit"]').prop('disabled', true).text('Saving...');
            },
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                    $('#addLeadForm')[0].reset();
                    $('#lead_id').val('');

                    setTimeout(() => {
                        $('#addLeadModal').modal('hide');
                        if ($.fn.DataTable.isDataTable('#leads-table')) {
                            $('#leads-table').DataTable().ajax.reload(null, false);
                        }
                    }, 1000);
                } else {
                    toastr.error(response.message || 'Something went wrong.');
                }
            },
            error: function (xhr) {
                let message = 'Server error, please try again.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    message = Object.values(errors).map(err => err.join('<br>')).join('<br>');
                }
                toastr.error(message);
            },
            complete: function () {
                form.find('button[type="submit"]').prop('disabled', false).text('Save Lead');
            }
        });
    });

    $(document).on('click', '.edit-lead', function (e) {
        e.preventDefault();
        const leadId = $(this).data('id');

        $.ajax({
            url: "{{ route('leads.show', ':id') }}".replace(':id', leadId),
            method: 'GET',
            success: function (response) {
                if (response.success) {
                    const d = response.data;

                    // Fill form fields
                    $('#lead_id').val(d.id);
                    $('#lead_source').val(d.source_id);
                    $('#name').val(d.name);
                    $('#asin').val(d.asin);
                    $('#parent_asin').val(d.parent_asin);
                    $('#category').val(d.category);
                    $('#cost').val(d.cost);
                    $('#selling_price').val(d.sell_price);
                    $('#net_profit_input').val(d.net_profit);
                    $('#roi_input').val(d.roi);
                    $('#bsr_ninety').val(d.bsr_ninety);
                    $('#supplier').val(d.supplier);
                    $('#source_url').val(d.url);
                    $('#brand').val(d.brand);
                    $('#bsr_current').val(d.bsr);
                    $('#promo').val(d.promo);
                    $('#coupon_code').val(d.coupon_code);
                    $('#list_item_note').val(d.notes);

                    // Change modal title & button text
                    $('#addLeadModalLabel').text('Edit Lead');
                    $('#addLeadForm button[type="submit"]').text('Update Lead');

                    $('#addLeadModal').modal('show');
                } else {
                    toastr.error(response.message || 'Lead not found.');
                }
            },
            error: function () {
                toastr.error('Failed to load lead data.');
            }
        });
    });

    $('#addLeadModalBtn').on('click', function () {
        $('#addLeadForm')[0].reset();
        $('#lead_id').val('');
        $('#addLeadModalLabel').text('Add New Lead');
        $('#addLeadForm button[type="submit"]').text('Save Lead');
        $('#addLeadModal').modal('show');
    });

    $(document).on('click', '.singleLeadDel', function (e) {
        e.preventDefault();
        const leadId = $(this).data('id');

        Swal.fire({
            title: 'Move or Delete Lead?',
            html: `
                <div class="text-start">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="moveLeadCheckboxSwal">
                        <label class="form-check-label" for="moveLeadCheckboxSwal">
                            Move this lead to another source
                        </label>
                    </div>
                    <div id="sourceSelectContainer" style="display:none;">
                        <label for="sourceSelectSwal" class="form-label">Select New Source</label>
                        <select id="sourceSelectSwal" class="form-select">
                            <option value="">-- Select Source --</option>
                            @foreach($sources as $source)
                                <option value="{{ $source->id }}">{{ $source->list_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Continue',
            didOpen: () => {
                // Toggle dropdown visibility based on checkbox
                $('#moveLeadCheckboxSwal').on('change', function () {
                    $('#sourceSelectContainer').toggle(this.checked);
                });
            },
            preConfirm: () => {
                const moveChecked = $('#moveLeadCheckboxSwal').is(':checked');
                const selectedSourceId = $('#sourceSelectSwal').val();

                if (moveChecked && !selectedSourceId) {
                    Swal.showValidationMessage('Please select a source to move the lead.');
                    return false;
                }

                return { moveChecked, selectedSourceId };
            }
        }).then(result => {
            if (result.isConfirmed) {
                const { moveChecked, selectedSourceId } = result.value;

                $.ajax({
                    url: "{{ route('lead.moveOrDelete') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        lead_id: leadId,
                        source_id: selectedSourceId,
                        move: moveChecked
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#leads-table').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error(response.message || 'Something went wrong.');
                        }
                    }
                });
            }
        });
    });

    // 🗑️ Bulk Delete Leads
    $(document).on('click', '.bulkDelBtn', function (e) {
        e.preventDefault();

        // Collect selected IDs
        const selectedIds = $('#leads-table tbody .lead-checkbox:checked')
            .map(function () { return $(this).data('id'); })
            .get();

        if (selectedIds.length === 0) {
            toastr.error('Please select at least one lead.');
            return;
        }

        // Confirm bulk delete
        Swal.fire({
            title: `Delete ${selectedIds.length} Lead(s)?`,
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('lead.bulkDelete') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        lead_ids: selectedIds
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message || 'Leads deleted successfully.');
                            $('#leads-table').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error(response.message || 'Something went wrong.');
                        }
                    },
                    error: function () {
                        toastr.error('Server error. Please try again.');
                    }
                });
            }
        });
    });

    //bulk move leads
    $(document).ready(function () {

        $(document).on('click', '.bulkMoveLeads', function (e) {
            e.preventDefault();

            const selectedIds = $('#leads-table tbody .lead-checkbox:checked')
                .map(function () {
                    return $(this).data('id');
                })
                .get();

            if (selectedIds.length === 0) {
                toastr.error('Please select at least one lead.');
                return;
            }

            // Store selected IDs in modal
            $('#bulkMoveLeadForm').data('selectedIds', selectedIds);
            $('#bulkMoveLeadModal').modal('show');
        });

        // Handle form submit
        $('#bulkMoveLeadForm').on('submit', function (e) {
            e.preventDefault();

            const sourceId = $('#leadSourceSelect').val();
            const selectedIds = $(this).data('selectedIds');

            if (!sourceId) {
                toastr.error('Please select a lead source.');
                return;
            }

            $.ajax({
                url: "{{ route('leads.bulk.move') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    source_id: sourceId,
                    lead_ids: selectedIds
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#bulkMoveLeadModal').modal('hide');
                        $('#leads-table').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error(response.message || 'Something went wrong.');
                    }
                },
                error: function () {
                    toastr.error('Server error occurred.');
                }
            });
        });

    });

    $(document).ready(function () {

        // Open modal when bulk "Change Publish Date" clicked
        $(document).on('click', '.updatepublishdate', function (e) {
            e.preventDefault();

            const selectedIds = $('#leads-table tbody .lead-checkbox:checked')
                .map(function () { return $(this).data('id'); }).get();

            if (selectedIds.length === 0) {
                toastr.error('Please select at least one lead.');
                return;
            }

            // Store selected IDs in modal data
            $('#bulkPublishDateModal').data('lead-ids', selectedIds);

            // Open modal
            $('#bulkPublishDateModal').modal('show');
        });

        // Submit modal form
        $(document).on('submit', '#bulkPublishDateForm', function (e) {
            e.preventDefault();

            const leadIds = $('#bulkPublishDateModal').data('lead-ids');
            const publishDate = $('#publishDateTime').val();

            if (!publishDate) {
                toastr.error('Please select a date & time.');
                return;
            }

            $.ajax({
                url: "{{ route('leads.bulkPublishDate') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    lead_ids: leadIds,
                    publish_time: publishDate
                },
                beforeSend: function () {
                    $('#bulkPublishDateForm button[type="submit"]').prop('disabled', true).text('Updating...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#bulkPublishDateModal').modal('hide');
                        $('#leads-table').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error(response.message || 'Something went wrong.');
                    }
                },
                error: function () {
                    toastr.error('Server error. Please try again.');
                },
                complete: function () {
                    $('#bulkPublishDateForm button[type="submit"]').prop('disabled', false).text('Update Date');
                }
            });
        });

    });

    $(document).ready(function () {

        // Select all
        $(document).on('change', '#selectAll', function () {
            const checked = $(this).is(':checked');
            $('#leads-table tbody .lead-checkbox').prop('checked', checked);
            updateSelectedCount();
        });

        // Single checkbox change
        $(document).on('change', '#leads-table tbody .lead-checkbox', function () {
            const allChecked =
                $('#leads-table tbody .lead-checkbox').length ===
                $('#leads-table tbody .lead-checkbox:checked').length;

            $('#selectAll').prop('checked', allChecked);
            updateSelectedCount();
        });

        // Update counter and bar
        function updateSelectedCount() {
            const count = $('#leads-table tbody .lead-checkbox:checked').length;
            $('#selectedCount').text(count);
            if (count > 0) {
                $('#select-count-section').removeClass('d-none');
            } else {
                $('#select-count-section').addClass('d-none');
            }
        }

        // Reset on table redraw
        $('#leads-table').on('draw.dt', function () {
            $('#selectAll').prop('checked', false);
            updateSelectedCount();
        });
    });

</script>

<!-- Dropzone File Upload js -->
<script src="{{ asset('assets/vendor/dropzone/min/dropzone.min.js') }}"></script>
<!-- File Upload Demo js -->
<script src="{{ asset('assets/js/pages/form-fileupload.js') }}"></script>

<script>
    $(document).ready(function() {
        Dropzone.autoDiscover = false;

        let fileSelected = false;
        let sourceSelected = false;
        const $nextBtn = $('.step-content[data-step="1"] .next-btn');

        // ✅ Function to toggle the "Next" button
        function toggleNextButton() {
            if (fileSelected && sourceSelected) {
                $nextBtn.prop('disabled', false).removeClass('opacity-50');
            } else {
                $nextBtn.prop('disabled', true).addClass('opacity-50');
            }
        }

        // ✅ Initialize Dropzone
        var myDropzone = new Dropzone("#myAwesomeDropzone", {
            paramName: "file",
            maxFilesize: 5, // MB
            acceptedFiles: ".csv",
            previewsContainer: "#file-previews",
            previewTemplate: document.querySelector("#uploadPreviewTemplate").innerHTML,
            addRemoveLinks: false,
            dictDefaultMessage: "Drop files here or click to upload",
            init: function() {
                const dzForm = $(this.element); // entire dropzone form

                // Hide form when file added
                this.on("addedfile", function(file) {
                    dzForm.hide();
                    fileSelected = true;
                    toggleNextButton();
                });

                // Show form again if all files removed
                this.on("removedfile", function(file) {
                    if (this.files.length === 0) {
                        dzForm.show();
                        fileSelected = false;
                        toggleNextButton();
                    }
                });
            }
        });

        // ✅ Lead source select change event
        $('#lead_source').on('change', function() {
            sourceSelected = $(this).val() !== "";
            toggleNextButton();
        });

        // ✅ Wizard navigation logic
        let currentStep = 1;

        function showStep(step) {
            $('.step-content').addClass('d-none');
            $(`.step-content[data-step="${step}"]`).removeClass('d-none');

            $('.wizard-steps .step').removeClass('active').addClass('disabled');
            $(`.wizard-steps .step[data-step="${step}"]`).addClass('active').removeClass('disabled');

            $('.wizard-steps .step').each(function() {
                let s = $(this).data('step');
                if (s < step) {
                    $(this).removeClass('disabled');
                    $(this).find('.step-number').addClass('border-success');
                }
            });
        }

        $('.next-btn').click(function() {
            if (currentStep < 3) {
                currentStep++;
                showStep(currentStep);
            }
        });

        $('.prev-btn').click(function() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        $('.finish-btn').click(function() {
            alert('Wizard Completed ✅');
        });
    });
</script>
@endsection