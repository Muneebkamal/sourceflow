@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Orders</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                    <form action="javascript:void(0);">
                        <div class="row g-2 mb-0 align-items-center">
                            <div class="col-auto">
                                <button class="btn btn-soft-primary">
                                    Export
                                </button>
                                <button class="btn btn-primary">
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
                        <option value="partially received">Partially Received</option>
                        <option value="received in full">Received in Full</option>
                        <option value="ordered">Ordered</option>
                        <option value="draft">Draft</option>
                        <option value="closed">Closed</option>
                        <option value="canceled">Canceled</option>
                        <option value="reconcile">Reconcile</option>
                        <option value="breakage">Breakage</option>
                        </select>
                </div>

                <!-- Filter + Reset Buttons -->
                <div class="d-flex">
                    <button class="btn btn-soft-danger">Reset</button>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="d-flex align-items-end justify-content-md-end gap-1 mt-2 mt-md-0">
                <div class="btn-group" role="group" id="viewToggle">
                    <button type="button" class="btn btn-primary">Orders View</button>
                    <button type="button" class="btn btn-soft-primary">Items View</button>
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
                                    <!-- Created -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-created_at">
                                            <label class="form-check-label ms-2" for="col-created_at">Created</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Order Date -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-ordered_at" checked>
                                            <label class="form-check-label ms-2" for="col-ordered_at">Order Date</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Updated -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-updated_at">
                                            <label class="form-check-label ms-2" for="col-updated_at">Updated</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Closed -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-closed_at">
                                            <label class="form-check-label ms-2" for="col-closed_at">Closed</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Order # (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-order_ref_number" checked disabled>
                                            <label class="form-check-label ms-2" for="col-order_ref_number">Order #</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Email -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-email_used">
                                            <label class="form-check-label ms-2" for="col-email_used">Email</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Supplier -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-source" checked>
                                            <label class="form-check-label ms-2" for="col-source">Supplier</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Subtotal (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-sub_total" disabled>
                                            <label class="form-check-label ms-2" for="col-sub_total">Subtotal</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Tax (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-tax_paid" disabled>
                                            <label class="form-check-label ms-2" for="col-tax_paid">Tax</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Tax Rate (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-tax_percent" disabled>
                                            <label class="form-check-label ms-2" for="col-tax_percent">Tax Rate</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Shipping -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-shipping_total">
                                            <label class="form-check-label ms-2" for="col-shipping_total">Shipping</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Order Total (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-order_total" checked disabled>
                                            <label class="form-check-label ms-2" for="col-order_total">Order Total</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Card Used -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-card_used">
                                            <label class="form-check-label ms-2" for="col-card_used">Card Used</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Amount Charged -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-amount_charged">
                                            <label class="form-check-label ms-2" for="col-amount_charged">Amount Charged</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Order Status -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-awd_status" checked>
                                            <label class="form-check-label ms-2" for="col-awd_status">Order Status</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Destination -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-destination">
                                            <label class="form-check-label ms-2" for="col-destination">Destination</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- O-R-L-E-F (Disabled) -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-orse" checked disabled>
                                            <label class="form-check-label ms-2" for="col-orse">O-R-L-E-F</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Order Note -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-note" checked>
                                            <label class="form-check-label ms-2" for="col-note">Order Note</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Events -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-itemEvents" checked>
                                            <label class="form-check-label ms-2" for="col-itemEvents">Events</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Cash Back Src -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-cash_back_source">
                                            <label class="form-check-label ms-2" for="col-cash_back_source">Cash Back Src</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Cash Back % -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-cash_back_percent">
                                            <label class="form-check-label ms-2" for="col-cash_back_percent">Cash Back %</label>
                                        </div>
                                        <i class="ti ti-grip-vertical grip-icon"></i>
                                    </div>

                                    <!-- Cash Back -->
                                    <div class="d-flex justify-content-between align-items-center draggable-item">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="col-cash_back_amount">
                                            <label class="form-check-label ms-2" for="col-cash_back_amount">Cash Back</label>
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
                        <table id="orders-table" class="table align-middle w-100 mb-0 table-hover">
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

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#orders-table').DataTable({
            scrollY: '40vh',
            searching: false,
            lengthChange: false,
            ordering: false,
            scrollX: true,
            scrollCollapse: true,
            paging: true,
        });
    });

    $(document).on('click', '#viewToggle .btn', function() {
        $('#viewToggle .btn').removeClass('btn-primary').addClass('btn-soft-primary');
        $(this).removeClass('btn-soft-primary').addClass('btn-primary');
    });

</script>
@endsection