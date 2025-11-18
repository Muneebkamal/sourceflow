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
                        <button class="btn btn-soft-primary export-leads me-1"><i class="ti ti-download fs-4 me-1"></i>Export</button>
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
                <div class="col-md-12">
                    <div class="d-flex justify-content-between mb-2" id="table-info-top"></div>

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
                    <div class="d-flex justify-content-between my-2" id="table-info-bottom"></div>
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
                            <div id="selectCard" class="card border border-2 border-dashed">
                                <div class="card-body">
                                    <span class="fw-semibold d-flex justify-centent-center align-items-center">
                                        <h5 class="mb-0">Select Template</h5>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="newCard" class="card border border-2 border-dashed">
                                <div class="card-body">
                                    <span class="fw-semibold d-flex justify-centent-center align-items-center">
                                        <h5 class="mb-0">Create New Template</h5>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div id="select-temp-section" class="col-md-12 d-none">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <label for="">Select Template</label>
                                    <select class="form-select" name="template" id="templateSelect">
                                        <option value=""></option>
                                        @foreach ($templates as $temp)
                                            <option value="{{ $temp->id }}">{{ $temp->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h3>Upload Preview</h3>
                                    <button id="upload-data" class="btn btn-success" disabled>Upload Data</button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="select-map-table" class="table table-striped">
                                            <thead class="bg-light">
                                                <th>date</th>
                                                <th>Asin</th>
                                                <th>Source URL</th>
                                                <th>Cost</th>
                                                <th>90d BSR Avg</th>
                                                <th>Coupon Code</th>
                                                <th>Promo Details</th>
                                                <th>Notes</th>
                                                <th>Tags</th>
                                                <th>Product Title</th>
                                                <th>Selling Price</th>
                                                <th>Net Profit</th>
                                                <th>ROI</th>
                                                <th>Category</th>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="new-temp-section" class="col-md-12 d-none">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <input type="text" id="nameTemplate" class="form-control" placeholder="Enter Temp Name">
                                            </div>
                                            <hr>
                                            <div class="column-mapping">
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>Date</span>
                                                    <select class="form-select w-50" name="map_date" id="map_date"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>ASIN</span>
                                                    <select class="form-select w-50" name="map_asin" id="map_asin"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>Source URL</span>
                                                    <select class="form-select w-50" name="map_url" id="map_url"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>Cost</span>
                                                    <select class="form-select w-50" name="map_cost" id="map_cost"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>90d BSR Avg</span>
                                                    <select class="form-select w-50" name="map_bsr" id="map_bsr"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>Coupon Code</span>
                                                    <select class="form-select w-50" name="map_coupon" id="map_coupon"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>Promo Details</span>
                                                    <select class="form-select w-50" name="map_promo" id="map_promo"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>Notes</span>
                                                    <select class="form-select w-50" name="map_notes" id="map_notes"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>Tags</span>
                                                    <select class="form-select w-50" name="map_tags" id="map_tags"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>Product Title</span>
                                                    <select class="form-select w-50" name="map_name" id="map_name"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>Selling Price</span>
                                                    <select class="form-select w-50" name="map_sell_price" id="map_sell_price"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>Net Profit</span>
                                                    <select class="form-select w-50" name="map_net_profit" id="map_net_profit"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>ROI</span>
                                                    <select class="form-select w-50" name="map_roi" id="map_roi"></select>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <span>Category</span>
                                                    <select class="form-select w-50" name="map_category" id="map_category"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="table-responsive">
                                                <table id="new-temp-table" class="table table-striped border border-1 border-dashed">
                                                    <thead class="bg-light">
                                                        <th>date</th>
                                                        <th>Asin</th>
                                                        <th>Source URL</th>
                                                        <th>Cost</th>
                                                        <th>90d BSR Avg</th>
                                                        <th>Coupon Code</th>
                                                        <th>Promo Details</th>
                                                        <th>Notes</th>
                                                        <th>Tags</th>
                                                        <th>Product Title</th>
                                                        <th>Selling Price</th>
                                                        <th>Net Profit</th>
                                                        <th>ROI</th>
                                                        <th>Category</th>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button id="saveTemplateBtn" class="btn btn-primary">Save Template</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step-content d-none" data-step="3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <!-- Tabs -->
                            <ul class="nav nav-tabs mb-3" id="uploadTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="failed-tab" data-bs-toggle="tab" data-bs-target="#failed" type="button" role="tab">
                                        Failed <span class="badge badge-soft-danger fs-5" id="failed-count">0</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="bundle-tab" data-bs-toggle="tab" data-bs-target="#bundle" type="button" role="tab">
                                        Bundle <span class="badge badge-soft-primary fs-5" id="bundle-count">0</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="successful-tab" data-bs-toggle="tab" data-bs-target="#successful" type="button" role="tab">
                                        Successful <span class="badge badge-soft-success fs-5" id="successful-count">0</span>
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab Contents -->
                            <div class="tab-content" id="uploadTabsContent">
                                <!-- Failed Table -->
                                <div class="tab-pane fade show active" id="failed" role="tabpanel">
                                    <div class="d-flex justify-content-end mb-2">
                                        <button class="btn btn-danger me-1 discard-all-failed">Discard All Failed</button>
                                        <button class="btn btn-primary failed-leads-edit me-1" data-index="0">Edit</button>
                                        <button id="FailedTableDone" class="btn btn-success">Done</button>
                                    </div>
                                    <table class="table table-striped">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="checkAllFailed">
                                                    </div>
                                                </th>
                                                <th>Errors</th>
                                                <th>ASIN</th>
                                                <th>Product Title</th>
                                                <th>Source URL</th>
                                                <th>Supplier</th>
                                                <th>90d BSR Avg</th>
                                                <th>Category</th>
                                                <th>Cost</th>
                                                <th>Selling Price</th>
                                                <th>Promo</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="failed-body"></tbody>
                                    </table>
                                </div>

                                <!-- Bundle Table -->
                                <div class="tab-pane fade" id="bundle" role="tabpanel">
                                    <div class="d-flex justify-content-end mb-2">
                                        <button class="btn btn-primary">Done</button>
                                    </div>
                                    <table class="table table-striped table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>ASIN</th>
                                                <th>Product Title</th>
                                                <th>Source URL</th>
                                                <th>Supplier</th>
                                                <th>90d BSR Avg</th>
                                                <th>Category</th>
                                                <th>Cost</th>
                                                <th>Selling Price</th>
                                                <th>Promo</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bundle-body"></tbody>
                                    </table>
                                </div>

                                <!-- Successful Table -->
                                <div class="tab-pane fade" id="successful" role="tabpanel">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div id="select-count-success-leads" class="d-flex mb-2 align-items-center d-none">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item updatepublishdateSuccess" href="#">Change Publish Date</a></li>
                                                    <li><a class="dropdown-item text-danger bulkDelBtnSuccess" href="#">Delete</a></li>
                                                </ul>
                                            </div>
                                            <span class="fw-bold ms-3 d-flex">Selected: <span id="selectedCountSuccess">0</span></span>
                                        </div>
                                        <div class="d-flex justify-content-end w-100">
                                            <button id="successTableDone" class="btn btn-success">Done</button>
                                        </div>
                                    </div>
                                    <table class="table table-striped">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="checkAllSuccess">
                                                    </div>
                                                </th>
                                                <th>ASIN</th>
                                                <th>Product Title</th>
                                                <th>Source URL</th>
                                                <th>Supplier</th>
                                                <th>90d BSR Avg</th>
                                                <th>Category</th>
                                                <th>Cost</th>
                                                <th>Selling Price</th>
                                                <th>Promo</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="successful-body"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
    @include('modals.leads.edit-failed-leads-modal')
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
            // drawCallback: function () {
            //     const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            //     tooltipTriggerList.map(function (el) {
            //         return new bootstrap.Tooltip(el);
            //     });
            // },
            scrollY: '50vh',
            scrollX: true,
            scrollCollapse: true,
            ordering: true,
            lengthChange: true,
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
            dom: `<'d-flex justify-content-between'<'info-top'i><'d-flex'<'paginate-top'p><'length-top'l>>>t<'d-flex justify-content-between'<'info-bottom'i><'d-flex'<'paginate-bottom'p><'length-bottom'l>>>`,
            initComplete: function() {
                generateColumnList();

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

            // initComplete: function () {
            //     generateColumnList();
            // }
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

    $(document).on('click', '.export-leads', function() {
        const activeSourceId = $('.column-item.active').data('source-id');
        toastr.info('Report is generating...');

        $.ajax({
            url: "{{ route('leads.export') }}",
            type: "GET",
            data: { source_id: activeSourceId },
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

    // Template modal js
    $(document).ready(function () {
        $(document).on('click', '.view-template-btn', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');

            // Reset modal content
            $('#template_id_edit').val(id);
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

        // Update template name via AJAX
        $(document).on('click', '#updateTemplateBtn', function () {
            let id = $('#template_id_edit').val();
            let name = $('#template_name_edit').val().trim();

            if (!name) {
                toastr.error('Template name cannot be empty');
                return;
            }

            $.ajax({
                url: `/update/template/${id}`, // Your update route
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name
                },
                success: function (res) {
                    if (res.status === 'success') {
                        toastr.success(res.message);
                        $('#templateDetailModal').modal('hide');

                        // Update template name in select/options or button list
                        $(`option[value="${id}"]`).text(name);
                        $(`.view-template-btn[data-id="${id}"]`).data('name', name);
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function () {
                    toastr.error('Something went wrong');
                }
            });
        });
    });

    $(document).ready(function () {
        // Custom dropdown adapter
        $.fn.select2.amd.require(['select2/utils', 'select2/dropdown', 'select2/dropdown/attachBody'],
            function (Utils, Dropdown, AttachBody) {
                function CustomDropdown() {}
                CustomDropdown.prototype.render = function () {
                    var $dropdown = Dropdown.prototype.render.call(this);
                    $dropdown.addClass('custom-template-dropdown');
                    return $dropdown;
                };

                // Apply the adapter
                var CustomAdapter = Utils.Decorate(Dropdown, AttachBody);
                $('#templateSelect').select2({
                    width: '100%',
                    dropdownAdapter: CustomAdapter,
                    templateResult: function (data) {
                        if (!data.id) return data.text;
                        return $(`
                            <div class="d-flex justify-content-between align-items-center">
                                <span>${data.text}</span>
                                <button type="button" class="btn btn-sm btn-soft-danger temp-del" data-id="${data.id}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        `);
                    },
                    escapeMarkup: m => m
                });
            });

        // Normal click works fine here
        $(document).on('click', '.temp-del', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const id = $(this).data('id');
            const $li = $(this).closest('li');

            Swal.fire({
                title: 'Delete this template?',
                text: 'You will not be able to recover it!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/template/' + id,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (res) {
                            if (res.status === 'success') {
                                Swal.fire('Deleted!', res.message, 'success');
                                
                                if ($li.length) {
                                    $li.remove();
                                }
                                        
                                $('#templateSelect option[value="' + id + '"]').remove();
                                $('#templateSelect').val(null).trigger('change');
                            }
                        }
                    });
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

                        let source = response.data;
                        $('#lead_source').append(`
                            <option value="${source.id}" selected>${source.list_name}</option>
                        `);
                        $('#lead_source').val(source.id).change();

                        let newItem = `
                            <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative"
                                data-source-id="${source.id}">

                                <span class="fw-bold">
                                    ${source.list_name}
                                </span>

                                <div class="">
                                    <span class="badge bg-success ms-2 new-badge">New</span>
                                </div>
                            </div>
                        `;

                        $('.column-list').prepend(newItem);
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

    let editingLeadId = null;
    $(document).on('click', '.edit-lead', function (e) {
        e.preventDefault();
        const leadId = $(this).data('id');
        editingLeadId = leadId;

        $.ajax({
            url: "{{ route('leads.show', ':id') }}".replace(':id', leadId),
            method: 'GET',
            success: function (response) {
                if (response.success) {
                    const d = response.data;

                    // Fill form fields
                    $('#lead_id').val(d.id);
                    $('#lead_source_id').val(String(d.source_id)).trigger('change');
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
        editingLeadId = null;
        $('#addLeadForm')[0].reset();
        $('#lead_id').val('');
        $('#addLeadModalLabel').text('Add New Lead');
        $('#addLeadForm button[type="submit"]').text('Save Lead');
        $('#addLeadModal').modal('show');
    });

    $(document).on('click', '.singleLeadDel', function (e) {
        e.preventDefault();
        const $btn = $(this);
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
                            // Remove the row from the table
                            const $row = $btn.closest('tr');
                            const $tableBody = $row.closest('tbody');
                            $row.remove();

                            // Update counts dynamically
                            if ($tableBody.attr('id') === 'successful-body') {
                                $('#successful-count').text($tableBody.find('tr').length);
                            }

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
        const HEADER_KEY_MAP = {
            "date": "date",
            "asin": "asin",
            "source_url": "url",
            "cost": "cost",
            "90d_bsr_avg": "bsr",
            "coupon_code": "coupon",
            "promo_details": "promo",
            "notes": "notes",
            "tags": "tags",
            "product_title": "name",
            "selling_price": "sell_price",
            "net_profit": "net_profit",
            "roi": "roi",
            "category": "category"
        };


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
            url: "{{ route('leads.upload') }}",
            paramName: "file",
            maxFiles: 1,
            maxFilesize: 5, // MB
            acceptedFiles: ".csv",
            previewsContainer: "#file-previews",
            previewTemplate: document.querySelector("#uploadPreviewTemplate").innerHTML,
            addRemoveLinks: false,
            dictDefaultMessage: "Drop files here or click to upload",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
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


        let csvColumns = [];
        let csvRows = [];
        let mappingTemplate = {}; // Global mapping for new template

        // -------------------- Dropzone Success --------------------
        let uploadedFilePath = "";
        myDropzone.on("success", function(file, response) {
            const csvHeaders = response.headers;
            csvRows = response.rows;

            // Fill new template select boxes
            $("#new-temp-section .column-mapping select").each(function() {
                const $select = $(this);
                $select.empty().append('<option value="">Select Column</option>');
                csvHeaders.forEach(col => $select.append(`<option value="${col}">${col}</option>`));

                uploadedFilePath = response.file_path;

                // Optional: auto-match header with DB column name
                // const name = $select.attr("name").replace("map_", "");
                // const match = csvHeaders.find(col => col.toLowerCase() === name);
                // if (match) $select.val(match);
                // mappingTemplate[name] = $select.val() || null;
            });

            // Bind change handler for new template
            $("#new-temp-section .column-mapping select").off("change").on("change", function() {
                const name = $(this).attr("name").replace("map_", "");
                mappingTemplate[name] = $(this).val();
                updateNewTempTable();
            });

            updateNewTempTable();
        });

        // -------------------- Update New Template Table --------------------
        function updateNewTempTable() {
            const $table = $("#new-temp-table");
            $table.find("tbody").remove();
            const tbody = $("<tbody></tbody>");

            csvRows.forEach(row => {
                const tr = $("<tr></tr>");
                $table.find("thead th").each(function() {
                    let key = $(this).text().trim().replace(/\s+/g, '_').toLowerCase();
                    let mapKey = HEADER_KEY_MAP[key] || key;
                    const col = mappingTemplate[mapKey];
                    tr.append(`<td>${row[col] || ""}</td>`);
                });
                tbody.append(tr);
            });

            $table.append(tbody);
        }

        // -------------------- Save Template --------------------
        $('#saveTemplateBtn').on('click', function() {
            // const requiredColumns = ['name', 'asin'];
            // const missingColumns = requiredColumns.filter(col => !mappingTemplate[col]);
            // if (missingColumns.length) {
            //     toastr.error(`Please map the following required fields: ${missingColumns.join(', ')}`);
            //     return;
            // }

            const nameTemplate = $('#nameTemplate').val();
            if (!nameTemplate) {
                toastr.error('Template Name is Required');
                return;
            }

            let mappedColumns = {};
            Object.keys(mappingTemplate).forEach(k => {
                if (mappingTemplate[k]) mappedColumns[k] = mappingTemplate[k];
            });

            $.ajax({
                url: "{{ url('save-mapping-template') }}",
                type: 'POST',
                data: { db_columns: mappingTemplate, mapped_columns: mappedColumns, name: nameTemplate, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.exists){ 
                        toastr.error('Template with this name already exists');
                    } else { 
                        toastr.success('Template saved successfully!');
                        // ✅ Highlight Select Template card (reuse toggle logic)
                        $("#selectCard").addClass("bg-soft-primary");
                        $("#newCard").removeClass("bg-soft-primary");

                        // ✅ Show select section & hide new template section
                        $("#select-temp-section").removeClass("d-none");
                        $("#new-temp-section").addClass("d-none");

                        // ✅ Add new template to select dropdown and select it
                        const $select = $('select[name="template"]');
                        const newOption = $('<option></option>')
                            .val(response.template.id)
                            .text(response.template.name);
                        $select.append(newOption).val(response.template.id);

                        // ✅ Trigger change to fill the select-map-table
                        $select.trigger('change');

                        // ✅ Disable upload button until needed
                        $('#select-temp-section .btn-success').prop('disabled', true);
                        $('#upload-data').prop('disabled', false);

                        // Optional: Reset new template form
                        $('#nameTemplate').val('');
                        $("#new-temp-section select").val('');
                    }
                },
                error: function(xhr, status, error) { console.error('Error:', error); }
            });
        });

        // -------------------- Load Saved Template Mapping --------------------
        $('select[name="template"]').on('change', function() {
            const templateId = $(this).val();
            if (templateId) {
                $('#upload-data').prop('disabled', false);
            } else {
                $('#upload-data').prop('disabled', true);
            }
            if (!templateId) return;

            $.ajax({
                url: `/templates/${templateId}/mapping`,
                method: "GET",
                success: function(res) {
                    if (res.status) {
                        const mapping = res.mapping; // { Date: "date_col", ... }
                        // console.log(mapping);
                        // Highlight mapped columns (optional)
                        // fillSelectedTemplate(mapping);

                        // Fill the Select Template table
                        const $table = $("#select-map-table");
                        $table.find("tbody").remove();
                        const tbody = $("<tbody></tbody>");

                        csvRows.forEach(row => {
                            const tr = $("<tr></tr>");
                            $table.find("thead th").each(function() {
                                // const header = $(this).text().trim();
                                // const col = mapping[header] || mapping[header.toLowerCase()] || "";
                                let key = $(this).text().trim().replace(/\s+/g, '_').toLowerCase();
                                let mapKey = HEADER_KEY_MAP[key] || key;
                                const col = mapping[mapKey] || "";

                                tr.append(`<td>${row[col] || ""}</td>`);
                            });
                            tbody.append(tr);
                        });

                        $table.append(tbody);
                    }
                }
            });
        });

        // -------------------- Highlight Select Template Mapping --------------------
        // function fillSelectedTemplate(map) {
        //     $("#select-temp-section table thead th").each(function() {
        //         let key = $(this).text().trim();
        //         let match = map[key] ?? map[key.toLowerCase()] ?? null;

        //         if (match) {
        //             $(this).css("background", "#d1e7ff").attr("title", "Mapped: " + match);
        //         } else {
        //             $(this).css("background", "#f8d7da").attr("title", "Not Mapped");
        //         }
        //     });
        // }

        // Upload Data click handler
        $("#upload-data").on("click", function() {
            const $btn = $(this);
            $btn.html('<span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span>Uploading');
            $btn.prop('disabled', true);

            const templateId = $('select[name="template"]').val();
            const sourceId = $("#lead_source").val();

            if (!templateId) {
                toastr.error("Please select a template");
                $btn.html('Upload Data'); // reset button
                $btn.prop('disabled', false);
                return;
            }

            // Get uploaded file from Dropzone
            if (!myDropzone.files || myDropzone.files.length === 0) {
                toastr.error("Please upload a CSV file first");
                $btn.html('Upload Data'); // reset button
                $btn.prop('disabled', false);
                return;
            }

            let formData = new FormData();
            formData.append('file', myDropzone.files[0]);
            formData.append('template_id', templateId);
            formData.append('source_id', sourceId);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('leads.import.file') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    // console.log(res);
                    if (res.status) {
                        /* =====================================
                        ✅ DELETE UPLOADED FILE FROM STORAGE
                        ===================================== */
                        if (uploadedFilePath) {
                            $.ajax({
                                url: "{{ route('leads.delete.upload') }}",
                                type: "DELETE",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    file_path: uploadedFilePath
                                },
                                success: function(delRes) {
                                    if (delRes.status) {
                                        console.log('File deleted successfully');
                                    } else {
                                        console.warn('File delete failed:', delRes.message);
                                    }
                                },
                                error: function() {
                                    console.error('Error deleting uploaded file.');
                                }
                            });
                        }
                        /* ================================
                        ✅ SUCCESSFUL LEADS TABLE
                        ================================= */
                        const successOrder = [
                            "asin", "name", "url", "supplier",
                            "bsr", "category", "cost", "sell_price", "promo"
                        ];

                        const $success = $("#successful-body").empty();

                        res.success.forEach(r => {
                            const leadId = r.id ?? 0;

                            let tr = `<tr data-id="${leadId}">`;

                            // ✅ Checkbox
                            tr += `
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input row-check" data-id="${r.id || ''}">
                                    </div>
                                </td>`;

                            // ✅ Add fields in FIXED ORDER (always match table header)
                            successOrder.forEach(key => {
                                tr += `<td>${r[key] ?? ''}</td>`;
                            });

                            // ✅ ALWAYS last → ACTIONS
                            tr += `
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="" data-id="${leadId}" class="btn btn-sm btn-light singleLeadDel">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                        <a href="" data-id="${leadId}" class="btn btn-sm btn-light edit-lead">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" data-id="" href="#">Un-Bundle</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            `;

                            tr += "</tr>";
                            $success.append(tr);
                        });


                        /* ================================
                        ✅ FAILED LEADS TABLE
                        ================================= */
                        const failedOrder = [
                            "asin", "product_title", "url", "supplier",
                            "bsr_90d_avg", "category", "cost", "selling_price", "promo"
                        ];

                        const $failed = $("#failed-body").empty();

                        window.failedList = res.failed;
                        // let index = 0;
                        // res.failed.forEach(r => {
                        $failed.empty();
                        res.failed.forEach((r, i) => {

                            let tr = `<tr class="text-danger" >`;
                            // index++;

                            // ✅ Checkbox
                            tr += `
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input row-check">
                                    </div>
                                </td>`;

                            // ✅ Error column
                            tr += `<td>${r.error}</td>`;

                            // ✅ Add fields in fixed order
                            failedOrder.forEach(key => {
                                tr += `<td>${r[key] ?? ''}</td>`;
                            });

                            // ✅ ALWAYS LAST → ACTIONS
                            tr += `
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="" class="btn btn-sm btn-light remove-row">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                        <a href="" class="btn btn-sm btn-light failed-leads-edit"  data-index="${i}">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" data-id="" href="#">Duplicate Item</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            `;

                            tr += "</tr>";
                            $failed.append(tr);
                        });

                        /* ================================
                        ✅ COUNTS + SUCCESS MESSAGE
                        ================================= */
                        $('#successful-count').text(res.success_count);
                        $('#failed-count').text(res.failed_count);
                        toastr.success(res.message);
                        showStep(3);

                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    toastr.error("Error uploading file");
                }
            });
        });

        $(document).on('input change', '#addLeadModal input, #addLeadModal select, #addLeadModal textarea', function () {
            if (!editingLeadId) return; // no lead currently being edited

            // Get updated values from modal
            const name = $('#name').val();
            const asin = $('#asin').val();
            const url = $('#source_url').val();
            const supplier = $('#supplier').val();
            const bsr = $('#bsr_current').val();
            const category = $('#category').val();
            const cost = $('#cost').val();
            const sellPrice = $('#selling_price').val();
            const promo = $('#promo').val();

            // Find table row matching lead ID
            const $row = $(`#successful-body tr[data-id="${editingLeadId}"]`);
            if ($row.length) {
                // Update specific columns in correct order
                const tds = $row.find('td');

                // Order based on your header (after checkbox)
                $(tds[1]).text(asin);
                $(tds[2]).text(name);
                $(tds[3]).text(url);
                $(tds[4]).text(supplier);
                $(tds[5]).text(bsr);
                $(tds[6]).text(category);
                $(tds[7]).text(cost);
                $(tds[8]).text(sellPrice);
                $(tds[9]).text(promo);
            }
        });

        // let currentFailedIndex = 0;
        // $(document).on("click", ".failed-leads-edit", function(e) {
        //     e.preventDefault();

        //     // Only proceed if button has a data-index
        //     const index = $(this).data("index");
        //     if (index === undefined) return;

        //     currentFailedIndex = parseInt(index);
        //     loadFailedItem(currentFailedIndex);

        //     $("#editFailedLeadsModal").modal("show");
        // });
        let currentFailedIndex = -1;
        $(document).on("click", ".failed-leads-edit", function(e) {
            e.preventDefault();

            const rawIndex = $(this).data("index");
            if (rawIndex === undefined) return;

            const index = Number(rawIndex);
            if (Number.isNaN(index) || !window.failedList || index < 0 || index >= window.failedList.length) return;

            currentFailedIndex = index;
            loadFailedItem(currentFailedIndex);

            $("#editFailedLeadsModal").modal("show");
        });

        function loadFailedItem(index) {
            const item = window.failedList[index];
            console.log(item);
            if (!item) return;
            var failedSourceId = $("#lead_source").val();
            $("#item-position-failed").text((index + 1) + " of " + window.failedList.length);

            // ✅ Fill modal fields
            $("#source_id_failed").val(failedSourceId);
            $("#e_l_name").val(item.product_title);
            $("#e_l_category").val(item.category);
            $("#e_l_asin").val(item.asin);
            $("#e_l_source_url").val(item.url);
            $("#e_l_supplier").val(item.supplier);
            $("#e_l_bsr_ninety").val(item.bsr_90d_avg);
            $("#e_l_costPerUnit").val(item.cost);
            $("#e_l_sellingPrice").val(item.selling_price);
            // $("#e_l_currency_code").val(item.currency_code ?? "");
            $("#e_l_promo").val(item.promo);
            $("#e_l_coupon_code").val(item.coupon_code ?? "");
            // $("#e_l_line_item_note").val(item.line_item_note ?? "");
            $("#e_l_publish_time").val(item.publish_time ?? "");
            // $("#e_l_parent_asin").val(item.parent_asin ?? "");
            $("#e_l_roi").val(item.roi ?? "");
            $("#e_l_netProfit").val(item.net_profit ?? "");
            // $("#e_l_tags").val(item.tags ?? "");

            // // ✅ Load product image (if exists)
            // $(".modal-header img").attr("src", item.image ?? "https://app.sourceflow.io/storage/images/no-image-thumbnail.png");

            // // ✅ ASIN text above
            // $("#asin-label").text(item.asin || "-");

            // ✅ Next / Prev button state
            $("#prev-item-failed").prop("disabled", index === 0);
            $("#next-item-failed").prop("disabled", index === window.failedList.length - 1);
        }
        // function loadFailedItem(index) {
        //     if (!Array.isArray(window.failedList)) return;
        //     if (index < 0 || index >= window.failedList.length) return;

        //     const item = window.failedList[index];
        //     if (!item) return;
        //     console.log(item);
        //     $("#item-position-failed").text((index + 1) + " of " + window.failedList.length);

        //     // fill modal fields...
        //     // (existing assignments)
            
        //     $("#prev-item-failed").prop("disabled", index === 0);
        //     $("#next-item-failed").prop("disabled", index === window.failedList.length - 1);
        // }

        $("#prev-item-failed").on("click", function () {
            if (currentFailedIndex > 0) {
                currentFailedIndex--;
                loadFailedItem(currentFailedIndex);
            }
        });

        $("#next-item-failed").on("click", function () {
            if (currentFailedIndex < window.failedList.length - 1) {
                currentFailedIndex++;
                loadFailedItem(currentFailedIndex);
            }
        });

        $("#failed-lead-edit-form").on("submit", function(e) {
            e.preventDefault();

            const formData = $(this).serialize(); // serialize all inputs

            $.ajax({
                url: "{{ route('leads.failed.new') }}", // new route for creating lead
                type: "POST",
                data: formData,
                success: function(res) {
                    if(res.status) {
                        // Close modal
                        $("#editFailedLeadsModal").modal("hide");

                        // Optional: Remove from failed table if applicable
                        // if(currentFailedIndex !== undefined){
                        //     window.failedList.splice(currentFailedIndex, 1);
                        //     $("#failed-body tr").eq(currentFailedIndex).remove();

                        //     // ✅ Re-index remaining failed items
                        //     $("#failed-body .failed-leads-edit").each(function (i) {
                        //         $(this).attr("data-index", i);
                        //     });
                        // }
                        if (typeof currentFailedIndex !== 'undefined' && currentFailedIndex !== null) {
                            // Remove from array and DOM row
                            window.failedList.splice(currentFailedIndex, 1);
                            $("#failed-body tr").eq(currentFailedIndex).remove();

                            // Re-index remaining edit buttons (0-based)
                            $("#failed-body .failed-leads-edit").each(function (i) {
                                $(this).attr("data-index", i);
                            });

                            // If current pointer is now past the end, clamp it
                            if (currentFailedIndex >= window.failedList.length) {
                                currentFailedIndex = window.failedList.length - 1;
                            }
                        }

                        // Prepend to success table
                        const lead = res.lead;
                        const successOrder = ["asin", "name", "url", "supplier", "bsr", "category", "cost", "sell_price", "promo"];
                        
                        let tr = `<tr data-id="${lead.id}">`;
                        tr += `<td>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input row-check" data-id="${lead.id}">
                                </div>
                            </td>`;
                        successOrder.forEach(key => {
                            tr += `<td>${lead[key] ?? ''}</td>`;
                        });
                        tr += `<td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="" data-id="${lead.id}" class="btn btn-sm btn-light singleLeadDel">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                    <a href="" data-id="${lead.id}" class="btn btn-sm btn-light edit-lead">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" data-id="" href="#">Un-Bundle</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>`;
                        tr += "</tr>";

                        $("#successful-body").prepend(tr);

                        // Update counts
                        $('#successful-count').text(parseInt($('#successful-count').text()) + 1);
                        if(currentFailedIndex !== undefined){
                            $('#failed-count').text(parseInt($('#failed-count').text()) - 1);
                        }

                        toastr.success("Lead added to success table!");
                    } else {
                        toastr.error(res.message);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    toastr.error("Error saving lead");
                }
            });
        });

        // ✅ Remove row from SUCCESS or FAILED table
        $(document).on('click', '.remove-row', function(e) {
            e.preventDefault();

            const $row = $(this).closest('tr');
            const $tableBody = $row.closest('tbody');

            // Remove the row
            $row.remove();

            // Update counts dynamically
            if ($tableBody.attr('id') === 'failed-body') {
                $('#failed-count').text($tableBody.find('tr').length);
            }
        });

        /* =====================================================
        ✅ CHECKBOX HANDLING (Select All + Counter + Show Bar)
        ===================================================== */

        // 1️⃣ Handle Select All
        $(document).on("change", "#checkAllSuccess", function () {
            const checked = $(this).is(":checked");

            // check/uncheck all row checkboxes
            $("#successful-body .row-check").prop("checked", checked);

            updateSuccessSelectedCount();
        });


        // 2️⃣ Handle Single Row Checkbox Change
        $(document).on("change", "#successful-body .row-check", function () {

            // If any checkbox is unchecked → uncheck Select All
            if (!$(this).is(":checked")) {
                $("#checkAllSuccess").prop("checked", false);
            }

            // If all checkboxes are checked → check Select All
            const total = $("#successful-body .row-check").length;
            const selected = $("#successful-body .row-check:checked").length;

            if (selected === total) {
                $("#checkAllSuccess").prop("checked", true);
            }

            updateSuccessSelectedCount();
        });


        // 3️⃣ Function: Update Counter + Show/Hide Selected Bar
        function updateSuccessSelectedCount() {
            const selectedCount = $("#successful-body .row-check:checked").length;
            const $bar = $("#select-count-success-leads");

            $("#selectedCountSuccess").text(selectedCount);

            if (selectedCount > 0) {
                $bar.removeClass("d-none");
            } else {
                $bar.addClass("d-none");
            }
        }

        $(document).on('click', '.updatepublishdateSuccess', function (e) {
            e.preventDefault();

            const selectedIds = $('#successful-body .row-check:checked')
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

        // 🗑️ Bulk Delete Leads Success Table
        $(document).on('click', '.bulkDelBtnSuccess', function (e) {
            e.preventDefault();

            // Collect selected IDs
            const selectedIds = $('#successful-body .row-check:checked')
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

        // Discard All Failed
        $(document).on('click', '.discard-all-failed', function(e) {
            e.preventDefault();
            $('#failed-body').empty();
            $('#failed-count').text(0);
        });

        $(document).on('click', '#FailedTableDone', function(e) {
            e.preventDefault();
            location.reload();
        });

        $(document).on('click', '#successTableDone', function(e) {
            e.preventDefault();
            location.reload();
        });
    });

    $(document).ready(function () {

        // When select template card clicked
        $("#selectCard").on("click", function () {

            // highlight this card
            $("#selectCard").addClass("bg-soft-primary");
            $("#newCard").removeClass("bg-soft-primary");

            // show and hide sections
            $("#select-temp-section").removeClass("d-none");
            $("#new-temp-section").addClass("d-none");
        });

        // When create new template card clicked
        $("#newCard").on("click", function () {

            // highlight this card
            $("#newCard").addClass("bg-soft-primary");
            $("#selectCard").removeClass("bg-soft-primary");

            // show and hide sections
            $("#new-temp-section").removeClass("d-none");
            $("#select-temp-section").addClass("d-none");
        });

    });

</script>
@endsection