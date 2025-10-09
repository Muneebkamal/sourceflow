@extends('layouts.app')

@section('title', 'Smart Data')

@section('styles')
<style>
    
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Smart Data</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                    <form action="javascript:void(0);">
                        <div class="row g-2 mb-0 align-items-center">
                            <div class="col-auto">
                                <div class="border p-1 rounded d-flex align-items-center gap-1">
                                    <!-- Button 1: Show Cards -->
                                    <button id="show-cards" class="btn btn-light btn-sm">
                                        <i class="ti ti-menu-2 fs-4"></i>
                                    </button>

                                    <!-- Button 2: Show Table -->
                                    <button id="show-table" class="btn btn-primary btn-sm">
                                        <i class="ti ti-table fs-4"></i>
                                    </button>
                                </div>

                            </div>
                            <div class="col-auto">
                                <a href="javascript: void(0);" class="btn btn-light">
                                    <i class="ti ti-download"></i>  Export
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row align-items-end mb-3">
        <div class="col-md-6">
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Search..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                    </div>
                    <select class="form-select w-25" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: none;">
                        <option>All</option>
                        <option value="name">Name</option>
                        <option value="asin">ASIN</option>
                        <option value="source_url">Source</option>
                    </select>
                </div>

                <!-- Filter + Reset Buttons -->
                <div class="d-flex gap-1">
                    <div class="btn-group drop-down">
                        <button type="button" class="btn btn-soft-primary dropdown-toggle drop-arrow-none" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                            <i class="ti ti-adjustments-horizontal"></i> Filters
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg p-0 shadow">
                            <div class="card border-0 mb-0">
                                <div class="card-body p-2">
                                    <label for="">Date Range</label>
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

                                    <div class="accordion" id="filterAccordion">

                                        <!-- Net Profit -->
                                        <div class="accordion-item border-0">
                                            <h2 class="accordion-header" id="headingNetProfit">
                                            <button class="accordion-button collapsed p-2 d-flex align-items-center" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseNetProfit" aria-expanded="false"
                                                aria-controls="collapseNetProfit">
                                                <input class="form-check-input me-2" type="checkbox" id="chkNetProfit">
                                                <label class="form-check-label flex-grow-1" for="chkNetProfit">Net Profit</label>
                                            </button>
                                            </h2>
                                            <div id="collapseNetProfit" class="accordion-collapse collapse"
                                            aria-labelledby="headingNetProfit" data-bs-parent="#filterAccordion">
                                            <div class="accordion-body py-2">
                                                <div class="row g-2">
                                                <div class="col">
                                                    <input type="number" class="form-control" placeholder="Min">
                                                </div>
                                                <div class="col">
                                                    <input type="number" class="form-control" placeholder="Max">
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <!-- Selling Price -->
                                        <div class="accordion-item border-0">
                                            <h2 class="accordion-header" id="headingSellingPrice">
                                            <button class="accordion-button collapsed p-2 d-flex align-items-center" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseSellingPrice" aria-expanded="false"
                                                aria-controls="collapseSellingPrice">
                                                <input class="form-check-input me-2" type="checkbox" id="chkSellingPrice">
                                                <label class="form-check-label flex-grow-1" for="chkSellingPrice">Selling Price</label>
                                            </button>
                                            </h2>
                                            <div id="collapseSellingPrice" class="accordion-collapse collapse"
                                            aria-labelledby="headingSellingPrice" data-bs-parent="#filterAccordion">
                                            <div class="accordion-body py-2">
                                                <div class="row g-2">
                                                <div class="col">
                                                    <input type="number" class="form-control" placeholder="Min">
                                                </div>
                                                <div class="col">
                                                    <input type="number" class="form-control" placeholder="Max">
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <!-- 90 Day Average -->
                                        <div class="accordion-item border-0">
                                            <h2 class="accordion-header" id="headingNinetyDay">
                                            <button class="accordion-button collapsed p-2 d-flex align-items-center" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseNinetyDay" aria-expanded="false"
                                                aria-controls="collapseNinetyDay">
                                                <input class="form-check-input me-2" type="checkbox" id="chkNinetyDay">
                                                <label class="form-check-label flex-grow-1" for="chkNinetyDay">90 Day Average</label>
                                            </button>
                                            </h2>
                                            <div id="collapseNinetyDay" class="accordion-collapse collapse"
                                            aria-labelledby="headingNinetyDay" data-bs-parent="#filterAccordion">
                                            <div class="accordion-body py-2">
                                                <div class="row g-2">
                                                <div class="col">
                                                    <input type="number" class="form-control" placeholder="Min">
                                                </div>
                                                <div class="col">
                                                    <input type="number" class="form-control" placeholder="Max">
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <!-- ROI % -->
                                        <div class="accordion-item border-0">
                                            <h2 class="accordion-header" id="headingROI">
                                            <button class="accordion-button collapsed p-2 d-flex align-items-center" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseROI" aria-expanded="false"
                                                aria-controls="collapseROI">
                                                <input class="form-check-input me-2" type="checkbox" id="chkROI">
                                                <label class="form-check-label flex-grow-1" for="chkROI">ROI %</label>
                                            </button>
                                            </h2>
                                            <div id="collapseROI" class="accordion-collapse collapse"
                                            aria-labelledby="headingROI" data-bs-parent="#filterAccordion">
                                            <div class="accordion-body py-2">
                                                <div class="row g-2">
                                                <div class="col">
                                                    <input type="number" class="form-control" placeholder="Min">
                                                </div>
                                                <div class="col">
                                                    <input type="number" class="form-control" placeholder="Max">
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                    </div>
                                    <hr>
                                    <div>
                                        <div class="form-check m-2">
                                        <input class="form-check-input" type="checkbox" id="excludeHazmat">
                                        <label class="form-check-label" for="excludeHazmat">Exclude Hazmat</label>
                                        </div>
                                        <div class="form-check m-2">
                                        <input class="form-check-input" type="checkbox" id="excludeDisputed">
                                        <label class="form-check-label" for="excludeDisputed">Exclude Disputed</label>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-light me-1">Close</button>
                                        <button class="btn btn-soft-primary">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-soft-danger">Reset</button>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex align-items-end justify-content-md-end gap-1 flex-wrap mt-2 mt-md-0">
                <div class="form-control fw-bold d-inline-block" style="width:auto;">
                    Total Results: 24,255
                </div>


                <div class="btn-group drop-down">
                    <button type="button" class="btn btn-soft-primary dropdown-toggle drop-arrow-none" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                        Tags <i class="ti ti-chevron-down align-middle ms-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg p-0 shadow">
                        <div class="card border-0 mb-0">
                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-semibold">Tags</h5>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="tagsSwitch">
                                    <label class="form-check-label" for="tagsSwitch"></label>
                                </div>
                            </div>

                            <div class="card-body p-2">
                                <div class="column-list">

                                    <!-- All -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-all">
                                            <label class="form-check-label mb-0" for="col-all">All</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Added to Buy List -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-335">
                                            <label class="form-check-label mb-0" for="col-335">Added to Buy List</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- ANN -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-348">
                                            <label class="form-check-label mb-0" for="col-348">ANN</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- AY ADDED -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-343">
                                            <label class="form-check-label mb-0" for="col-343">AY ADDED</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Duplicate -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-336">
                                            <label class="form-check-label mb-0" for="col-336">Duplicate</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Followup -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-346">
                                            <label class="form-check-label mb-0" for="col-346">Followup</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Gated -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-339">
                                            <label class="form-check-label mb-0" for="col-339">Gated</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Glass -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-341">
                                            <label class="form-check-label mb-0" for="col-341">Glass</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Good Kamal -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-344">
                                            <label class="form-check-label mb-0" for="col-344">Good Kamal</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Hazmat -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-337">
                                            <label class="form-check-label mb-0" for="col-337">Hazmat</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Heavy Item -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-342">
                                            <label class="form-check-label mb-0" for="col-342">Heavy Item</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- IP -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-338">
                                            <label class="form-check-label mb-0" for="col-338">IP</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Later -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-333">
                                            <label class="form-check-label mb-0" for="col-333">Later</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Low Sales - Many Sellers -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-340">
                                            <label class="form-check-label mb-0" for="col-340">Low Sales - Many Sellers</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- No Good -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-331">
                                            <label class="form-check-label mb-0" for="col-331">No Good</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Not Approved And not Allow -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-334">
                                            <label class="form-check-label mb-0" for="col-334">Not Approved And not Allow</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Not Match -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-347">
                                            <label class="form-check-label mb-0" for="col-347">Not Match</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- OOS -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-332">
                                            <label class="form-check-label mb-0" for="col-332">OOS</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Shoes -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-345">
                                            <label class="form-check-label mb-0" for="col-345">Shoes</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                            <button class="btn btn-sm btn-outline-primary me-1"><i class="ti ti-pencil"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex">
                                    <button class="btn btn-soft-primary me-2">Create Tag</button>
                                    <button class="btn btn-light me-1">Close</button>
                                    <button class="btn btn-primary">Apply</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-group drop-down">
                    <button type="button" class="btn btn-soft-primary dropdown-toggle drop-arrow-none" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                        Lists <i class="ti ti-chevron-down align-middle ms-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-xl p-0 shadow">
                        <div class="card border-0 mb-0">
                            <div class="card-header bg-light py-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="mb-0 fw-semibold">Team Lists</h5>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="mb-0 fw-semibold">Lists Group</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="column-list">

                                            <!-- Select All -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="all-team">
                                                <label class="form-check-label fw-bold" for="all-team">All</label>
                                            </div>

                                            <!-- All Team Checkboxes -->
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1301" value="1301"><label class="form-check-label" for="team-id-1301">One Time Beauty List - July 13th 2022</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1303" value="1303"><label class="form-check-label" for="team-id-1303">Ailyn</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1304" value="1304"><label class="form-check-label" for="team-id-1304">Mixed List 4 - Week of 7_4-7_8</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1305" value="1305"><label class="form-check-label" for="team-id-1305">One Time List September 24th 2022</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1306" value="1306"><label class="form-check-label" for="team-id-1306">Mixed List 4 - Oct 2022</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1307" value="1307"><label class="form-check-label" for="team-id-1307">Mixed List 4 - Nov 2022</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1308" value="1308"><label class="form-check-label" for="team-id-1308">Mixed list 4 - nov 21-25 2022</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1309" value="1309"><label class="form-check-label" for="team-id-1309">Mixed List 4 - Dec 2022</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1310" value="1310"><label class="form-check-label" for="team-id-1310">Beauty Restock - Dec 2022</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1311" value="1311"><label class="form-check-label" for="team-id-1311">Home Essentials - Jan 2023</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1312" value="1312"><label class="form-check-label" for="team-id-1312">Spring Cleaning - Feb 2023</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1313" value="1313"><label class="form-check-label" for="team-id-1313">Office Supplies - Mar 2023</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1314" value="1314"><label class="form-check-label" for="team-id-1314">Kitchen Essentials - Apr 2023</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1315" value="1315"><label class="form-check-label" for="team-id-1315">Gadget Picks - May 2023</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1316" value="1316"><label class="form-check-label" for="team-id-1316">One Time Summer List - June 2023</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1317" value="1317"><label class="form-check-label" for="team-id-1317">Mixed List 4 - July 2023</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1318" value="1318"><label class="form-check-label" for="team-id-1318">Fall Ready List - Aug 2023</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1319" value="1319"><label class="form-check-label" for="team-id-1319">Beauty Restock - Sept 2023</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1320" value="1320"><label class="form-check-label" for="team-id-1320">Mixed List 4 - Oct 2023</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1321" value="1321"><label class="form-check-label" for="team-id-1321">Holiday Prep List - Nov 2023</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1322" value="1322"><label class="form-check-label" for="team-id-1322">Mixed List 4 - Dec 2023</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1323" value="1323"><label class="form-check-label" for="team-id-1323">Winter Essentials - Jan 2024</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1324" value="1324"><label class="form-check-label" for="team-id-1324">Beauty Restock - Feb 2024</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1325" value="1325"><label class="form-check-label" for="team-id-1325">Spring Cleaning - Mar 2024</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1326" value="1326"><label class="form-check-label" for="team-id-1326">Mixed List 4 - Apr 2024</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1327" value="1327"><label class="form-check-label" for="team-id-1327">Summer Picks - May 2024</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1328" value="1328"><label class="form-check-label" for="team-id-1328">Mixed List 4 - June 2024</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1329" value="1329"><label class="form-check-label" for="team-id-1329">Beauty List - July 2024</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1330" value="1330"><label class="form-check-label" for="team-id-1330">Mixed List 4 - Aug 2024</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1331" value="1331"><label class="form-check-label" for="team-id-1331">Fall List - Sept 2024</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1332" value="1332"><label class="form-check-label" for="team-id-1332">Mixed List 4 - Oct 2024</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1333" value="1333"><label class="form-check-label" for="team-id-1333">Holiday List - Nov 2024</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="team-id-1334" value="1334"><label class="form-check-label" for="team-id-1334">Winter List - Dec 2024</label></div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="column-list">

                                            <!-- Select All -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="all-groups">
                                                <label class="form-check-label fw-bold" for="all-groups">All</label>
                                            </div>

                                            <!-- lists group Checkboxes -->
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="group-id-1301"><label class="form-check-label" for="group-id-1301">OA Cheddar List #6</label></div>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="group-id-1303"><label class="form-check-label" for="group-id-1303">OA Feta List #1</label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-light me-1">Close</button>
                                    <button class="btn btn-primary">Apply</button>
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
                                    <!-- Publish Date -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-publish_time" checked>
                                            <label class="form-check-label ms-2" for="col-publish_time">Publish Date</label>
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

                                    <!-- Type -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-type" checked>
                                            <label class="form-check-label ms-2" for="col-type">Type</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Tags -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-tags" checked>
                                            <label class="form-check-label ms-2" for="col-tags">Tags</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Last Updated -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-latest_updated_at" checked>
                                            <label class="form-check-label ms-2" for="col-latest_updated_at">Last Updated</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Product Title -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-name" checked>
                                            <label class="form-check-label ms-2" for="col-name">Product Title</label>
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

                                    <!-- Supplier -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-supplier" checked>
                                            <label class="form-check-label ms-2" for="col-supplier">Supplier</label>
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

                                    <!-- Cost -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-cost" checked>
                                            <label class="form-check-label ms-2" for="col-cost">Cost</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Sale Price -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-selling_price" checked>
                                            <label class="form-check-label ms-2" for="col-selling_price">Sale Price</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Net Profit -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-net_profit_input" checked>
                                            <label class="form-check-label ms-2" for="col-net_profit_input">Net Profit</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- ROI -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-roi_input" checked>
                                            <label class="form-check-label ms-2" for="col-roi_input">ROI</label>
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

                                    <!-- Category -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-category" checked>
                                            <label class="form-check-label ms-2" for="col-category">Category</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Promo -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-promo" checked>
                                            <label class="form-check-label ms-2" for="col-promo">Promo</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Coupon Code -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-coupon_code" checked>
                                            <label class="form-check-label ms-2" for="col-coupon_code">Coupon Code</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Lead Note -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-list_item_note" checked>
                                            <label class="form-check-label ms-2" for="col-list_item_note">Lead Note</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- New Offers -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-new_offers_count">
                                            <label class="form-check-label ms-2" for="col-new_offers_count">New Offers</label>
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

                                    <!-- BSR Current -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-bsr_current" checked>
                                            <label class="form-check-label ms-2" for="col-bsr_current">BSR Current</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Lead Source -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-list_group_id">
                                            <label class="form-check-label ms-2" for="col-list_group_id">Lead Source</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Variations -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-variations">
                                            <label class="form-check-label ms-2" for="col-variations">Variations</label>
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
                        <table id="smart-data-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th>
                                        <input type="checkbox" class="form-check-input">
                                    </th>
                                    <th>Publish Date</th>
                                    <th>Image</th>
                                    <th>Type</th>
                                    <th>Tags</th>
                                    <th>Last Updated</th>
                                    <th>Product Title</th>
                                    <th>Asin</th>
                                    <th>Supplier</th>
                                    <th>Cost</th>
                                    <th>Sale Price</th>
                                    <th>Net Profit</th>
                                    <th>ROI</th>
                                    <th>BSR 90D Avg</th>
                                    <th>Category</th>
                                    <th>Promo</th>
                                    <th>Coupon Code</th>
                                    <th>Lead Note</th>
                                    <th>BSR Current</th>
                                    <th class="sticky-col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Row 1 -->
                                <tr class="small">
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>2025/09/20</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" alt=""></td>
                                    <td>Electronics</td>
                                    <td><span class="badge bg-primary">Hot</span> <span class="badge bg-success">New</span></td>
                                    <td>2025-09-25</td>
                                    <td>Wireless Headphones</td>
                                    <td>B09XYZ123</td>
                                    <td>Supplier A</td>
                                    <td>$25</td>
                                    <td>$50</td>
                                    <td>$20</td>
                                    <td>80%</td>
                                    <td>12,345</td>
                                    <td>Headphones</td>
                                    <td>Yes</td>
                                    <td>CODE123</td>
                                    <td>Fast Selling</td>
                                    <td>11,500</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Dollar Button -->
                                            <button class="btn btn-sm btn-success">
                                            <i class="ti ti-currency-dollar"></i>
                                            </button>

                                            <!-- Open in New Button -->
                                            <button class="btn btn-sm btn-light">
                                            <i class="ti ti-external-link"></i>
                                            </button>

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-copy me-2"></i> Copy to Clipboard
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-edit me-2"></i> Edit Item Details
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item text-danger" href="#">
                                                    <i class="ti ti-trash me-2"></i> Delete Lead
                                                </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr class="small">
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>2025/09/18</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" alt=""></td>
                                    <td>Home</td>
                                    <td><span class="badge bg-info">Trending</span></td>
                                    <td>2025-09-22</td>
                                    <td>Vacuum Cleaner</td>
                                    <td>B07ABC456</td>
                                    <td>Supplier B</td>
                                    <td>$80</td>
                                    <td>$150</td>
                                    <td>$50</td>
                                    <td>62%</td>
                                    <td>8,765</td>
                                    <td>Appliances</td>
                                    <td>No</td>
                                    <td>-</td>
                                    <td>Popular Choice</td>
                                    <td>9,000</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Dollar Button -->
                                            <button class="btn btn-sm btn-success">
                                            <i class="ti ti-currency-dollar"></i>
                                            </button>

                                            <!-- Open in New Button -->
                                            <button class="btn btn-sm btn-light">
                                            <i class="ti ti-external-link"></i>
                                            </button>

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-copy me-2"></i> Copy to Clipboard
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-edit me-2"></i> Edit Item Details
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item text-danger" href="#">
                                                    <i class="ti ti-trash me-2"></i> Delete Lead
                                                </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 3 -->
                                <tr class="small">
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>2025/09/10</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" alt=""></td>
                                    <td>Sports</td>
                                    <td><span class="badge bg-warning">Seasonal</span></td>
                                    <td>2025-09-15</td>
                                    <td>Football Shoes</td>
                                    <td>B08LMN789</td>
                                    <td>Supplier C</td>
                                    <td>$40</td>
                                    <td>$90</td>
                                    <td>$30</td>
                                    <td>75%</td>
                                    <td>6,540</td>
                                    <td>Sports Gear</td>
                                    <td>Yes</td>
                                    <td>KICK10</td>
                                    <td>Best for players</td>
                                    <td>6,300</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Dollar Button -->
                                            <button class="btn btn-sm btn-success">
                                            <i class="ti ti-currency-dollar"></i>
                                            </button>

                                            <!-- Open in New Button -->
                                            <button class="btn btn-sm btn-light">
                                            <i class="ti ti-external-link"></i>
                                            </button>

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-copy me-2"></i> Copy to Clipboard
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-edit me-2"></i> Edit Item Details
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item text-danger" href="#">
                                                    <i class="ti ti-trash me-2"></i> Delete Lead
                                                </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 4 -->
                                <tr class="small">
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>2025/09/08</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" alt=""></td>
                                    <td>Books</td>
                                    <td><span class="badge bg-danger">Bestseller</span></td>
                                    <td>2025-09-12</td>
                                    <td>Self-Help Guide</td>
                                    <td>B012XYZ456</td>
                                    <td>Supplier D</td>
                                    <td>$10</td>
                                    <td>$30</td>
                                    <td>$12</td>
                                    <td>120%</td>
                                    <td>3,210</td>
                                    <td>Books</td>
                                    <td>No</td>
                                    <td>-</td>
                                    <td>Good Reviews</td>
                                    <td>3,000</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Dollar Button -->
                                            <button class="btn btn-sm btn-success">
                                            <i class="ti ti-currency-dollar"></i>
                                            </button>

                                            <!-- Open in New Button -->
                                            <button class="btn btn-sm btn-light">
                                            <i class="ti ti-external-link"></i>
                                            </button>

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-copy me-2"></i> Copy to Clipboard
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-edit me-2"></i> Edit Item Details
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item text-danger" href="#">
                                                    <i class="ti ti-trash me-2"></i> Delete Lead
                                                </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 5 -->
                                <tr class="small">
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>2025/09/05</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" alt=""></td>
                                    <td>Fashion</td>
                                    <td><span class="badge bg-dark">Exclusive</span></td>
                                    <td>2025-09-08</td>
                                    <td>Leather Jacket</td>
                                    <td>B01QWE852</td>
                                    <td>Supplier E</td>
                                    <td>$100</td>
                                    <td>$250</td>
                                    <td>$90</td>
                                    <td>90%</td>
                                    <td>5,000</td>
                                    <td>Clothing</td>
                                    <td>Yes</td>
                                    <td>STYLE20</td>
                                    <td>Limited Stock</td>
                                    <td>4,800</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Dollar Button -->
                                            <button class="btn btn-sm btn-success">
                                            <i class="ti ti-currency-dollar"></i>
                                            </button>

                                            <!-- Open in New Button -->
                                            <button class="btn btn-sm btn-light">
                                            <i class="ti ti-external-link"></i>
                                            </button>

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-copy me-2"></i> Copy to Clipboard
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-edit me-2"></i> Edit Item Details
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item text-danger" href="#">
                                                    <i class="ti ti-trash me-2"></i> Delete Lead
                                                </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 6 -->
                                <tr class="small">
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>2025/09/20</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" alt=""></td>
                                    <td>Electronics</td>
                                    <td><span class="badge bg-primary">Hot</span> <span class="badge bg-success">New</span></td>
                                    <td>2025-09-25</td>
                                    <td>Wireless Headphones</td>
                                    <td>B09XYZ123</td>
                                    <td>Supplier A</td>
                                    <td>$25</td>
                                    <td>$50</td>
                                    <td>$20</td>
                                    <td>80%</td>
                                    <td>12,345</td>
                                    <td>Headphones</td>
                                    <td>Yes</td>
                                    <td>CODE123</td>
                                    <td>Fast Selling</td>
                                    <td>11,500</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Dollar Button -->
                                            <button class="btn btn-sm btn-success">
                                            <i class="ti ti-currency-dollar"></i>
                                            </button>

                                            <!-- Open in New Button -->
                                            <button class="btn btn-sm btn-light">
                                            <i class="ti ti-external-link"></i>
                                            </button>

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-copy me-2"></i> Copy to Clipboard
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-edit me-2"></i> Edit Item Details
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item text-danger" href="#">
                                                    <i class="ti ti-trash me-2"></i> Delete Lead
                                                </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 7 -->
                                <tr class="small">
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>2025/09/18</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" alt=""></td>
                                    <td>Home</td>
                                    <td><span class="badge bg-info">Trending</span></td>
                                    <td>2025-09-22</td>
                                    <td>Vacuum Cleaner</td>
                                    <td>B07ABC456</td>
                                    <td>Supplier B</td>
                                    <td>$80</td>
                                    <td>$150</td>
                                    <td>$50</td>
                                    <td>62%</td>
                                    <td>8,765</td>
                                    <td>Appliances</td>
                                    <td>No</td>
                                    <td>-</td>
                                    <td>Popular Choice</td>
                                    <td>9,000</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Dollar Button -->
                                            <button class="btn btn-sm btn-success">
                                            <i class="ti ti-currency-dollar"></i>
                                            </button>

                                            <!-- Open in New Button -->
                                            <button class="btn btn-sm btn-light">
                                            <i class="ti ti-external-link"></i>
                                            </button>

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-copy me-2"></i> Copy to Clipboard
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-edit me-2"></i> Edit Item Details
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item text-danger" href="#">
                                                    <i class="ti ti-trash me-2"></i> Delete Lead
                                                </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 8 -->
                                <tr class="small">
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>2025/09/10</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" alt=""></td>
                                    <td>Sports</td>
                                    <td><span class="badge bg-warning">Seasonal</span></td>
                                    <td>2025-09-15</td>
                                    <td>Football Shoes</td>
                                    <td>B08LMN789</td>
                                    <td>Supplier C</td>
                                    <td>$40</td>
                                    <td>$90</td>
                                    <td>$30</td>
                                    <td>75%</td>
                                    <td>6,540</td>
                                    <td>Sports Gear</td>
                                    <td>Yes</td>
                                    <td>KICK10</td>
                                    <td>Best for players</td>
                                    <td>6,300</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Dollar Button -->
                                            <button class="btn btn-sm btn-success">
                                            <i class="ti ti-currency-dollar"></i>
                                            </button>

                                            <!-- Open in New Button -->
                                            <button class="btn btn-sm btn-light">
                                            <i class="ti ti-external-link"></i>
                                            </button>

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-copy me-2"></i> Copy to Clipboard
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-edit me-2"></i> Edit Item Details
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item text-danger" href="#">
                                                    <i class="ti ti-trash me-2"></i> Delete Lead
                                                </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 9 -->
                                <tr class="small">
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>2025/09/08</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" alt=""></td>
                                    <td>Books</td>
                                    <td><span class="badge bg-danger">Bestseller</span></td>
                                    <td>2025-09-12</td>
                                    <td>Self-Help Guide</td>
                                    <td>B012XYZ456</td>
                                    <td>Supplier D</td>
                                    <td>$10</td>
                                    <td>$30</td>
                                    <td>$12</td>
                                    <td>120%</td>
                                    <td>3,210</td>
                                    <td>Books</td>
                                    <td>No</td>
                                    <td>-</td>
                                    <td>Good Reviews</td>
                                    <td>3,000</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Dollar Button -->
                                            <button class="btn btn-sm btn-success">
                                            <i class="ti ti-currency-dollar"></i>
                                            </button>

                                            <!-- Open in New Button -->
                                            <button class="btn btn-sm btn-light">
                                            <i class="ti ti-external-link"></i>
                                            </button>

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-copy me-2"></i> Copy to Clipboard
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-edit me-2"></i> Edit Item Details
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item text-danger" href="#">
                                                    <i class="ti ti-trash me-2"></i> Delete Lead
                                                </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 10 -->
                                <tr class="small">
                                    <td>
                                        <input type="checkbox" class="form-check-input">
                                    </td>
                                    <td>2025/09/05</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" alt=""></td>
                                    <td>Fashion</td>
                                    <td><span class="badge bg-dark">Exclusive</span></td>
                                    <td>2025-09-08</td>
                                    <td>Leather Jacket</td>
                                    <td>B01QWE852</td>
                                    <td>Supplier E</td>
                                    <td>$100</td>
                                    <td>$250</td>
                                    <td>$90</td>
                                    <td>90%</td>
                                    <td>5,000</td>
                                    <td>Clothing</td>
                                    <td>Yes</td>
                                    <td>STYLE20</td>
                                    <td>Limited Stock</td>
                                    <td>4,800</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Dollar Button -->
                                            <button class="btn btn-sm btn-success">
                                            <i class="ti ti-currency-dollar"></i>
                                            </button>

                                            <!-- Open in New Button -->
                                            <button class="btn btn-sm btn-light">
                                            <i class="ti ti-external-link"></i>
                                            </button>

                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-copy me-2"></i> Copy to Clipboard
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="ti ti-edit me-2"></i> Edit Item Details
                                                </a>
                                                </li>
                                                <li>
                                                <a class="dropdown-item text-danger" href="#">
                                                    <i class="ti ti-trash me-2"></i> Delete Lead
                                                </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="cards-section" class="card d-none">
                <div class="card-body">
                    <div class="row g-3 align-items-start">
                        <!-- Left Column (Image / Info) -->
                        <div class="col-md-5">
                            <!-- Top Action Row -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <!-- Yellow Icons -->
                                    <div class="d-flex align-items-center gap-2">
                                    <i class="ti ti-trophy text-warning fs-3"></i>
                                    <i class="ti ti-user-plus text-warning fs-3"></i>
                                    </div>

                                    <!-- Add Type Button -->
                                    <button class="btn btn-sm btn-soft-primary d-flex align-items-center gap-1">
                                    <span>Add Type</span>
                                    <i class="ti ti-plus"></i>
                                    </button>

                                    <!-- Divider -->
                                    <div class="vr mx-1"></div>

                                    <!-- Last Updated -->
                                    <small>
                                    <b>Last Updated:</b> <span>10/03/25</span>
                                    </small>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked>
                                </div>
                            <img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" 
                                alt="Product" class="img-fluid rounded" style="max-width:100px;">
                            <div>
                                <h5 class="fw-semibold mb-1">Zymöl Factory Original Spray Detailer™</h5>
                                <span class="badge bg-light text-primary border border-primary">No Good</span>
                                <a href="#" class="d-block text-decoration-none text-primary mt-1 small fw-semibold">Manage Tags</a>
                            </div>
                            </div>
                        </div>
                        
                        <!-- Right Column (Details / Info) -->
                        <div class="col-md-7">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                
                                <!-- Left Info -->
                                <div class="flex-fill w-100">
                                    <!-- ASIN -->
                                    <div>
                                        <small class="text-muted me-1">ASIN:</small>
                                        <a href="#" class="text-primary text-decoration-none">B06XWC9249</a>
                                        <i class="ti ti-copy text-secondary ms-1" role="button" title="Copy"></i>
                                    </div>

                                    <!-- Supplier -->
                                    <div>
                                        <small class="text-muted me-1">Supplier:</small>
                                        <a href="#" class="text-primary text-decoration-none">zymol</a>
                                    </div>

                                    <!-- Category -->
                                    <div>
                                        <small class="text-muted me-1">Category:</small>
                                        <span>Automotive</span>
                                    </div>

                                    <!-- Variation -->
                                    <div>
                                        <small class="text-muted me-1">Variation Details:</small>
                                        <span>SIZE: 24 Ounce (Pack of 1)</span>
                                    </div>
                                </div>

                                <!-- Middle Pricing Info -->
                                <div class="flex-fill">
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <small class="text-muted d-block">Cost</small>
                                            <div class="fw-semibold">$11.00</div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <small class="text-muted d-block">Sale Price</small>
                                            <div class="fw-semibold text-success">
                                                $31.95 <span class="text-decoration-line-through text-muted fs-6">$29.29</span>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <small class="text-muted d-block">Net Profit</small>
                                            <div class="fw-semibold text-success">
                                                $10.77 <span class="text-decoration-line-through text-muted fs-6">$9.20</span>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <small class="text-muted d-block">ROI</small>
                                            <div class="fw-semibold text-success">
                                                98.00% <span class="text-decoration-line-through text-muted fs-6">84.00%</span>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <small class="text-muted d-block">BSR</small>
                                            <div class="fw-semibold">
                                                702,342 <span class="text-decoration-line-through text-muted fs-6">647,655</span>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <small class="text-muted d-block">90d BSR Avg.</small>
                                            <div class="fw-semibold">
                                                493,988 <span class="text-decoration-line-through text-muted fs-6">385,326</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Buttons -->
                                <div class="d-flex flex-column align-items-end gap-2">
                                    <!-- Dropdown Menu Button -->
                                    <div class="dropdown">
                                        <button class="btn btn-light p-2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy to Clipboard</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit Item Details</a></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete Lead</a></li>
                                        </ul>
                                    </div>

                                    <!-- Open Links Button -->
                                    <button class="btn btn-light p-2">
                                        <i class="ti ti-external-link fs-5"></i>
                                    </button>
                                    
                                    <!-- Add to Buy List Button -->
                                    <button class="btn btn-soft-success p-2">
                                        <i class="ti ti-cash fs-5"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Bottom Section -->
                    <div class="row">
                        <div class="col-md-4 border-end">
                            <h6 class="fw-semibold mb-2">Sourcing Info</h6>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Promo Code:</small>
                                <div>50%off code: <strong>FIRSTORDER</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Coupon Code:</small>
                                <div>-</div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-nowrap text-muted">Lead Note:</small>
                                <div class="text-end">Added 20 in cart est shipping $62 / $14.10 each</div>
                            </div>
                        </div>

                        <div class="col-md-4 border-end">
                            <h6 class="fw-semibold mb-2">Lead Info</h6>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Publish Date:</small>
                                <div>04/23/24</div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Lead Source:</small>
                                <div>OAMANAGE</div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">UPC / GTIN:</small>
                                <div>724943672239</div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Brand:</small>
                                <div>ZYMÖL</div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">New Offers:</small>
                                <div>2</div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted"># of Reviews:</small>
                                <div>46</div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Ratings:</small>
                                <div>4.8</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <h6 class="fw-semibold mb-2">Order History</h6>
                            <div class="text-muted small" style="filter: blur(2px); cursor: not-allowed;">[Order data here]</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#show-cards').click(function() {
                $('#table-section').addClass('d-none');  
                $('#cards-section').removeClass('d-none'); 

                // Button active state
                $('#show-cards').removeClass('btn-light').addClass('btn-primary');
                $('#show-table').removeClass('btn-primary').addClass('btn-light');
            });

            $('#show-table').click(function() {
                $('#cards-section').addClass('d-none');  
                $('#table-section').removeClass('d-none'); 

                // Button active state
                $('#show-table').removeClass('btn-light').addClass('btn-primary');
                $('#show-cards').removeClass('btn-primary').addClass('btn-light');
            });
        });
    </script>

    {{-- for filter accrodian checkboxes --}}
    <script>
        $(document).ready(function() {
            // When accordion opens -> check the corresponding checkbox
            $('#filterAccordion .accordion-collapse').on('shown.bs.collapse', function() {
                const checkbox = $(this).prev().find('.form-check-input');
                checkbox.prop('checked', true);
            });

            // When accordion closes -> uncheck the checkbox
            $('#filterAccordion .accordion-collapse').on('hidden.bs.collapse', function() {
                const checkbox = $(this).prev().find('.form-check-input');
                checkbox.prop('checked', false);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#smart-data-table').DataTable({
                scrollY: '40vh',
                // fixedHeader: true,
                searching: false,
                lengthChange: false,
                ordering: false,
                scrollX: true,
                scrollCollapse: true,
                paging: true,
            });
        });
    </script>

@endsection