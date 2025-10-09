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
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <select class="form-select w-50">
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
                    <button class="btn btn-soft-danger">Reset</button>
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
                                <th>Order Date</th>
                                <th>Order #</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Status</th>
                                <th>Supplier</th>
                                <th>Order Total</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Note</th>
                                <th class="sticky-col text-center">Actions</th>
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
                                <td>Electronics</td>
                                <td>Good margin</td>
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

                            <!-- Row 2 -->
                            <tr class="small">
                                <td><input type="checkbox" class="form-check-input"></td>
                                <td>2025/09/18</td>
                                <td>B07ABC456</td>
                                <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                <td>Vacuum Cleaner</td>
                                <td><span class="badge bg-info">Trending</span></td>
                                <td>Supplier B</td>
                                <td>$599</td>
                                <td>8,765</td>
                                <td>Home Appliances</td>
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
                                <td>$249</td>
                                <td>6,540</td>
                                <td>Sports</td>
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
                                <td>2025/09/05</td>
                                <td>B06PQR321</td>
                                <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                <td>Smart Watch</td>
                                <td><span class="badge bg-secondary">Limited</span></td>
                                <td>Supplier D</td>
                                <td>$399</td>
                                <td>4,230</td>
                                <td>Wearables</td>
                                <td>Battery efficient</td>
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

    @include('modals.shipping.create-shipping-batch-modal')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#shipping-table').DataTable({
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