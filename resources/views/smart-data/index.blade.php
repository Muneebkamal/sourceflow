@extends('layouts.app')

@section('title', 'Smart Data')

@section('styles')
<style>
/* .text-truncate-multiline {
    width: 200px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
    cursor: pointer;
} */
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
                                    <!-- Button 1: Show Table -->
                                    <button id="show-table" class="btn btn-primary btn-sm">
                                        <i class="ti ti-table fs-4"></i>
                                    </button>

                                    <!-- Button 2: Show Cards -->
                                    <button id="show-cards" class="btn btn-light btn-sm">
                                        <i class="ti ti-menu-2 fs-4"></i>
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
                <div class="d-flex w-100">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                    </div>
                    <select id="searchType" class="form-select w-25" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-left: none;">
                        <option value="all">All</option>
                        <option value="name">Name</option>
                        <option value="asin">ASIN</option>
                        <option value="source_url">Source</option>
                    </select>
                </div>

                <!-- Filter + Reset Buttons -->
                <div class="d-flex gap-1">
                    <div class="btn-group drop-down">
                        <button type="button" class="btn btn-soft-primary dropdown-toggle drop-arrow-none"
                                data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-adjustments-horizontal"></i> Filters
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg p-0 shadow">
                            <div class="card border-0 mb-0">
                                <div class="card-body p-2">
                                    <label for="">Date Range</label>
                                    <div class="input-group position-relative">
                                        <span class="input-group-text"><i class="ti ti-calendar"></i></span>
                                        <input type="text" id="dateRangeFilter" class="form-control pe-3 rounded-end" placeholder="Date Range">
                                        <button type="button" id="clearDate" class="btn position-absolute end-0 top-50 translate-middle-y me-1 p-0 border-0 bg-transparent d-none">
                                            <i class="ti ti-x text-muted"></i>
                                        </button>
                                    </div>

                                    <div class="accordion" id="filterAccordion">
                                        <!-- Net Profit -->
                                        <div class="accordion-item border-0">
                                            <h2 class="accordion-header" id="headingNetProfit">
                                                <button class="accordion-button collapsed p-2 d-flex align-items-center" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseNetProfit">
                                                    <input class="form-check-input me-2" type="checkbox" id="chkNetProfit">
                                                    <label class="form-check-label flex-grow-1" for="chkNetProfit">Net Profit</label>
                                                </button>
                                            </h2>
                                            <div id="collapseNetProfit" class="accordion-collapse collapse">
                                                <div class="accordion-body py-2">
                                                    <div class="row g-2">
                                                        <div class="col"><input type="number" id="net_profit_min" class="form-control" placeholder="Min"></div>
                                                        <div class="col"><input type="number" id="net_profit_max" class="form-control" placeholder="Max"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Selling Price -->
                                        <div class="accordion-item border-0">
                                            <h2 class="accordion-header" id="headingSellingPrice">
                                                <button class="accordion-button collapsed p-2 d-flex align-items-center" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseSellingPrice">
                                                    <input class="form-check-input me-2" type="checkbox" id="chkSellingPrice">
                                                    <label class="form-check-label flex-grow-1" for="chkSellingPrice">Selling Price</label>
                                                </button>
                                            </h2>
                                            <div id="collapseSellingPrice" class="accordion-collapse collapse">
                                                <div class="accordion-body py-2">
                                                    <div class="row g-2">
                                                        <div class="col"><input type="number" id="sell_price_min" class="form-control" placeholder="Min"></div>
                                                        <div class="col"><input type="number" id="sell_price_max" class="form-control" placeholder="Max"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 90 Day Average -->
                                        <div class="accordion-item border-0">
                                            <h2 class="accordion-header" id="heading90DayAvg">
                                                <button class="accordion-button collapsed p-2 d-flex align-items-center" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse90DayAvg">
                                                    <input class="form-check-input me-2" type="checkbox" id="chk90DayAvg">
                                                    <label class="form-check-label flex-grow-1" for="chk90DayAvg">90 Day Average</label>
                                                </button>
                                            </h2>
                                            <div id="collapse90DayAvg" class="accordion-collapse collapse">
                                                <div class="accordion-body py-2">
                                                    <div class="row g-2">
                                                        <div class="col"><input type="number" id="avg90_min" class="form-control" placeholder="Min"></div>
                                                        <div class="col"><input type="number" id="avg90_max" class="form-control" placeholder="Max"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ROI -->
                                        <div class="accordion-item border-0">
                                            <h2 class="accordion-header" id="headingROI">
                                                <button class="accordion-button collapsed p-2 d-flex align-items-center" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseROI">
                                                    <input class="form-check-input me-2" type="checkbox" id="chkROI">
                                                    <label class="form-check-label flex-grow-1" for="chkROI">ROI %</label>
                                                </button>
                                            </h2>
                                            <div id="collapseROI" class="accordion-collapse collapse">
                                                <div class="accordion-body py-2">
                                                    <div class="row g-2">
                                                        <div class="col"><input type="number" id="roi_min" class="form-control" placeholder="Min"></div>
                                                        <div class="col"><input type="number" id="roi_max" class="form-control" placeholder="Max"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="form-check m-2">
                                        <input class="form-check-input" type="checkbox" id="excludeHazmat">
                                        <label class="form-check-label" for="excludeHazmat">Exclude Hazmat</label>
                                    </div>
                                    <div class="form-check m-2">
                                        <input class="form-check-input" type="checkbox" id="excludeDisputed">
                                        <label class="form-check-label" for="excludeDisputed">Exclude Disputed</label>
                                    </div>
                                    <hr>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-light me-1" id="btnCloseFilter">Close</button>
                                        <button type="button" class="btn btn-soft-primary" id="btnApplyFilter">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger" id="btnResetFilters">Reset</button>
                </div>

            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex align-items-end justify-content-md-end gap-1 flex-wrap mt-2 mt-md-0">
                <div id="total-results" class="form-control fw-bold d-inline-block" style="width:auto;">
                    Total Results: 0
                </div>


                <div class="btn-group drop-down">
                    <button type="button" class="btn btn-soft-primary dropdown-toggle drop-arrow-none" data-bs-auto-close="false" data-bs-toggle="dropdown" aria-expanded="true">
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
                                    <div class="d-flex align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-all" checked>
                                            <label class="form-check-label mb-0" for="col-all">All</label>
                                        </div>
                                    </div>
                                    
                                    @foreach ($tags as $tag)
                                        <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                            <div class="d-flex align-items-center">
                                                <input class="form-check-input me-2" type="checkbox" id="col-{{ $tag->id }}" checked>
                                                <label class="form-check-label mb-0" for="col-{{ $tag->id }}">{{ $tag->name }}</label>
                                            </div>
                                            <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y me-2">
                                                <button class="btn btn-sm btn-outline-primary me-1 editTagBtn"
                                                    data-id="{{ $tag->id }}"
                                                    data-name="{{ $tag->name }}"
                                                    data-color="{{ $tag->color }}">
                                                    <i class="ti ti-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger deleteTagBtn" data-id="{{ $tag->id }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex">
                                    <button class="btn btn-soft-primary me-2" data-bs-toggle="modal" data-bs-target="#tagModal">Create Tag</button>
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

            <div id="cards-section" class="d-none">
                <div class="cards-container">
                </div>
                <div id="card-pagination" class="pb-3 px-3"></div>
            </div>
        </div>
    </div>

    @include('modals.smart-data.tag-modal')
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
        $(document).ready(function () {
            function initTooltips() {
                $('[data-bs-tooltip="tooltip"]').each(function() {
                    new bootstrap.Tooltip(this);
                });
            }
            initTooltips();

            let table = $('#smart-data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get.smart.data') }}",
                    data: function (d) {
                        d.searchType = $('#searchType').val();
                        d.dateRange = $('#dateRangeFilter').val();
                        d.chkNetProfit = $('#chkNetProfit').is(':checked');
                        d.net_profit_min = $('#net_profit_min').val();
                        d.net_profit_max = $('#net_profit_max').val();
                        d.chkSellingPrice = $('#chkSellingPrice').is(':checked');
                        d.sell_price_min = $('#sell_price_min').val();
                        d.sell_price_max = $('#sell_price_max').val();
                        d.chk90DayAvg = $('#chk90DayAvg').is(':checked');
                        d.avg90_min = $('#avg90_min').val();
                        d.avg90_max = $('#avg90_max').val();
                        d.chkROI = $('#chkROI').is(':checked');
                        d.roi_min = $('#roi_min').val();
                        d.roi_max = $('#roi_max').val();
                        d.excludeHazmat = $('#excludeHazmat').is(':checked');
                        d.excludeDisputed = $('#excludeDisputed').is(':checked');
                    }
                },
                drawCallback: function (settings) {
                    let json = settings.json;
                    if (json && typeof json.recordsTotal !== 'undefined') {
                        $('#total-results').text('Total Results: ' + json.recordsTotal.toLocaleString());
                    }

                    // 🔁 Re-render cards dynamically
                    renderCards(json.data);
                    initTooltips();

                    renderCardPagination(settings);

                    // Re-init tooltips
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
                    { data: 'checkbox' },
                    { data: 'date' },
                    { data: 'image' },
                    { data: 'type' },
                    { data: 'tags' },
                    { data: 'updated_at' },
                    { data: 'name' },
                    { data: 'asin' },
                    { data: 'supplier' },
                    { data: 'cost' },
                    { data: 'sell_price' },
                    { data: 'net_profit' },
                    { data: 'roi' },
                    { data: 'bsr' },
                    { data: 'category' },
                    { data: 'promo' },
                    { data: 'coupon' },
                    { data: 'notes' },
                    { data: 'bsr_current' },
                    { data: 'actions' }
                ],
                columnDefs: [
                    { orderable: false, targets: [0, 2, 4, 19] }
                ]
            });

            function renderCards(data) {
                const $cardsSection = $('#cards-section .cards-container');
                $cardsSection.empty(); // clear previous cards

                if (!data || data.length === 0) {
                    $cardsSection.html('<div class="text-center py-4 text-muted">No records found.</div>');
                    return;
                }

                data.forEach(item => {
                    let card = `
                    <div class="card">
                        <div class="mb-3 card-body">
                            <div class="row g-3 align-items-start">
                                <!-- Left Column (Image / Info) -->
                                <div class="col-md-5">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="ti ti-trophy text-warning fs-3"></i>
                                                <i class="ti ti-user-plus text-warning fs-3"></i>
                                            </div>
                                            <button class="btn btn-sm btn-soft-primary d-flex align-items-center gap-1">
                                                <span>Add Type</span>
                                                <i class="ti ti-plus"></i>
                                            </button>
                                            <div class="vr mx-1"></div>
                                            <small><b>Last Updated:</b> <span>${item.updated_at ?? '-'}</span></small>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                        <img src=""
                                            alt="Product" class="img-fluid rounded" style="max-width:100px;">
                                        <div>
                                            <h5 class="fw-semibold mb-1">${item.name ?? '-'}</h5>
                                            <span class="badge bg-light text-primary border border-primary">${item.type ?? ''}</span>
                                            <a href="#" class="d-block text-decoration-none text-primary mt-1 small fw-semibold">Manage Tags</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Column -->
                                <div class="col-md-7">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div class="flex-fill w-100">
                                            <div><small class="text-muted me-1">ASIN:</small> <a href="#" class="text-primary">${item.asin ?? '-'}</a></div>
                                            <div><small class="text-muted me-1">Supplier:</small> <a href="#" class="text-primary">${item.supplier ?? '-'}</a></div>
                                            <div><small class="text-muted me-1">Category:</small> <span>${item.category ?? '-'}</span></div>
                                            <div><small class="text-muted me-1">Variation Details:</small> <span>${item.variation ?? '-'}</span></div>
                                        </div>

                                        <div class="flex-fill">
                                            <div class="row">
                                                <div class="col-4 mb-3"><small class="text-muted d-block">Cost</small><div class="fw-semibold">${item.cost ?? '0.00'}</div></div>
                                                <div class="col-4 mb-3"><small class="text-muted d-block">Sale Price</small><div class="fw-semibold text-success">${item.sell_price ?? '0.00'}</div></div>
                                                <div class="col-4 mb-3"><small class="text-muted d-block">Net Profit</small><div class="fw-semibold text-success">${item.net_profit ?? '0.00'}</div></div>
                                                <div class="col-4 mb-3"><small class="text-muted d-block">ROI</small><div class="fw-semibold text-success">${item.roi ?? '0'}%</div></div>
                                                <div class="col-4 mb-3"><small class="text-muted d-block">BSR</small><div class="fw-semibold">${item.bsr ?? '-'}</div></div>
                                                <div class="col-4 mb-3"><small class="text-muted d-block">90d BSR Avg.</small><div class="fw-semibold">${item.bsr_current ?? '-'}</div></div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-end gap-2">
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
                                            <button class="btn btn-light p-2"><i class="ti ti-external-link fs-5"></i></button>
                                            <button class="btn btn-soft-success p-2"><i class="ti ti-cash fs-5"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-4 border-end">
                                    <h6 class="fw-semibold mb-2">Sourcing Info</h6>
                                    <div class="d-flex justify-content-between"><small class="text-muted">Promo Code:</small><div>${item.promo ?? '-'}</div></div>
                                    <div class="d-flex justify-content-between mt-1"><small class="text-muted">Coupon Code:</small><div>${item.coupon ?? '-'}</div></div>
                                    <div class="d-flex justify-content-between mt-1"><small class="text-muted text-nowrap">Lead Note:</small><div>${item.notes ?? '-'}</div></div>
                                </div>

                                <div class="col-md-4 border-end">
                                    <h6 class="fw-semibold mb-2">Lead Info</h6>
                                    <div class="d-flex justify-content-between"><small class="text-muted">Publish Date:</small><div>${item.date ?? '-'}</div></div>
                                    <div class="d-flex justify-content-between mt-1"><small class="text-muted">Lead Source:</small><div>${item.source ?? '-'}</div></div>
                                    <div class="d-flex justify-content-between mt-1"><small class="text-muted">Brand:</small><div>${item.brand ?? '-'}</div></div>
                                </div>

                                <div class="col-md-4">
                                    <h6 class="fw-semibold mb-2">Order History</h6>
                                    <div class="text-muted small" style="filter: blur(2px); cursor: not-allowed;">[Order data here]</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                    $cardsSection.append(card);
                });
            }

            function renderCardPagination(settings) {
                const api = new $.fn.dataTable.Api(settings);
                const pageInfo = api.page.info();
                const $pagination = $('#card-pagination');
                $pagination.empty();

                if (pageInfo.pages <= 1) return; // no pagination if single page

                const maxPagesToShow = 3;
                let startPage = Math.max(0, pageInfo.page - Math.floor(maxPagesToShow / 2));
                let endPage = startPage + maxPagesToShow;

                if (endPage > pageInfo.pages) {
                    endPage = pageInfo.pages;
                    startPage = Math.max(0, endPage - maxPagesToShow);
                }

                let html = `
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <!-- Left side: Info -->
                        <div class="text-muted small mb-2 mb-md-0">
                            Showing ${pageInfo.start + 1} to ${pageInfo.end} of ${pageInfo.recordsTotal.toLocaleString()} entries
                        </div>

                        <!-- Right side: Pagination -->
                        <div class="pagination-container">
                            <ul class="pagination mb-0">
                                <li class="paginate_button page-item previous ${pageInfo.page === 0 ? 'disabled' : ''}">
                                    <a href="#" class="page-link" data-page="${pageInfo.page - 1}">Previous</a>
                                </li>
                `;

                // Show first page and ellipsis if needed
                if (startPage > 0) {
                    html += `
                        <li class="paginate_button page-item">
                            <a href="#" class="page-link" data-page="0">1</a>
                        </li>
                    `;
                    if (startPage > 1) {
                        html += `
                            <li class="paginate_button page-item disabled">
                                <a class="page-link" tabindex="-1">…</a>
                            </li>
                        `;
                    }
                }

                // Main visible page numbers
                for (let i = startPage; i < endPage; i++) {
                    html += `
                        <li class="paginate_button page-item ${pageInfo.page === i ? 'active' : ''}">
                            <a href="#" class="page-link" data-page="${i}">${i + 1}</a>
                        </li>
                    `;
                }

                // Show ellipsis and last page if needed
                if (endPage < pageInfo.pages - 1) {
                    html += `
                        <li class="paginate_button page-item disabled">
                            <a class="page-link" tabindex="-1">…</a>
                        </li>
                    `;
                }

                if (endPage < pageInfo.pages) {
                    html += `
                        <li class="paginate_button page-item">
                            <a href="#" class="page-link" data-page="${pageInfo.pages - 1}">${pageInfo.pages}</a>
                        </li>
                    `;
                }

                // Next Button
                html += `
                                <li class="paginate_button page-item next ${pageInfo.page + 1 >= pageInfo.pages ? 'disabled' : ''}">
                                    <a href="#" class="page-link" data-page="${pageInfo.page + 1}">Next</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                `;

                $pagination.html(html);

                // Handle click events
                $pagination.find('a.page-link').off('click').on('click', function (e) {
                    e.preventDefault();
                    const page = $(this).data('page');
                    if (page >= 0 && page < pageInfo.pages) {
                        table.page(page).draw('page');
                    }
                });
            }


            // 🔍 Auto search on typing
            $('#searchInput').on('keyup', function () {
                let searchValue = $(this).val();
                let searchType = $('#searchType').val();
                table.ajax.url("{{ route('get.smart.data') }}?searchValue=" + searchValue + "&searchType=" + searchType).load();
            });

            // 🔄 Change search type
            $('#searchType').on('change', function () {
                table.ajax.reload();
            });

            // 📅 Date Range Picker logic
            $('#dateRangeFilter').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                $('#clearDate').removeClass('d-none');
            });

            $('#dateRangeFilter').on('cancel.daterangepicker', function () {
                $(this).val('');
                $('#clearDate').addClass('d-none');
            });

            $('#clearDate').on('click', function () {
                $('#dateRangeFilter').val('');
                $(this).addClass('d-none');
            });

            // 🧭 Apply Filter
            $('#btnApplyFilter').on('click', function () {
                table.ajax.reload();

                // ✅ Close dropdown properly
                let dropdownMenu = $(this).closest('.dropdown-menu');
                let dropdownToggle = dropdownMenu.prev('.dropdown-toggle');
                let dropdownInstance = bootstrap.Dropdown.getInstance(dropdownToggle[0]);
                if (dropdownInstance) dropdownInstance.hide();
            });

            // ❌ Close Filter
            $('#btnCloseFilter').on('click', function () {
                let dropdownMenu = $(this).closest('.dropdown-menu');
                let dropdownToggle = dropdownMenu.prev('.dropdown-toggle');
                let dropdownInstance = bootstrap.Dropdown.getInstance(dropdownToggle[0]);
                if (dropdownInstance) dropdownInstance.hide();
            });

            // 🔄 Reset Filters
            $('#btnResetFilters').on('click', function () {
                var $btn = $(this);
            
                // Add spinner and disable button
                $btn.prop('disabled', true);
                $btn.html('<span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span>Reset');

                $('#searchInput').val('');
                $('#searchType').val('all');
                $('#filterAccordion input[type="number"]').val('');
                $('#filterAccordion input[type="checkbox"]').prop('checked', false);
                $('#excludeHazmat').prop('checked', false);
                $('#excludeDisputed').prop('checked', false);
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
        
        // for tags store and update delete
        $(document).ready(function() {
            let editMode = false;
            let currentTagId = null;
            let selectedColor = '';

            // 🎨 Handle color selection (save lowercase color name)
            $('#tagModal .btn-soft-success, #tagModal .btn-soft-info, #tagModal .btn-soft-primary, #tagModal .btn-soft-secondary, #tagModal .btn-soft-danger, #tagModal .btn-soft-warning, #tagModal .btn-soft-dark, #tagModal .btn-soft-light')
            .on('click', function(e) {
                e.preventDefault();
                $('#tagModal .btn').removeClass('active');
                $(this).addClass('active');
                selectedColor = $(this).text().trim().toLowerCase(); // 👈 lowercase color name
            });

            // ✳️ Open modal for create
            $(document).on('click', '#addTagBtn', function() {
                editMode = false;
                currentTagId = null;
                selectedColor = '';
                $('#TagsForm')[0].reset();
                $('#tagModalLabel').text('Create Tag');
                $('#TagsForm button[type="submit"]').text('Create');
                $('#tagModal').modal('show');
            });

            // ✏️ Open modal for edit
            $(document).on('click', '.editTagBtn', function() {
                editMode = true;
                currentTagId = $(this).data('id');
                $('#leadListSourceName').val($(this).data('name'));
                selectedColor = $(this).data('color');

                // Highlight selected color
                $('#tagModal .btn').removeClass('active');
                $('#tagModal .btn').each(function() {
                    if ($(this).text().trim().toLowerCase() === selectedColor) {
                        $(this).addClass('active');
                    }
                });

                $('#tagModalLabel').text('Edit Tag');
                $('#TagsForm button[type="submit"]').text('Update');
                $('#tagModal').modal('show');
            });

            // 💾 Submit form (create or update)
            $('#TagsForm').on('submit', function(e) {
                e.preventDefault();
                const name = $('#leadListSourceName').val();

                if (!selectedColor) {
                    toastr.warning('Please select a color');
                    return;
                }

                $.ajax({
                    url: editMode
                        ? `/tags/${currentTagId}/update`
                        : `/tags/store`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: name,
                        color: selectedColor,
                    },
                    success: function(response) {
                        $('#tagModal').modal('hide');
                        toastr.success(response.message || (editMode ? 'Tag updated successfully' : 'Tag created successfully'));
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Something went wrong');
                    }
                });
            });

            // 🗑️ Delete tag with SweetAlert
            $(document).on('click', '.deleteTagBtn', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This tag will be moved to trash (soft delete).",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/tags/${id}/delete`,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message || 'Tag deleted successfully',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                setTimeout(() => location.reload(), 1500);
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Failed to delete tag.'
                                });
                            }
                        });
                    }
                });
            });
        });

        // tags all check or uncheck
        $(document).ready(function() {
            // When "All" is checked or unchecked
            $('#col-all').on('change', function() {
                const isChecked = $(this).is(':checked');
                $('.column-item input.form-check-input').not('#col-all').prop('checked', isChecked);
            });

            // When any individual tag checkbox is changed
            $(document).on('change', '.column-item input.form-check-input:not(#col-all)', function() {
                const allChecked = $('.column-item input.form-check-input:not(#col-all)').length === 
                                $('.column-item input.form-check-input:not(#col-all):checked').length;
                $('#col-all').prop('checked', allChecked);
            });
        });
    </script>

@endsection