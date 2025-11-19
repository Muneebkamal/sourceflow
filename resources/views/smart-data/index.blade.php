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
                                    <button id="show-table" class="btn btn-light btn-sm">
                                        <i class="ti ti-table fs-4"></i>
                                    </button>

                                    <!-- Button 2: Show Cards -->
                                    <button id="show-cards" class="btn btn-primary btn-sm">
                                        <i class="ti ti-menu-2 fs-4"></i>
                                    </button>
                                </div>

                            </div>
                            <div class="col-auto">
                                <a href="javascript: void(0);" class="btn btn-light export-smart-data">
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
        <div class="col-md-7">
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex">
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

                <div id="sorting-for-card" class="d-flex gap-1">
                    <select id="card-sort-by" class="form-select">
                        <option value="date">Publish Date</option>
                        <option value="updated_at">Last Updated</option>
                        <option value="name">Product Title</option>
                        <option value="asin">ASIN</option>
                        <option value="supplier">Supplier</option>
                        <option value="brand">Brand</option>
                        <option value="cost">Cost</option>
                        <option value="sell_price">Sale Price</option>
                        <option value="net_profit">Net Profit</option>
                        <option value="roi">ROI</option>
                        <option value="bsr">BSR 90D Avg</option>
                        <option value="category">Category</option>
                        <option value="promo">Promo</option>
                        <option value="coupon">Coupon Code</option>
                        <option value="notes">Lead Note</option>
                        <option value="bsr_current">BSR Current</option>
                    </select>

                    <select id="card-sort-order" class="form-select">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>


            </div>
        </div>

        <div class="col-md-5">
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
                                    <button class="btn btn-light me-1 close-tag-dropdown">Close</button>
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


                <div class="btn-group customize-btn">
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
                        <li><a class="dropdown-item bulkTags" href="#">Add Tags</a></li>
                    </ul>
                </div>
                <span class="fw-bold ms-3">Selected: <span id="selectedCount">0</span></span>
            </div>
            <div id="table-section" class="card d-none">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="smart-data-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th>
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                    </th>
                                    <th>Publish Date</th>
                                    <th>Image</th>
                                    <th>Type</th>
                                    <th>Tags</th>
                                    <th>Last Updated</th>
                                    <th>Product Title</th>
                                    <th>Asin</th>
                                    <th>Supplier</th>
                                    <th>Brand</th>
                                    <th>Cost</th>
                                    <th>Sale Price</th>
                                    <th>Net Profit</th>
                                    <th>ROI</th>
                                    <th>BSR 90D Avg</th>
                                    <th>Category</th>
                                    <th>Promo</th>
                                    <th>Coupon Code</th>
                                    <th>Lead Note</th>
                                    <th>New Offers</th>
                                    <th>Rating</th>
                                    <th>Reviews</th>
                                    <th>BSR Current</th>
                                    <th>Lead Source</th>
                                    <th>Variations</th>
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
            
            <div id="cards-section" class="">
                <div class="cards-container">
                </div>
                {{-- <div id="card-pagination" class="pb-3 px-3"></div> --}}
            </div>
            <div class="d-flex justify-content-between my-2" id="table-info-bottom"></div>
        </div>
    </div>

    @include('modals.smart-data.tag-modal')
    @include('modals.smart-data.smart-data-buylist-modal')
    @include('modals.smart-data.bulk-tags-to-item')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#show-cards').click(function() {
                $('#table-section').addClass('d-none');  
                $('#cards-section').removeClass('d-none');
                $('.customize-btn').addClass('d-none');
                $('.actions-buttons').addClass('flex-column-reverse');
                $('#sorting-for-card').removeClass('d-none');

                // Button active state
                $('#show-cards').removeClass('btn-light').addClass('btn-primary');
                $('#show-table').removeClass('btn-primary').addClass('btn-light');
            });

            $('#show-table').click(function() {
                $('#cards-section').addClass('d-none');  
                $('#table-section').removeClass('d-none'); 
                $('.customize-btn').removeClass('d-none');
                 $('.actions-buttons').removeClass('flex-column-reverse');
                 $('#sorting-for-card').addClass('d-none');

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
                stateSave: true,
                colReorder: true,
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
                // drawCallback: function (settings) {
                //     let json = settings.json;
                //     if (json && typeof json.recordsTotal !== 'undefined') {
                //         $('#total-results').text('Total Results: ' + json.recordsTotal.toLocaleString());
                //     }

                //     // 🔁 Re-render cards dynamically
                //     renderCards(json.data);
                //     initTooltips();

                //     renderCardPagination(settings);

                //     // Re-init tooltips
                //     const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                //     tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
                // },
                scrollY: '50vh',
                scrollX: true,
                paging: true,
                searching: false,
                ordering: true,
                lengthChange: true,
                columns: [
                    { data: 'checkbox', orderable: false, searchable: false },
                    { data: 'date' },
                    { data: 'image' },
                    { data: 'type' },
                    { data: 'tags' },
                    { data: 'updated_at' },
                    { data: 'name' },
                    { data: 'asin' },
                    { data: 'supplier' },
                    { data: null, title: 'Brand', defaultContent: '-', orderable: false },
                    { data: 'cost' },
                    { data: 'sell_price' },
                    { data: 'net_profit' },
                    { data: 'roi' },
                    { data: 'bsr' },
                    { data: 'category' },
                    { data: 'promo' },
                    { data: 'coupon' },
                    { data: 'notes' },
                    { data: null, title: 'New Offers', defaultContent: '-', orderable: false },
                    { data: null, title: 'Rating', defaultContent: '-', orderable: false },
                    { data: null, title: 'Reviews', defaultContent: '-', orderable: false },
                    { data: 'bsr_current' },
                    { data: null, title: 'Lead Source', defaultContent: '-', orderable: false },
                    { data: null, title: 'Variations', defaultContent: '-', orderable: false },
                    { data: 'actions', orderable: false, searchable: false}
                ],
                columnDefs: [
                    { orderable: false, targets: [0, 2, 4, 19] }
                ],
                createdRow: function (row) {
                    $(row).addClass('text-nowrap small');
                },
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
                drawCallback: function(settings) {
                    let json = settings.json;
                    if (json && typeof json.recordsTotal !== 'undefined') {
                        $('#total-results').text('Total Results: ' + json.recordsTotal.toLocaleString());
                    }

                    // 🔁 Re-render cards dynamically
                    renderCards(json.data);
                    initTooltips();

                    renderCardPagination(settings);
                    // Re-init tooltips
                    $('[data-bs-toggle="tooltip"]').each(function() { new bootstrap.Tooltip(this); });
                }
                // initComplete: function () {
                //     generateColumnList();
                // }
            });

            // ✅ Dynamic Column List Builder
            function generateColumnList() {
                const columnList = $('.column-list-draggable');
                columnList.empty();

                table.columns().every(function (index) {
                    // ❌ Skip first & last column
                    if (index === 0 || index === table.columns().count() - 1) return;

                    const col = table.column(index);
                    const title = $(col.header()).text().trim() || 'Column ' + index;
                    const checked = col.visible() ? 'checked' : '';

                    columnList.append(`
                        <div class="d-flex justify-content-between align-items-center draggable-item" 
                            data-column-index="${index}">
                            <div>
                                <input class="form-check-input col-toggle" type="checkbox" ${checked} id="col-${index}">
                                <label class="form-check-label ms-2" for="col-${index}">${title}</label>
                            </div>
                            <i class="ti ti-grip-vertical grip-icon"></i>
                        </div>
                    `);
                });

                enableColumnListFeatures();
            }

            function enableColumnListFeatures() {
                // ✅ Show/Hide columns
                $(document).off('change', '.col-toggle').on('change', '.col-toggle', function () {
                    const index = $(this).closest('.draggable-item').data('column-index');
                    const visible = $(this).is(':checked');
                    table.column(index).visible(visible);
                });

                // ✅ Drag & Drop reorder (sync with DataTables)
                $('.column-list-draggable').sortable({
                    handle: '.grip-icon',
                    update: function () {
                        const newOrder = $('.column-list-draggable .draggable-item').map(function () {
                            return $(this).data('column-index');
                        }).get();

                        // Keep first & last fixed
                        const fullOrder = [0, ...newOrder, table.columns().count() - 1];
                        table.colReorder.order(fullOrder, true);
                    }
                });
            }

            // for card layout
            function renderCards(data) {
                const $cardsSection = $('#cards-section .cards-container');
                $cardsSection.empty(); // clear previous cards

                if (!data || data.length === 0) {
                    $cardsSection.html('<div class="text-center py-4 text-muted">No records found.</div>');
                    return;
                }

                // ✅ Select All checkbox (added only once)
                $cardsSection.append(`
                    <div class="form-check mb-3 ms-2">
                        <input id="SelectAll-cards" class="form-check-input" type="checkbox">
                        <label for="SelectAll-cards"> Select All</label>
                    </div>
                `);

                data.forEach(item => {
                    let card = `
                    <div class="card">
                        <div class="mb-3 card-body">
                            <div class="row g-3 align-items-start">
                                <!-- Left Column (Image / Info) -->
                                <div class="col-md-5">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="lead-type-icons-card-${item.id}">
                                                ${item.type ?? ''}
                                            </div>
                                            <div class="vr mx-1"></div>
                                            <small><b>Last Updated:</b> <span>${item.updated_at ?? '-'}</span></small>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input smart-data-checkbox"
                                            type="checkbox"
                                            data-id="${item.id}">
                                        </div>
                                        <div>
                                            <h5 class="fw-semibold mb-2">${item.name ?? '-'}</h5>
                                            <span class="">${item.tags ?? ''}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Right Column -->
                                <div class="col-md-7">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div class="flex-fill w-100">
                                            <div><span class="me-1">ASIN:</span> <a href="#" class="text-primary asin-value">${item.asin ?? '-'}</a>
                                                <i class="ti ti-copy text-secondary ms-2 asin-copy" style="cursor:pointer;"></i>
                                            </div>
                                            <div><span class="me-1">Supplier:</span> <a href="#" class="text-primary">${item.supplier ?? '-'}</a></div>
                                            <div><span class="me-1">Category:</span> <span>${item.category ?? '-'}</span></div>
                                            <div><span class="me-1">Variation Details:</span> <span>${item.variation ?? '-'}</span></div>
                                        </div>

                                        <div class="flex-fill w-100">
                                            <div class="row">
                                                <div class="col-4 mb-3"><span class="text-muted d-block">Cost</span><div class="fw-semibold">${item.cost ?? '0.00'}</div></div>
                                                <div class="col-4 mb-3"><span class="text-muted d-block">Sale Price</span><div class="fw-semibold text-success">${item.sell_price ?? '0.00'}</div></div>
                                                <div class="col-4 mb-3"><span class="text-muted d-block">Net Profit</span><div class="fw-semibold text-success">${item.net_profit ?? '0.00'}</div></div>
                                                <div class="col-4 mb-3"><span class="text-muted d-block">ROI</span><div class="fw-semibold text-success">${item.roi ?? '0'}%</div></div>
                                                <div class="col-4 mb-3"><span class="text-muted d-block">BSR</span><div class="fw-semibold">${item.bsr ?? '-'}</div></div>
                                                <div class="col-4 mb-3"><span class="text-muted d-block">90d BSR Avg.</span><div class="fw-semibold">${item.bsr_current ?? '-'}</div></div>
                                            </div>
                                        </div>

                                        ${item.actions ?? ''}
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row" style="border: 1px solid #e7e9eb; padding: 15px; border-radius: 5px;">
                                <div class="col-md-4 border-end">
                                    <div class="mb-2 text-center border-bottom">
                                        <h6 class="fw-semibold mb-2">Sourcing Info</h6>
                                    </div>
                                    <div class="d-flex justify-content-between"><small class="text-muted">Promo Code:</small><div>${item.promo ?? '-'}</div></div>
                                    <div class="d-flex justify-content-between mt-1"><small class="text-muted">Coupon Code:</small><div>${item.coupon ?? '-'}</div></div>
                                    <div class="d-flex justify-content-between mt-1"><small class="text-muted text-nowrap">Lead Note:</small><div>${item.notes ?? '-'}</div></div>
                                </div>

                                <div class="col-md-4 border-end">
                                    <div class="mb-2 text-center border-bottom">
                                        <h6 class="fw-semibold mb-2">Lead Info</h6>
                                    </div>
                                    <div class="d-flex justify-content-between"><small class="text-muted">Publish Date:</small><div>${item.date ?? '-'}</div></div>
                                    <div class="d-flex justify-content-between mt-1"><small class="text-muted">Lead Source:</small><div>${item.source ?? '-'}</div></div>
                                    <div class="d-flex justify-content-between mt-1"><small class="text-muted">Brand:</small><div>${item.brand ?? '-'}</div></div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-2 text-center border-bottom">
                                        <h6 class="fw-semibold mb-2">Order History</h6>
                                    </div>
                                    <div class="text-muted small" style="filter: blur(2px); cursor: not-allowed;">[Order data here]</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                    $cardsSection.append(card);
                });
            }

            $(document).on('click', '.asin-copy', function () {
                let asin = $(this).prev('a').text().trim(); // get ASIN from previous <a>

                if (!asin || asin === '-') {
                    toastr.error("No ASIN available to copy");
                    return;
                }

                navigator.clipboard.writeText(asin).then(() => {
                    toastr.success("ASIN copied to clipboard!");
                });

                // Optional visual feedback on icon
                $(this).removeClass('text-secondary').addClass('text-success');
                setTimeout(() => {
                    $(this).removeClass('text-success').addClass('text-secondary');
                }, 800);
            });

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

            // ---------------------------------------------
            // ✅ 1. Mapping DataTable column index → card sort keys
            // ---------------------------------------------
            const tableToCardSortMap = {
                1: 'date',
                5: 'updated_at',
                6: 'name',
                7: 'asin',
                8: 'supplier',
                9: 'brand',
                10: 'cost',
                11: 'sell_price',
                12: 'net_profit',
                13: 'roi',
                14: 'bsr',
                15: 'category',
                16: 'promo',
                17: 'coupon',
                18: 'notes',
                22: 'bsr_current',
            };

            // ---------------------------------------------
            // ✅ 2. MANUAL Sorting via select dropdowns
            // ---------------------------------------------
            $('#card-sort-by, #card-sort-order').on('change', function () {
                sortCards();
            });

            // ---------------------------------------------
            // ✅ 3. Main Card Sorting Function
            // ---------------------------------------------
            function sortCards() {
                let sortBy = $('#card-sort-by').val();
                let sortOrder = $('#card-sort-order').val();

                let json = table.ajax.json();
                if (!json || !json.data) return;

                let data = [...json.data]; // clone array

                // Helper: Normalize values for comparison
                function getValue(item) {
                    let val = item[sortBy];

                    // numeric
                    if (!isNaN(val) && val !== null && val !== '') {
                        return parseFloat(val);
                    }

                    // date
                    if (sortBy === 'date' || sortBy === 'updated_at') {
                        return new Date(val);
                    }

                    // string
                    return (val ?? '').toString().toLowerCase();
                }

                // Sorting
                data.sort((a, b) => {
                    let x = getValue(a);
                    let y = getValue(b);

                    if (x < y) return sortOrder === 'asc' ? -1 : 1;
                    if (x > y) return sortOrder === 'asc' ? 1 : -1;
                    return 0;
                });

                // Re-render cards
                renderCards(data);
            }

            // ---------------------------------------------
            // ✅ 4. AUTO-SYNC Card Sorting when Table is Sorted
            // ---------------------------------------------
            table.on('order.dt', function () {
                let order = table.order();
                let columnIndex = order[0][0];   // Which column was sorted
                let direction = order[0][1];     // asc / desc

                // Find matching card-sorting field
                let sortBy = tableToCardSortMap[columnIndex];
                if (!sortBy) return;  // ignore non-sortable card fields

                // Update dropdowns to match table sort
                $('#card-sort-by').val(sortBy);
                $('#card-sort-order').val(direction);

                // Sort cards now
                sortCards();
            });

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

            // ✅ Default "All" filter on page load
            $(document).ready(function () {
                let allStart = moment("1970-01-01");
                let allEnd = moment();

                // ✅ Set input value as All range
                $('#dateRangeFilter').val(allStart.format('MM/DD/YYYY') + ' - ' + allEnd.format('MM/DD/YYYY'));

                // ✅ Show clear button
                $('#clearDate').removeClass('d-none');

                // ✅ Force daterangepicker to understand that All is selected
                let picker = $('#dateRangeFilter').data('daterangepicker');
                if (picker) {
                    picker.setStartDate(allStart);
                    picker.setEndDate(allEnd);
                }
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
                // let dropdownMenu = $(this).closest('.dropdown-menu');
                // let dropdownToggle = dropdownMenu.prev('.dropdown-toggle');
                // let dropdownInstance = bootstrap.Dropdown.getInstance(dropdownToggle[0]);
                // if (dropdownInstance) dropdownInstance.hide();
                $(this).closest(".dropdown-menu").removeClass("show");
            });

            $('.close-tag-dropdown').on('click', function () {
                $(this).closest(".dropdown-menu").removeClass("show");
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

        $(document).on('click', '.export-smart-data', function() {
            toastr.info('Report is generating...');

            $.ajax({
                url: "{{ route('smartdata.export') }}",
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
        
        // Fix checked states whenever dropdown menu is shown
        $(document).on('shown.bs.dropdown', '.dropdown', function () {

            const dropdown = $(this);

            dropdown.find('input[type="radio"], input[type="checkbox"]').each(function () {

                // If HTML attribute 'checked' exists → force the property
                if ($(this).is('[checked]')) {
                    $(this).prop('checked', true);
                }

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

        // $(document).ready(function () {
        //     // Select all
        //     $(document).on('change', '#selectAll', function () {
        //         const checked = $(this).is(':checked');
        //         $('#smart-data-table tbody .smart-data-checkbox').prop('checked', checked);
        //         updateSelectedCount();
        //     });

        //     // Single checkbox change
        //     $(document).on('change', '#smart-data-table tbody .smart-data-checkbox', function () {
        //         const allChecked =
        //             $('#smart-data-table tbody .smart-data-checkbox').length ===
        //             $('#smart-data-table tbody .smart-data-checkbox:checked').length;

        //         $('#selectAll').prop('checked', allChecked);
        //         updateSelectedCount();
        //     });

        //     // Update counter and bar
        //     function updateSelectedCount() {
        //         const count = $('#smart-data-table tbody .smart-data-checkbox:checked').length;
        //         $('#selectedCount').text(count);
        //         if (count > 0) {
        //             $('#select-count-section').removeClass('d-none');
        //         } else {
        //             $('#select-count-section').addClass('d-none');
        //         }
        //     }

        //     // Reset on table redraw
        //     $('#smart-data-table').on('draw.dt', function () {
        //         $('#selectAll').prop('checked', false);
        //         updateSelectedCount();
        //     });
        // });
        $(document).ready(function () {

            /* -----------------------------
            ✅ SINGLE CHECKBOX CHANGE
            ------------------------------*/
            $(document).on("change", ".smart-data-checkbox", function () {
                let id = $(this).data("id");
                let checked = $(this).is(":checked");

                // ✅ Sync table + card checkbox for same lead ID
                $(`.smart-data-checkbox[data-id="${id}"]`).prop("checked", checked);

                updateSelectAllStatus();
                updateSelectedCount();
            });

            /* -----------------------------
            ✅ SELECT ALL (TABLE HEADER)
            ------------------------------*/
            $(document).on("change", "#selectAll", function () {
                let checked = $(this).is(":checked");

                // ✅ Sync both select-all checkboxes
                $("#selectAll, #SelectAll-cards").prop("checked", checked);

                // ✅ Check/uncheck all table + card checkboxes
                $(".smart-data-checkbox").prop("checked", checked);

                updateSelectedCount();
            });

            /* -----------------------------
            ✅ SELECT ALL (CARDS SECTION)
            ------------------------------*/
            $(document).on("change", "#SelectAll-cards", function () {
                let checked = $(this).is(":checked");

                // ✅ Sync both select-all checkboxes
                $("#selectAll, #SelectAll-cards").prop("checked", checked);

                // ✅ Check/uncheck all table + card checkboxes
                $(".smart-data-checkbox").prop("checked", checked);

                updateSelectedCount();
            });

            /* -----------------------------
            ✅ UNIQUE COUNT UPDATE
            ------------------------------*/
            function updateSelectedCount() {
                let selectedIds = new Set();

                $(".smart-data-checkbox:checked").each(function () {
                    selectedIds.add($(this).data("id"));
                });

                let count = selectedIds.size;

                $("#selectedCount").text(count);

                if (count > 0) {
                    $("#select-count-section").removeClass("d-none");
                } else {
                    $("#select-count-section").addClass("d-none");
                }
            }

            /* -----------------------------
            ✅ UPDATE SELECT ALL STATUS
            (Handles auto-check select all)
            ------------------------------*/
            function updateSelectAllStatus() {
                let ids = new Set();
                let selectedIds = new Set();

                $(".smart-data-checkbox").each(function () {
                    ids.add($(this).data("id"));
                });

                $(".smart-data-checkbox:checked").each(function () {
                    selectedIds.add($(this).data("id"));
                });

                let allChecked = ids.size > 0 && ids.size === selectedIds.size;

                $("#selectAll, #SelectAll-cards").prop("checked", allChecked);
            }

            /* -----------------------------
            ✅ DATATABLE RE-DRAW SYNC
            ------------------------------*/
            $("#smart-data-table").on("draw.dt", function () {
                // Re-sync all checked IDs after table reload
                let selectedIds = new Set();

                $(".smart-data-checkbox:checked").each(function () {
                    selectedIds.add($(this).data("id"));
                });

                selectedIds.forEach(id => {
                    $(`.smart-data-checkbox[data-id="${id}"]`).prop("checked", true);
                });

                updateSelectAllStatus();
                updateSelectedCount();
            });

        });

        $(document).on('click', '.copyNameBtn', function(e) {
            e.preventDefault();

            const name = $(this).data('name');

            // Copy to clipboard
            navigator.clipboard.writeText(name).then(() => {
                toastr.success('Copied: ' + name);
            }).catch(() => {
                toastr.error('Failed to copy!');
            });
        });

        $(document).on('click', '.movetobuylist, .edit-lead-modal', function() {
            const leadId = $(this).data('id');
            const isBuylist = $(this).hasClass('movetobuylist');

            $.ajax({
                url: '/smart-data/lead/' + leadId,
                type: 'GET',
                success: function(response) {
                    if(response.success) {
                        const lead = response.lead;

                        // Clear previous selections
                        $('#multiBuyList').val([]).trigger('change');

                        // Select related buy lists if any
                        if (response.buylist_ids && response.buylist_ids.length > 0) {
                            $('#multiBuyList').val(response.buylist_ids).trigger('change');
                        }

                        $('#asin-label').text(lead.asin);
                        $('#open-links-btn').data('url', lead.url);

                        // Fill modal fields
                        $('#addtoBuylistModalLabel').text(lead.name || 'Product Title');
                        $('#addtoBuylistModal img').attr('src', lead.image_url || 'https://app.sourceflow.io/storage/images/no-image-thumbnail.png');
                        $('#est_selling_price').val(lead.sell_price);

                        // leads edit
                        $('#e_l_name').val(lead.name);
                        $('#e_lead_id').val(lead.id);
                        $('#e_l_asin').val(lead.asin);
                        $('#e_l_category').val(lead.category);
                        $('#e_l_unitsPurchased').val(lead.quantity);
                        $('#e_l_costPerUnit').val(lead.cost);
                        $('#e_l_sellingPrice').val(lead.sell_price);
                        $('#e_l_netProfit').val(lead.net_profit);
                        $('#e_l_roi').val(lead.roi);
                        $('#e_l_bsr_ninety').val(lead.bsr);
                        $('#e_l_supplier').val(lead.supplier);
                        $('#e_l_source_url').val(lead.url);
                        $('#e_l_promo').val(lead.promo);
                        $('#e_l_coupon_code').val(lead.coupon);
                        $('#e_l_product_note').val(lead.notes);

                        // add to buylist 
                        $('#name').val(lead.name);
                        $('#lead_id').val(lead.id);
                        $('#asin').val(lead.asin);
                        $('#category').val(lead.category);
                        $('#unitsPurchased').val(lead.quantity);
                        $('#costPerUnit').val(lead.cost);
                        $('#sellingPrice').val(lead.sell_price);
                        $('#netProfit').val(lead.net_profit);
                        $('#roi').val(lead.roi);
                        $('#bsr_ninety').val(lead.bsr);
                        // $('#msku').val(lead.msku);
                        // $('#listPrice').val(lead.list_price);
                        // $('#minPrice').val(lead.min);
                        // $('#maxPrice').val(lead.max);
                        $('#supplier').val(lead.supplier);
                        $('#source_url').val(lead.url);
                        // $('#brand').val(lead.brand);
                        // $('#variation').val(lead.variation_details);
                        $('#promo').val(lead.promo);
                        $('#coupon_code').val(lead.coupon);
                        $('#product_note').val(lead.notes);
                        // $('#buyerNote').val(lead.buyer_note);

                        // Optional: smart data tab
                        $('#smart-date').text(lead.date || '-');
                        $('#smart-supplier').text(lead.supplier || '-');
                        $('#smart-buy-cost').text('$' + (lead.cost || '0'));
                        $('#smart-net-cost').text('$' + (lead.net_profit || '0'));
                        $('#smart-roi').text(lead.roi || '0%');
                        $('#smart-bsr').text(lead.bsr || '-');
                        $('#supplier-link').attr('href', lead.url || '#');

                        // Activate correct tab
                        if(isBuylist){
                            // Activate "Add to Buy List" tab
                            new bootstrap.Tab($('#add-buylist-tab-tab')[0]).show();
                        } else {
                            // Activate "Edit Lead" tab
                            new bootstrap.Tab($('#edit-lead-tab-tab')[0]).show();
                        }

                        populateLeadTypeDropdown(lead); // Set the inputs
                        // Render icons
                        renderLeadIcons('#edit-lead-tab', lead.type, lead.is_replenishable, lead.is_hazmat, lead.is_caution);

                        // Show modal
                        $('#addtoBuylistModal').modal('show');
                    } else {
                        toastr.error('Failed to fetch lead data.');
                    }
                },
                error: function() {
                    toastr.error('Something went wrong!');
                }
            });
        });

        // Open the URL in a new tab when the button is clicked
        $('#open-links-btn').on('click', function() {
            const url = $(this).data('url');
            if(url) {
                window.open(url, '_blank');
            } else {
                toastr.error('No URL available for this lead.');
            }
        });

        $(document).on('click', '#asin-label + .asin-copy-icon', function() {
            // Get the ASIN text
            const asin = $('#asin-label').text().trim();

            if(asin && asin !== '-') {
                // Use the Clipboard API
                navigator.clipboard.writeText(asin).then(() => {
                    // Optional: show a small success message
                    toastr.success('ASIN copied: ' + asin);
                }).catch(err => {
                    console.error('Failed to copy ASIN: ', err);
                });
            }
        });

        function populateLeadTypeDropdown(lead) {
            $('#modal-type-normal').prop('checked', lead.type === 'normal');
            $('#modal-type-bonus').prop('checked', lead.type === 'bonus');
            $('#modal-type-replenishable').prop('checked', lead.is_replenishable);
            $('#modal-type-hazmat').prop('checked', lead.is_hazmat);
            $('#modal-type-caution').prop('checked', lead.is_caution);
        }

        // Function to render icons dynamically in the modal
        function renderLeadIcons(modal, type, isReplenishable, isHazmat, isCaution) {
            let icons = '';

            if(type === 'normal') {
                icons += '<i class="ti ti-trophy text-warning fs-4 me-1" data-bs-toggle="tooltip" title="Normal"></i>';
            } else if(type === 'bonus') {
                icons += '<i class="ti ti-sparkles text-primary fs-4 me-1" data-bs-toggle="tooltip" title="Bonus"></i>';
            }

            if(isReplenishable) {
                icons += '<i class="ti ti-leaf text-success fs-4 me-1" data-bs-toggle="tooltip" title="Replenishable"></i>';
            }
            if(isHazmat) {
                icons += '<i class="ti ti-alert-triangle text-danger fs-4 me-1" data-bs-toggle="tooltip" title="Hazmat"></i>';
            }
            if(isCaution) {
                icons += '<i class="ti ti-circle-minus text-danger fs-4 me-1" data-bs-toggle="tooltip" title="Caution"></i>';
            }

            $(modal).find('#lead-type-icons').html(icons);
            
            initTooltips('#lead-type-icons [data-bs-toggle="tooltip"]');
        }

        function initTooltips(selector) {
            // Destroy old tooltips to avoid duplicates
            $(selector).each(function () {
                if (bootstrap.Tooltip.getInstance(this)) {
                    bootstrap.Tooltip.getInstance(this).dispose();
                }
            });

            // Re-initialize tooltips
            $(selector).each(function () {
                new bootstrap.Tooltip(this);
            });
        }

        // Radio buttons
        $('#edit-lead-tab').on('change', '.lead-type-radio', function() {
            const type = $(this).val();
            const isReplenishable = $('#modal-type-replenishable').is(':checked');
            const isHazmat = $('#modal-type-hazmat').is(':checked');
            const isCaution = $('#modal-type-caution').is(':checked');

            renderLeadIcons('#edit-lead-tab', type, isReplenishable, isHazmat, isCaution);
        });

        // Checkboxes
        $('#edit-lead-tab').on('change', '.lead-type-check', function() {
            const type = $('#modal-type-normal').is(':checked') ? 'normal' : 
                        ($('#modal-type-bonus').is(':checked') ? 'bonus' : '');
            const isReplenishable = $('#modal-type-replenishable').is(':checked');
            const isHazmat = $('#modal-type-hazmat').is(':checked');
            const isCaution = $('#modal-type-caution').is(':checked');

            renderLeadIcons('#edit-lead-tab', type, isReplenishable, isHazmat, isCaution);
        });

        $(document).ready(function() {
            // Submit Edit Lead form via AJAX
            $('#lead-edit-form').on('submit', function(e) {
                e.preventDefault();

                // Serialize form fields
                let formData = $(this).serializeArray(); // use array to add extra fields easily

                // Add type and checkboxes dynamically
                let type = $('#modal-type-normal').is(':checked') ? 'normal' :
                        ($('#modal-type-bonus').is(':checked') ? 'bonus' : '');
                let isReplenishable = $('#modal-type-replenishable').is(':checked') ? 1 : 0;
                let isHazmat = $('#modal-type-hazmat').is(':checked') ? 1 : 0;
                let isCaution = $('#modal-type-caution').is(':checked') ? 1 : 0;

                // Push extra fields to formData
                formData.push({ name: 'type', value: type });
                formData.push({ name: 'is_replenishable', value: isReplenishable });
                formData.push({ name: 'is_hazmat', value: isHazmat });
                formData.push({ name: 'is_caution', value: isCaution });

                $.ajax({
                    url: '/smart-data/lead/update',
                    type: 'POST',
                    data: $.param(formData), // convert back to query string
                    success: function(response) {
                        if(response.success) {
                            $('#addtoBuylistModal').modal('hide');
                            toastr.success('Lead updated successfully!');
                            $('#smart-data-table').DataTable().ajax.reload(null, false); // reload table
                        } else {
                            toastr.error(response.message || 'Failed to update lead.');
                        }
                    },
                    error: function(xhr) {
                        if(xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            $.each(errors, function(key, value) {
                                errorMessages += value[0] + '<br>';
                            });
                            toastr.error(errorMessages);
                        } else {
                            toastr.error('Something went wrong. Please try again.');
                        }
                    }
                });
            });
        });

        // DELETE Single Smart Data Lead (SweetAlert2)
        $(document).on("click", ".delSingleSmartData", function (e) {
            e.preventDefault();

            let id = $(this).data("id");

            Swal.fire({
                title: "Delete Lead?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "/smart-data/" + id,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (res) {

                            if (res.status === "success") {

                                Swal.fire({
                                    icon: "success",
                                    title: "Deleted!",
                                    text: "Lead has been removed.",
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                // ✅ Remove row from DataTable
                                $("#smart-data-table").DataTable().ajax.reload(null, false);

                                // ✅ Remove card from card layout
                                $(".card-smartdata-" + id).remove();
                            }
                        },
                        error: function () {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Could not delete lead."
                            });
                        }
                    });

                }
            });
        });

        // Open modal on bulkTags button click
        $(document).on('click', '.bulkTags', function(e) {
            e.preventDefault();
            
            // Get selected leads IDs
            let selectedIds = [];
            $('.smart-data-checkbox:checked').each(function() {
                selectedIds.push($(this).data('id'));
            });

            // Remove duplicates
            selectedIds = [...new Set(selectedIds)];

            if (selectedIds.length === 0) {
                alert('Please select at least one lead.');
                return;
            }

            // Store selected IDs in modal
            $('#bulkTagsModal').data('lead-ids', selectedIds);

            // Clear all checkboxes inside modal
            $('#bulkTagsModal .tag-checkbox').prop('checked', false);
            // Show modal
            $('#bulkTagsModal').modal('show');
        });

        // Apply tags button click
        $('#applyTagsBtn').on('click', function() {
            let selectedIds = $('#bulkTagsModal').data('lead-ids');
            let selectedTags = [];

            // Get checked tag checkboxes
            $('#bulkTagsModal .tag-checkbox:checked').each(function() {
                selectedTags.push($(this).val());
            });

            $.ajax({
                url: "{{ route('save.bulk.tags') }}",
                type: "POST",
                data: {
                    lead_ids: selectedIds,
                    tags: selectedTags.join(','), // store as comma-separated
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if(res.success){
                        $('#bulkTagsModal').modal('hide');
                        toastr.success(res.message);

                        // Optional: re-draw table / re-render cards
                        $('#smart-data-table').DataTable().ajax.reload();
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $(document).on('click', '#leadFieldsHideShow', function () {
            const section = $('#leadFieldsSection');
            const icon = $(this).find('i');
            
            section.toggleClass('d-none');
            
            if (section.hasClass('d-none')) {
                $(this).html('Show Details <i class="ti ti-chevron-down"></i>');
            } else {
                $(this).html('Hide Details <i class="ti ti-chevron-up"></i>');
            }
        });

        $(document).on('click', '.btn-plus', function () {
            const input = $(this).siblings('input[type="number"]');
            let value = parseInt(input.val()) || 1;
            input.val(value + 1);
        });

        $(document).on('click', '.btn-minus', function () {
            const input = $(this).siblings('input[type="number"]');
            let value = parseInt(input.val()) || 1;
            if (value > 1) {
                input.val(value - 1);
            }
        });

        $(document).ready(function() {
            $('#multiBuyList').select2({
                placeholder: 'Select Buy List',
                allowClear: true,
                width: '100%'
            });
        });

        $(document).on('submit', '#add-to-buylist-form', function (e) {
            e.preventDefault();

            const form = $(this);
            const submitBtn = $('button[form="add-to-buylist-form"]');
            const selectedBuyLists = $('#multiBuyList').val();

            if (!selectedBuyLists || selectedBuyLists.length === 0) {
                toastr.error('Please select at least one Buy List.');
                return;
            }

            submitBtn.prop('disabled', true).text('Adding...');

            $.ajax({
                url: "{{ route('buylist.addItem') }}",
                method: "POST",
                data: form.serialize(),
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        form[0].reset();
                    } else {
                        toastr.error(response.message || 'Something went wrong.');
                    }
                },
                error: function () {
                    toastr.error('Server error. Please try again.');
                },
                complete: function () {
                    submitBtn.prop('disabled', false).text('Add to Buylist');
                }
            });
        });

        $(document).on('click', '.close-dropdown-btn', function () {
            $(this).closest(".dropdown-menu").removeClass("show");
        });

        $(document).on('click', '#modal-type-close', function () {
            $(this).closest(".dropdown-menu").removeClass("show");
        });

        $(document).on('click', '.save-tags-btn', function () {
            const leadId = $(this).data('id');

            let selected = [];
            $('#tag_' + leadId + '_').closest('.dropdown')
            $(this).closest('.dropdown-menu')
                .find('.lead-tag-checkbox:checked')
                .each(function () {
                    selected.push($(this).val());
                });

            $.ajax({
                url: "{{ route('lead.save.tags') }}",
                type: "POST",
                data: {
                    lead_id: leadId,
                    tags: selected.join(','),  // ✅ comma separated
                    _token: "{{ csrf_token() }}"
                },
                success: function () {
                    toastr.success("Tags updated!");

                    // ✅ reload datatable to show updated tag badges
                    $('#smart-data-table').DataTable().ajax.reload(null, false);
                }
            });
        });

        $(document).on('click', '.save-type-btn', function () {
            let leadId = $(this).data('id');
            let parent = $(this).closest('.dropdown-menu');

            let type = parent.find('.lead-type-radio:checked').val();

            let is_replenishable = parent.find('input[data-field="is_replenishable"]').is(':checked') ? 1 : 0;
            let is_hazmat = parent.find('input[data-field="is_hazmat"]').is(':checked') ? 1 : 0;
            let is_caution = parent.find('input[data-field="is_caution"]').is(':checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('leads.saveType') }}",
                type: "POST",
                data: {
                    lead_id: leadId,
                    type: type,
                    is_replenishable,
                    is_hazmat,
                    is_caution,
                    _token: "{{ csrf_token() }}"
                },
                success: function () {
                    toastr.success("Type updated!");

                    // ✅ Reload only this row
                    // $('#smart-data-table').DataTable().ajax.reload(null, false);

                    // ✅ Close dropdown
                    parent.removeClass("show");
                }
            });
        });

        // ✅ Live update icons when radio or checkbox changes
        $(document).on('change', '.lead-type-radio, .lead-type-check', function () {

            let dropdown = $(this).closest('.dropdown');
            let leadId = dropdown.find('.add-type-btn').data('id');

            let selectedType = dropdown.find('.lead-type-radio:checked').val();

            let isRepl = dropdown.find('input[data-field="is_replenishable"]').is(':checked');
            let isHazmat = dropdown.find('input[data-field="is_hazmat"]').is(':checked');
            let isCaution = dropdown.find('input[data-field="is_caution"]').is(':checked');

            let icons = "";

            // ✅ Radio icons
            if (selectedType === "normal") {
                icons += `<i class="ti ti-trophy text-warning fs-4 me-1" data-bs-toggle="tooltip"
                        title="Normal"></i>`;
            }
            if (selectedType === "bonus") {
                icons += `<i class="ti ti-sparkles text-primary fs-4 me-1" data-bs-toggle="tooltip"
                        title="Bouns"></i>`;
            }

            // ✅ Checkbox icons
            if (isRepl) {
                icons += `<i class="ti ti-leaf text-success fs-4 me-1" data-bs-toggle="tooltip"
                        title="Replenishable"></i>`;
            }
            if (isHazmat) {
                icons += `<i class="ti ti-alert-triangle text-danger fs-4 me-1" data-bs-toggle="tooltip"
                        title="Hazmat"></i>`;
            }
            if (isCaution) {
                icons += `<i class="ti ti-circle-minus text-danger fs-4 me-1" data-bs-toggle="tooltip"
                        title="Caution"></i>`;
            }

            // ✅ Update the icon container immediately
            $(".lead-type-icons-" + leadId).html(icons);
            $(".lead-type-icons-" + leadId + " [data-bs-toggle='tooltip']").each(function () {
                new bootstrap.Tooltip(this);
            });
        });
    </script>

@endsection