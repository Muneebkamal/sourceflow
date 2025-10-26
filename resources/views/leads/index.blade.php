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
                        <button class="btn btn-outline-primary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#addLeadModal">Add Lead <i class="ti ti-plus fs-4 ms-1"></i></button>
                    </div>
                    <hr>
                    <button type="button" class="btn btn-soft-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#leadListSourceModal">
                        Lead List Sources <i class="ti ti-plus"></i>
                    </button>
                    <div class="column-list ps-2">
                        @foreach ($sources as $key => $source)
                            <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative {{ $key === 0 ? 'active' : '' }}" data-source-id="{{ $source->id }}">
                                <span class="fw-bold">{{ $source->list_name }}</span>
                                <div class="column-actions d-none">
                                    <i class="ti ti-trash text-danger fs-3"></i>
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
                                <table id="leads-table" class="table align-middle w-100 mb-0 table-hover">
                                    <thead class="table-light">
                                    <tr class="text-nowrap small">
                                        <th><input type="checkbox" class="form-check-input"></th>
                                        <th>Product Title</th>
                                        <th>ASIN</th>
                                        <th>Cost</th>
                                        <th>Selling Price</th>
                                        <th>Supplier</th>
                                        <th>Current BSR</th>
                                        <th>Category</th>
                                        <th>ROI</th>
                                        <th>Latest Net Profit</th>
                                        {{-- <th>Brand</th> --}}
                                        <th>90-Day BSR</th>
                                        <th>Promo</th>
                                        <th>Coupon Code</th>
                                        <th>Product Note</th>
                                        {{-- <th>Type</th> --}}
                                        <th>Created</th>
                                        <th>updated</th>
                                        <th>Publish Time</th>
                                        {{-- <th>ROI</th> --}}
                                        {{-- <th>Net Profit</th>
                                        <th>Amazon Fees</th>
                                        <th>Latest Low FBA Price</th>
                                        <th>Latest Rank</th>
                                        <th>Latest Updated</th>
                                        <th>Parent ASIN</th> --}}
                                        <th>Note</th>
                                        <th class="sticky-col text-center">Actions</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <!-- Row 1 -->
                                    {{-- <tr class="small">
                                        <td><input type="checkbox" class="form-check-input"></td>
                                        <td>2025/09/20</td>
                                        <td>B09XYZ123</td>
                                        <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                        <td>Wireless Headphones</td>
                                        <td><span class="badge bg-primary">Hot</span> <span class="badge bg-success">New</span></td>
                                        <td>Supplier A</td>
                                        <td>$789</td>
                                        <td>12,345</td>
                                        <td>Electronics</td>
                                        <td>Good margin</td>
                                        <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-light"><i class="ti ti-eye"></i></button>
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                
                                                <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                            </ul>
                                            </div>
                                        </div>
                                        </td>
                                    </tr> --}}
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
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let selectedSourceId = $('.column-item.active').data('source-id');

        var table = $('#leads-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('leads.data') }}",
                data: function(d) {
                    d.source_id = selectedSourceId;
                    d.search_text = $('#input-search').val();
                }
            },
            drawCallback: function () {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
            },
            scrollY: '40vh',
            scrollX: true,
            scrollCollapse: true,
            ordering: false,
            lengthChange: false,
            searching: false,
            columns: [
                { data: 'id', render: function(data,type,row){ return `<input type="checkbox" class="form-check-input">`; }, orderable: false },
                { data: 'name', name: 'name' },
                { data: 'asin', name: 'asin' },
                { data: 'cost', name: 'cost' },
                { data: 'sell_price', name: 'sell_price' },
                { data: 'supplier', name: 'supplier' },
                { data: 'bsr', name: 'bsr' },
                { data: 'category', name: 'category' },
                { data: 'roi', name: 'roi' },
                { data: 'net_profit', name: 'net_profit' },
                { data: 'bsr', name: 'bsr' },
                { data: 'promo', name: 'promo' },
                { data: 'coupon', name: 'coupon' },
                { data: 'notes', name: 'notes' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'date', name: 'date' },
                { data: 'notes', name: 'notes' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' },
            ]
        });

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