@extends('layouts.app')

@section('title', 'BuyList')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Buy Lists</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                    <form action="javascript:void(0);">
                        <div class="row g-2 mb-0 align-items-center">
                            <div class="col-auto">
                                <a class="" href="#" target="_blank">
                                    <p class="text-success m-0">🎉 To Add Leads to a Buy List, Use the SF Extension!</p>
                                </a>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-soft-primary">
                                    Export
                                </button>
                                <button type="button" class="btn btn-soft-primary" data-bs-toggle="modal" data-bs-target="#createBuylistModal">
                                New Buy List
                                </button>
                                <button class="btn btn-primary" disabled>
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
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                </div>

                <!-- Filter + Reset Buttons -->
                <div class="d-flex gap-1">
                    <button class="btn btn-soft-danger">Reset</button>
                    <button class="btn btn-soft-primary">View Ordered Leads</button>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="d-flex align-items-end justify-content-md-end gap-1 mt-2 mt-md-0">
                <button class="btn btn-soft-primary">
                    Rejected List <i class="ti ti-ban fs-4"></i>
                </button>

                <div class="btn-group drop-down">
                    <button type="button" class="btn btn-soft-primary dropdown-toggle drop-arrow-none" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                        Select Buy List <i class="ti ti-chevron-down align-middle ms-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-md p-0 shadow">
                        <div class="card border-0 mb-0">
                            <div class="card-header bg-light py-2">
                                <h5 class="mb-0 fw-semibold">Select Buylists</h5>
                            </div>

                            <div class="card-body p-2">
                                <div class="column-list">
                                    <!-- Default Buy List -->
                                    <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-335">
                                            <label class="form-check-label mb-0" for="col-335">Default Buy List</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y">
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Kamal Buy List -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-335">
                                            <label class="form-check-label mb-0" for="col-335">Kamal</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y">
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>

                                    <!-- Replenishments Buy List -->
                                    <div class="d-flex justify-content-between align-items-center mb-2 column-item position-relative">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="col-335">
                                            <label class="form-check-label mb-0" for="col-335">Replenishments</label>
                                        </div>
                                        <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y">
                                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-soft-primary">Create Buylist <i class="ti ti-plus"></i></button>
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
                                    <!-- Order note -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-order_note">
                                            <label class="form-check-label ms-2" for="col-order_note">Order note</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Date Added -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-created_at" checked>
                                            <label class="form-check-label ms-2" for="col-created_at">Date Added</label>
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

                                    <!-- Image -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-image" checked>
                                            <label class="form-check-label ms-2" for="col-image">Image</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Product Title (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-name" checked disabled>
                                            <label class="form-check-label ms-2" for="col-name">Product Title</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Variation Details -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-variation_details" checked>
                                            <label class="form-check-label ms-2" for="col-variation_details">Variation Details</label>
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

                                    <!-- Buy Cost -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-cost_per_unit" checked>
                                            <label class="form-check-label ms-2" for="col-cost_per_unit">Buy Cost</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Estimated Selling Price -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-estimated_sale_price" checked>
                                            <label class="form-check-label ms-2" for="col-estimated_sale_price">Estimated Selling Price</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Quantity (To Purchase) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-units_purchased">
                                            <label class="form-check-label ms-2" for="col-units_purchased">Quantity (To Purchase)</label>
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

                                    <!-- Promo -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-promo">
                                            <label class="form-check-label ms-2" for="col-promo">Promo</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Coupon Code -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-coupon_code">
                                            <label class="form-check-label ms-2" for="col-coupon_code">Coupon Code</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Product Note -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-product_note" checked>
                                            <label class="form-check-label ms-2" for="col-product_note">Product Note</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Buyer Note -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-buyer_note" checked>
                                            <label class="form-check-label ms-2" for="col-buyer_note">Buyer Note</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- UPC/GTIN -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-upc_code">
                                            <label class="form-check-label ms-2" for="col-upc_code">UPC/GTIN</label>
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

                                    <!-- Monthly Sold -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-monthly_sold">
                                            <label class="form-check-label ms-2" for="col-monthly_sold">Monthly Sold</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Offers -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-new_offers_count">
                                            <label class="form-check-label ms-2" for="col-new_offers_count">Offers</label>
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

                                    <!-- Buy List Name -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-buy_list_name">
                                            <label class="form-check-label ms-2" for="col-buy_list_name">Buy List Name</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Lead Type -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-lead_type">
                                            <label class="form-check-label ms-2" for="col-lead_type">Lead Type</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- SKU Total Cost -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-sku_total_cost">
                                            <label class="form-check-label ms-2" for="col-sku_total_cost">SKU Total Cost</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- ROI Est -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-roi_estimated">
                                            <label class="form-check-label ms-2" for="col-roi_estimated">ROI Est</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Net Profit Est -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-net_profit_estimated">
                                            <label class="form-check-label ms-2" for="col-net_profit_estimated">Net Profit Est</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- BSR Current -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-bsr_current">
                                            <label class="form-check-label ms-2" for="col-bsr_current">BSR Current</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Category -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-category">
                                            <label class="form-check-label ms-2" for="col-category">Category</label>
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
                        <table id="buylist-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th><input type="checkbox" class="form-check-input"></th>
                                    <th>Date Added</th>
                                    <th>Asin</th>
                                    <th>Image</th>
                                    <th>Product Title</th>
                                    <th>Variations</th>
                                    <th>Supplier</th>
                                    <th>Cost</th>
                                    <th>BSR 90D Avg</th>
                                    <th>Product Note</th>
                                    <th>Buyer Note</th>
                                    <th class="sticky-col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Row 1 -->
                                <tr class="small">
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>2025/09/20</td>
                                    <td>B09XYZ123</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                    <td>Wireless Headphones</td>
                                    <td><span class="badge bg-primary">Hot</span> <span class="badge bg-success">New</span></td>
                                    <td>Supplier A</td>
                                    <td>$789</td>
                                    <td>12,345</td>
                                    <td>Fast Selling</td>
                                    <td>Good margin</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-success">
                                                <i class="ti ti-currency-dollar"></i>
                                            </button>
                                            <button class="btn btn-sm btn-light">
                                                <i class="ti ti-external-link"></i>
                                            </button>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 2 -->
                                <tr class="small">
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>2025/09/18</td>
                                    <td>B07ABC456</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                    <td>Vacuum Cleaner</td>
                                    <td><span class="badge bg-info">Trending</span></td>
                                    <td>Supplier B</td>
                                    <td>$789</td>
                                    <td>8,765</td>
                                    <td>Popular Choice</td>
                                    <td>High Demand</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-success"><i class="ti ti-currency-dollar"></i></button>
                                            <button class="btn btn-sm btn-light"><i class="ti ti-external-link"></i></button>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 3 -->
                                <tr class="small">
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>2025/09/10</td>
                                    <td>B08LMN789</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                    <td>Football Shoes</td>
                                    <td><span class="badge bg-warning">Seasonal</span></td>
                                    <td>Supplier C</td>
                                    <td>$789</td>
                                    <td>6,540</td>
                                    <td>Best for players</td>
                                    <td>Good performance</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-success"><i class="ti ti-currency-dollar"></i></button>
                                            <button class="btn btn-sm btn-light"><i class="ti ti-external-link"></i></button>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 4 -->
                                <tr class="small">
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>2025/09/20</td>
                                    <td>B09XYZ123</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                    <td>Wireless Headphones</td>
                                    <td><span class="badge bg-primary">Hot</span> <span class="badge bg-success">New</span></td>
                                    <td>Supplier A</td>
                                    <td>$789</td>
                                    <td>12,345</td>
                                    <td>Fast Selling</td>
                                    <td>Good margin</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-success">
                                                <i class="ti ti-currency-dollar"></i>
                                            </button>
                                            <button class="btn btn-sm btn-light">
                                                <i class="ti ti-external-link"></i>
                                            </button>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 5 -->
                                <tr class="small">
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>2025/09/18</td>
                                    <td>B07ABC456</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                    <td>Vacuum Cleaner</td>
                                    <td><span class="badge bg-info">Trending</span></td>
                                    <td>Supplier B</td>
                                    <td>$789</td>
                                    <td>8,765</td>
                                    <td>Popular Choice</td>
                                    <td>High Demand</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-success"><i class="ti ti-currency-dollar"></i></button>
                                            <button class="btn btn-sm btn-light"><i class="ti ti-external-link"></i></button>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 6 -->
                                <tr class="small">
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>2025/09/10</td>
                                    <td>B08LMN789</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                    <td>Football Shoes</td>
                                    <td><span class="badge bg-warning">Seasonal</span></td>
                                    <td>Supplier C</td>
                                    <td>$789</td>
                                    <td>6,540</td>
                                    <td>Best for players</td>
                                    <td>Good performance</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-success"><i class="ti ti-currency-dollar"></i></button>
                                            <button class="btn btn-sm btn-light"><i class="ti ti-external-link"></i></button>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 7 -->
                                <tr class="small">
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>2025/09/20</td>
                                    <td>B09XYZ123</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                    <td>Wireless Headphones</td>
                                    <td><span class="badge bg-primary">Hot</span> <span class="badge bg-success">New</span></td>
                                    <td>Supplier A</td>
                                    <td>$789</td>
                                    <td>12,345</td>
                                    <td>Fast Selling</td>
                                    <td>Good margin</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-success">
                                                <i class="ti ti-currency-dollar"></i>
                                            </button>
                                            <button class="btn btn-sm btn-light">
                                                <i class="ti ti-external-link"></i>
                                            </button>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 8 -->
                                <tr class="small">
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>2025/09/18</td>
                                    <td>B07ABC456</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                    <td>Vacuum Cleaner</td>
                                    <td><span class="badge bg-info">Trending</span></td>
                                    <td>Supplier B</td>
                                    <td>$789</td>
                                    <td>8,765</td>
                                    <td>Popular Choice</td>
                                    <td>High Demand</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-success"><i class="ti ti-currency-dollar"></i></button>
                                            <button class="btn btn-sm btn-light"><i class="ti ti-external-link"></i></button>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Row 9 -->
                                <tr class="small">
                                    <td><input type="checkbox" class="form-check-input"></td>
                                    <td>2025/09/10</td>
                                    <td>B08LMN789</td>
                                    <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                    <td>Football Shoes</td>
                                    <td><span class="badge bg-warning">Seasonal</span></td>
                                    <td>Supplier C</td>
                                    <td>$789</td>
                                    <td>6,540</td>
                                    <td>Best for players</td>
                                    <td>Good performance</td>
                                    <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-success"><i class="ti ti-currency-dollar"></i></button>
                                            <button class="btn btn-sm btn-light"><i class="ti ti-external-link"></i></button>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
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
        </div>
    </div>

    @include('modals.buylists.create-buylist-modal')
@endsection
    
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#buylist-table').DataTable({
                scrollY: '40vh',
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