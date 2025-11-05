@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="row mt-2">
        <div class="col-md-12 mt-2">
            <form id="order-form">
                <div class="page-title-head d-flex align-items-sm-start flex-sm-row flex-column" style="height: auto;">
                    <div class="d-flex align-items-center flex-grow-1">
                        <a href="{{ route('orders.index') }}" class="btn btn-soft-primary"><i class="ti ti-arrow-left fs-2"></i></a>
                        <div class="ms-2" id="order-info">
                            <h4 class="fs-18 fw-semibold m-0">Order #<span id="order-id">{{ $order->order_id }}</span></h4>
                            <p class="m-0">Order Date: <span id="order-date">{{ \Carbon\Carbon::parse($order->date)->format('m/d/y') }}</span></p>
                        </div>
                        <div class="ms-2 align-top">
                            <i class="ti ti-edit fs-2" id="edit-order" style="cursor:pointer;"></i>
                        </div>
                    </div>

                    
                    <div class="mt-3 mt-sm-0">
                        <div class="row g-4 mb-0 align-items-start">
                            <div class="col-auto">
                                <button class="btn btn-light mt-1" data-bs-toggle="modal" data-bs-target="#attachmentsModal">
                                    <i class="ti ti-paperclip fs-4"></i> Attachments (0)
                                </button>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex justify-content-between align-items-center text-center gap-3 w-100">
                                    <div>
                                        <span class="badge bg-light text-secondary px-2 py-1">{{ $order->total_units_purchased }}</span>
                                        <div class="fw-bold mt-1">Ordered</div>
                                    </div>
                                    <div>
                                        <span class="badge badge-soft-primary px-2 py-1">{{ $order->total_units_received }}</span>
                                        <div class="fw-bold mt-1">Received</div>
                                    </div>
                                    <div>
                                        <span class="badge badge-soft-success px-2 py-1">{{ $order->total_units_shipped }}</span>
                                        <div class="fw-bold mt-1">Listed</div>
                                    </div>
                                    <div>
                                        <span class="badge badge-soft-danger px-2 py-1">{{ $order->unit_errors }}</span>
                                        <div class="fw-bold mt-1">Error</div>
                                    </div>
                                    <div>
                                        <span class="badge badge-soft-warning px-2 py-1">0</span>
                                        <div class="fw-bold mt-1">Fixed</div>
                                    </div>
                                </div>
                                <div class="mt-2 d-flex justify-content-center">
                                    <span class="badge bg-light text-dark py-2 px-3">0 % Completed</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <select class="form-select status-select fw-semibold mt-1" name="status">
                                    <option value="ordered" class="bg-white text-dark" {{ $order->status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                                    <option value="partially received" class="bg-white text-dark" {{ $order->status == 'partially received' ? 'selected' : '' }}>Partially Received</option>
                                    <option value="received in full" class="bg-white text-dark" {{ $order->status == 'received in full' ? 'selected' : '' }}>Received in Full</option>
                                    <option value="draft" class="bg-white text-dark" {{ $order->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="closed" class="bg-white text-dark" {{ $order->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                    <option value="canceled" class="bg-white text-dark" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                    <option value="reconcile" class="bg-white text-dark" {{ $order->status == 'reconcile' ? 'selected' : '' }}>Reconcile</option>
                                    <option value="breakage" class="bg-white text-dark" {{ $order->status == 'breakage' ? 'selected' : '' }}>Breakage</option>
                                </select>
                                <div class="mt-2">
                                    <button class="btn btn-primary"><i class="ti ti-calculator fs-4"></i></button>
                                    <button id="save-order-form" class="btn btn-primary" disabled><i class="ti ti-device-floppy me-1 fs-4"></i> Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Order Details
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                                            <h5 class="mb-0">Order Info</h5>
                                            <a href="#" class="text-decoration-none" id="edit-order-info">
                                                <i class="ti ti-pencil" id="edit-icon-order-info"></i>
                                                <span id="edit-text-order-info"> Edit</span>
                                            </a>

                                        </div>

                                        <div class="card-body">
                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Source</span>
                                                <span class="fw-bold text-dark editable-field" id="source-field">
                                                    @php
                                                        $sourceUrl = $order->source;
                                                        if ($sourceUrl && !Str::startsWith($sourceUrl, ['http://', 'https://'])) {
                                                            $sourceUrl = 'https://' . $sourceUrl;
                                                        }
                                                    @endphp
                                                    <a href="{{ $sourceUrl }}" target="_blank" class="text-primary text-decoration-none">
                                                        {{ $order->source }}
                                                        <i class="ti ti-external-link text-primary fs-5 align-middle"></i>
                                                    </a>
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Email Used</span>
                                                <span class="fw-bold text-dark editable-field" id="email-field">{{ $order->email }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Destination</span>
                                                <span class="fw-bold text-dark editable-field" id="destination-field">{{ $order->destination }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Created At</span>
                                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($order->date)->format('m/d/y') }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Last Updated</span>
                                                <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($order->updated_at)->format('m/d/y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                                            <h5 class="mb-0">Order Totals</h5>
                                            <a href="{{ route('buy.cost.calculator', $order->id) }}" class="text-decoration-none">
                                                <i class="ti ti-calculator"></i> Edit
                                            </a>
                                        </div>

                                        <div class="card-body">
                                            <div class="d-flex justify-content-between  pb-2">
                                                <span class="text-muted">Subtotal (Pre Tax)</span>
                                                <span class="fw-bold text-dark">${{ number_format($order->subtotal,2)}}</span>
                                            </div>

                                            <div class="d-flex justify-content-between  pb-2">
                                                <span class="text-muted">Shipping Total</span>
                                                <span class="fw-bold text-dark">${{ number_format($order->shipping_cost,2) }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between  pb-2">
                                                <span class="text-muted">Sales Tax Paid</span>
                                                <span class="fw-bold text-dark">${{ number_format($order->sales_tax,2) }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between  pb-2">
                                                <span class="text-muted">Sales Tax Rate</span>
                                                <span class="fw-bold text-dark">{{ isset($order->sales_tax_rate) ? number_format($order->sales_tax_rate,2) . '%' : '0.00%' }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Grand Total</span>
                                                <span class="fw-bold text-dark">${{ number_format($order->total,2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                                            <h5 class="mb-0">Payment Details</h5>
                                            <a href="#" class="text-decoration-none" id="edit-payment-info">
                                                <i class="ti ti-pencil" id="edit-icon-payment-info"></i> 
                                                <span id="edit-text-payment-info">Edit</span>
                                            </a>
                                        </div>

                                        <div class="card-body">
                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Card Used</span>
                                                <span class="fw-bold text-dark" id="card-used-field">{{ $order->card_used }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Amount Charged</span>
                                                <span class="fw-bold text-dark" id="amount-charged-field">
                                                    ${{ number_format($order->total,2) }}
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Cash Back Source</span>
                                                <span class="fw-bold text-dark" id="cash-back-source-field">{{ $order->cash_back_source }}</span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Cash Back % ($0.00)</span>
                                                <span class="fw-bold text-dark" id="cash-back-percentage-field">
                                                    {{ isset($order->cash_back_percentage) ? number_format($order->cash_back_percentage,2) . '%' : '0.00%' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between align-items-center border-top">
                                            <p class="mb-0">Gift Cards</p>
                                            <a href="#" class="text-decoration-none">
                                                <i class="ti ti-gift"></i> Add Gift Card
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2 g-2">
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                                            <h5 class="mb-0">Order Notes</h5>
                                            <a href="#" class="text-decoration-none check-icon" style="display:none;">
                                                <i class="ti ti-check"></i>
                                            </a>
                                        </div>
                                        <div class="card-body note-card">
                                            <div class="note-text">{{ $order->note }}</div>
                                            <textarea name="note" class="form-control" style="display:none;" cols="30" rows="10">{{ $order->note }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header border-bottom">
                                            <h5 class="mb-0">Event Logs</h5>
                                        </div>
                                        <div class="card-body p-0 px-1">
                                            <div class="table-responsive">
                                                <table id="event-table" class="table table-hover align-middle w-100 mb-0">
                                                    <thead>
                                                        <th>Event Type</th>
                                                        <th>ASIN</th>
                                                        <th>Qty</th>
                                                        <th>Created At</th>
                                                        <th>Updated At</th>
                                                        <th>Action</th>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="m-0">Order Items (<span id="items-count">0</span>)</h4>
                <div class="gap-2">
                    <button id="openEditItems" type="button" class="btn btn-soft-primary edit-item-btn" data-id="1">
                        Edit Items
                    </button>
                    <button id="toggleShipping" class="btn btn-soft-primary">
                        Show Events <i class="ti ti-eye"></i>
                    </button>
                    <div class="btn-group">
                        <button class="btn btn-soft-primary" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                            Create Event
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    Never Received
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item mark-fixed" data-id="{{ $order->id }}" href="#">
                                    Mark Order as Fixed
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item disabled"
                                href="#"
                                tabindex="-1"
                                aria-disabled="true"
                                data-bs-toggle="tooltip"
                                data-bs-title="Coming Soon"
                                style="pointer-events: none; opacity: 0.5;">
                                    List to FBA
                                </a>
                            </li>
                        </ul>
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
                                    <div class="column-list-draggable"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="select-count-section" class="d-flex mb-2 align-items-center d-none">
                <div class="dropdown">
                    <button class="btn btn-sm btn-light" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item updateStatusBtn" href="#">Update Status</a></li>
                        <li><a class="dropdown-item text-danger bulkDelBtn" href="#">Delete</a></li>
                    </ul>
                </div>
                <span class="fw-bold ms-3">Selected: <span id="selectedCount">0</span></span>
            </div>
            <div class="card mt-3">
                <div class="card-body p-0"> 
                    <div class="table-responsive">
                        <table id="order-items-table" data-order-id="{{ $order->id }}" class="table align-middle w-100 mb-0">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                    <th>Parent Order Note</th>
                                    <th>Image</th>
                                    <th>Order Ref Number</th>
                                    <th>Product Title</th>
                                    <th>Variation Details</th>
                                    <th>AsinRecord</th>
                                    <th>ASIN</th>
                                    <th>MSKU</th>
                                    <th>QTY</th>
                                    <th>Cost</th>
                                    <th>SKU Total</th>
                                    <th>O-R-L-E-F</th>
                                    <th>Product Note</th>
                                    <th>List Price</th>
                                    <th>Min Price</th>
                                    <th>Max price</th>
                                    <th>Order Date</th>
                                    <th>BSR Current</th>
                                    <th>Buyer Note</th>
                                    <th>Actions</th>
                                    {{-- <th class="sticky-col text-center">Actions</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.order.order-detail.attachment-modal')
    @include('modals.order.order-detail.lineitems-edit-modal')
    @include('modals.order.order-detail.create-event-modal')
    @include('modals.order.order-detail.edit-event-modal')
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        const modal = $('#editItemsModal');
        let table = $('#order-items-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('order.items', $order->id) }}',
            drawCallback: function () {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (el) {
                    return new bootstrap.Tooltip(el);
                });
            },
            scrollY: '40vh',
            scrollX: true,
            paging: false,
            ordering: false,
            searching: false,
            colReorder: true,
            stateSave: true,
            columns: [
                { data: 'checkbox', orderable: false, searchable: false },   // index 0 (IGNORE)
                { data: 'parent_order_note', name: 'parent_order_note' },
                { data: 'image', name: 'image' },
                { data: 'order_id', name: 'order_id' },
                { data: 'name', name: 'name' },
                { data: 'variation_details', name: 'variation_details' },
                { data: 'asin_record', defaultContent: '', name: 'asin_record' },
                { data: 'asin', name: 'asin' },
                { data: 'msku', name: 'msku' },
                { data: 'qty', name: 'qty' },
                { data: 'cost', name: 'cost' },
                { data: 'sku_total', name: 'sku_total' },
                { data: 'orlef', name: 'orlef' },
                { data: 'order_note', name: 'order_note' },
                { data: 'list_price', name: 'list_price' },
                { data: 'min', name: 'min' },
                { data: 'max', name: 'max' },
                { data: 'order_date', name: 'order_date' },
                { data: 'bsr', name: 'bsr' },
                { data: 'buyer_note', name: 'buyer_note' },
                { data: 'actions', orderable: false, searchable: false }     // LAST (IGNORE)
            ]
        });

        generateColumnList();
        function generateColumnList() {
            const list = $('.column-list-draggable');
            list.empty();

            const disabledCols = ['image', 'name', 'msku', 'cost', 'qty', 'sku_total'];

            table.columns().every(function (index) {
                // ✅ skip first & last column
                if (index === 0 || index === table.columns().count() - 1) return;

                const col = table.column(index);
                const colDataKey = table.settings()[0].aoColumns[index].data;
                const title = $(col.header()).text().trim() || colDataKey;

                const checked = col.visible() ? 'checked' : '';
                const disabled = disabledCols.includes(colDataKey) ? 'disabled' : '';

                list.append(`
                    <div class="d-flex justify-content-between align-items-center draggable-item" data-col="${index}">
                        <div>
                            <input class="form-check-input col-toggle" 
                                type="checkbox" 
                                data-col="${index}" 
                                ${checked} ${disabled}>
                            <label class="form-check-label ms-2">${title}</label>
                        </div>
                        <i class="ti ti-grip-vertical grip-icon"></i>
                    </div>
                `);
            });

            attachToggleEvents();
            enableDragSort();
        }

        function attachToggleEvents() {
            $('.col-toggle').on('change', function () {
                const index = $(this).data('col');
                table.column(index).visible(this.checked);
            });
        }

        function enableDragSort() {
            $(".column-list-draggable").sortable({
                handle: ".grip-icon",
                update: function () {

                    let reordered = [];

                    const totalCols = table.columns().count();

                    // ✅ 1) Start with default order [0,1,2,3...]
                    for (let i = 0; i < totalCols; i++) {
                        reordered[i] = i;
                    }

                    // ✅ 2) Get ONLY draggable middle columns
                    let dragCols = [];
                    $(".draggable-item").each(function () {
                        dragCols.push($(this).data("col"));
                    });

                    // ✅ 3) Apply new order to middle columns only
                    // index 0 (checkbox) stays same
                    // last column (actions) stays same
                    let j = 0;
                    for (let i = 1; i < totalCols - 1; i++) {
                        reordered[i] = dragCols[j];
                        j++;
                    }

                    // ✅ 4) Apply to DataTable (NO WARNING)
                    table.colReorder.order(reordered);
                }
            });
        }

        // ✅ Update count label
        table.on('xhr.dt', function (e, settings, json, xhr) {
            $('#items-count').text(json?.recordsTotal ?? 0);
        });

        // -------------------------------
        // Common Variables & Functions
        // -------------------------------
        let itemsData = [];
        let currentIndex = 0;

        // ✅ Populate modal with data
        function populateModal(data) {
            // console.log(data);
            modal.find('#editItemsModalLabel').text(data.raw.name ?? '-');
            modal.find('img[alt="Product Image"]').attr('src', 'https://app.sourceflow.io/storage/images/no-image-thumbnail.png');

            modal.find('#name').val(data.raw.name ?? '');
            modal.find('#asin').val(data.raw ? data.raw.asin_input ?? '' : data.asin ?? '');
            modal.find('#variation').val(data.variation_details ?? '');
            modal.find('#msku').val(data.msku ?? '');
            modal.find('#category').val(data.category ?? '');
            modal.find('#supplier').val(data.supplier ?? '');
            modal.find('#unitsPurchased').val(data.unit_purchased ?? '');
            modal.find('#costPerUnit').val(data.raw ? data.raw.cost ?? '' : data.cost ?? '');
            modal.find('#sellingPrice').val(data.selling_price ?? '');
            modal.find('#netProfit').val(data.net_profit ?? '');
            modal.find('#listPrice').val(data.list_price ?? '');
            modal.find('#minPrice').val(data.min ?? '');
            modal.find('#maxPrice').val(data.max ?? '');
            modal.find('#roi').val(data.roi ?? '');
            modal.find('#bsr_ninety').val(data.bsr ?? '');
            modal.find('#source_url').val(data.source_url ?? '');
            modal.find('#promo').val(data.promo ?? '');
            modal.find('#coupon_code').val(data.coupon ?? data.coupon_code ?? '');
            modal.find('#product_note').val(data.order_note ?? data.product_notes ?? '');
            modal.find('#buyerNote').val(data.buyer_note ?? data.buyer_notes ?? '');

            // Smart info
            modal.find('#smart-date').text(data.created_at ?? data.date ?? '-');
            modal.find('#smart-supplier').text(data.supplier ?? '-');
            modal.find('#smart-buy-cost').text(data.cost ? `$${parseFloat(data.cost).toFixed(2)}` : '$0');
            modal.find('#smart-net-cost').text(data.selling_price ? `$${parseFloat(data.selling_price).toFixed(2)}` : '$0');
            modal.find('#smart-roi').text(data.roi ? `${data.roi}%` : '0%');
            modal.find('#smart-bsr').text(data.bsr ?? '-');
            modal.find('#supplier-link').attr('href', data.source_url ?? '#');

            // Store ID for AJAX
            modal.data('item-id', data.id ?? '');

            // Update navigation buttons
            modal.find('#item-position').text(`${currentIndex + 1} of ${itemsData.length}`);
            modal.find('#prev-item').prop('disabled', currentIndex === 0);
            modal.find('#next-item').prop('disabled', currentIndex === itemsData.length - 1);
        }

        // -------------------------------
        // BULK EDIT LOGIC (main button)
        // -------------------------------
        $(document).on('click', '#openEditItems', function () {
            itemsData = table.rows({ page: 'current' }).data().toArray();
            if (itemsData.length > 0) {
                currentIndex = 0;
                populateModal(itemsData[currentIndex]);
                modal.modal('show');
            } else {
                toastr.warning('No items found in this order.');
            }
        });

        // ✅ Next / Prev buttons
        $(document).on('click', '#next-item', function () {
            if (currentIndex < itemsData.length - 1) {
                currentIndex++;
                populateModal(itemsData[currentIndex]);
            }
        });

        $(document).on('click', '#prev-item', function () {
            if (currentIndex > 0) {
                currentIndex--;
                populateModal(itemsData[currentIndex]);
            }
        });

        // -------------------------------
        // SINGLE ITEM EDIT (dropdown)
        // -------------------------------
        $(document).on('click', '.edit-smart-item', function (e) {
            e.preventDefault();

            const item = $(this).data();
            itemsData = [item]; // only one item
            currentIndex = 0;

            populateModal(item);
            modal.modal('show');
        });

        // -------------------------------
        // SAVE CHANGES (COMMON AJAX)
        // -------------------------------
        $(document).on('submit', '#edit-items-form', function (e) {
            e.preventDefault();

            const itemId = modal.data('item-id');
            if (!itemId) {
                toastr.error('No item selected.');
                return;
            }

            const formData = $(this).serializeArray();
            formData.push({ name: 'id', value: itemId });

            $.ajax({
                url: '{{ route("orders.updateItem") }}',
                method: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message ?? 'Item updated successfully');
                        modal.modal('hide');
                        table.ajax.reload(null, false);
                    } else {
                        toastr.error(response.message ?? 'Failed to update item');
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    toastr.error('Server error. Please try again.');
                }
            });
        });
    });

    // order item duplicate
    $(document).on('click', '.order-item-duplicate', function (e) {
        e.preventDefault();

        let id = $(this).data('id');

        $.ajax({
            url: "{{ route('order.items.duplicate', '') }}/" + id,
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (res) {
                toastr.success("Item duplicated");

                // ✅ Redraw DataTable without resetting pagination
                $('#order-items-table').DataTable().ajax.reload(null, false);
            },
            error: function (err) {
                toastr.error("Error duplicating item");
                console.error(err.responseText);
            }
        });
    });

    // order item delete
    $(document).on('click', '.delete-order-item', function (e) {
        e.preventDefault();

        let id = $(this).data('id');
        let buylist_id = $(this).data('buylist_id');

        Swal.fire({
            title: "Are you sure?",
            html: `
                Are you sure you want to delete this order item?<br><br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="moveToBuylist">
                    <label class="form-check-label" for="moveToBuylist">
                        Move item back to buylist?
                    </label>
                </div>
            `,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (!result.isConfirmed) return;

            let moveBack = $("#moveToBuylist").is(":checked");

            // ✅ If checked but buylist_id is missing → show error
            if (moveBack && (!buylist_id || buylist_id === "")) {
                Swal.fire({
                    icon: "error",
                    title: "Missing Buylist ID",
                    text: "This item has no buylist_id — cannot move to buylist."
                });
                return;
            }

            // ✅ AJAX request
            $.ajax({
                url: "{{ route('order.items.delete', '') }}/" + id,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    move_back: moveBack ? 1 : 0,
                },
                success: function (res) {
                    toastr.success(res.message);
                    $('#order-items-table').DataTable().ajax.reload(null, false);
                },
                error: function (err) {
                    toastr.error("Something went wrong");
                    console.log(err.responseText);
                }
            });
        });
    });

    // bulk delete items
    $(document).on('click', '.bulkDelBtn', function (e) {
        e.preventDefault();

        let selected = [];
        let missingBuylist = false;

        // ✅ collect IDs + detect missing buylist_id
        $('.item-checkbox:checked').each(function () {
            let id = $(this).data('id');
            let buylist_id = $(this).data('buylist_id');

            selected.push({ id, buylist_id });

            if (!buylist_id || buylist_id === "") {
                missingBuylist = true;
            }
        });

        if (selected.length === 0) {
            return toastr.warning("No items selected");
        }

        Swal.fire({
            title: `Delete ${selected.length} Items?`,
            html: `
                <div>Are you sure you want to delete selected ${selected.length} items?</div>
                <br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="bulkMoveToBuylist">
                    <label class="form-check-label" for="bulkMoveToBuylist">
                        Move items back to buylist?
                    </label>
                </div>
            `,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
        }).then((result) => {

            if (!result.isConfirmed) return;

            let moveBack = $("#bulkMoveToBuylist").is(":checked");

            // ✅ If moveBack checked BUT some rows have no buylist_id → STOP
            if (moveBack && missingBuylist) {
                Swal.fire({
                    icon: "error",
                    title: "Missing Buylist ID",
                    text: "Some selected items have no buylist_id — cannot move these items to buylist."
                });
                return;
            }

            // ✅ Send AJAX
            $.ajax({
                url: "{{ route('order.items.bulk.delete') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    items: selected,
                    move_back: moveBack ? 1 : 0
                },
                success: function (res) {
                    toastr.success(res.message);
                    $("#select-count-section").addClass("d-none");
                    $('#order-items-table').DataTable().ajax.reload(null, false);
                },
                error: function (err) {
                    toastr.error("Something went wrong");
                    console.log(err.responseText);
                }
            });

        });

    });

    $(document).ready(function () {

        // Select all
        $(document).on('change', '#selectAll', function () {
            const checked = $(this).is(':checked');
            $('#order-items-table tbody .item-checkbox').prop('checked', checked);
            updateSelectedCount();
        });

        // Single checkbox change
        $(document).on('change', '#order-items-table tbody .item-checkbox', function () {
            const allChecked =
                $('#order-items-table tbody .item-checkbox').length ===
                $('#order-items-table tbody .item-checkbox:checked').length;

            $('#selectAll').prop('checked', allChecked);
            updateSelectedCount();
        });

        // Update counter and bar
        function updateSelectedCount() {
            const count = $('#order-items-table tbody .item-checkbox:checked').length;
            $('#selectedCount').text(count);
            if (count > 0) {
                $('#select-count-section').removeClass('d-none');
            } else {
                $('#select-count-section').addClass('d-none');
            }
        }

        // Reset on table redraw
        $('#order-items-table').on('draw.dt', function () {
            $('#selectAll').prop('checked', false);
            updateSelectedCount();
        });
    });

    // order_id date and status update
    $(document).ready(function() {
        // Enable inline editing
        $('#edit-order').on('click', function() {
            var orderId = $('#order-id').text().trim();
            var orderDate = $('#order-date').text().trim();

            // Convert "mm/dd/yy" → "yyyy-mm-dd"
            var parts = orderDate.split('/');
            var month = parts[0].padStart(2, '0');
            var day = parts[1].padStart(2, '0');
            var year = '20' + parts[2]; // two-digit year to four-digit
            var formattedDate = `${year}-${month}-${day}`;

            // Replace display with editable inputs
            $('#order-info').html(`
                <h4 class="fs-18 fw-semibold m-0" style="white-space: nowrap;">
                    Order # <input type="text" id="edit-order-id" class="form-control d-inline-block w-auto ms-1" value="${orderId}">
                </h4>
                <p class="m-0 mt-2" style="white-space: nowrap;">
                    Order Date: <input type="date" id="edit-order-date" class="form-control d-inline-block w-auto ms-1" value="${formattedDate}">
                </p>
            `);

            $(this).hide();
            // $('#save-order-form').prop('disabled', false);
        });

        // Enable save button if any field changes
        $('#order-form').on('input change', 'input, select, textarea', function() {
            $('#save-order-form').prop('disabled', false);
        });

        // Handle Save button click
        $('#save-order-form').on('click', function(e) {
            e.preventDefault();

            // If user has edited inline
            let orderId = $('#edit-order-id').length ? $('#edit-order-id').val().trim() : $('#order-id').text().trim();
            let orderDate = $('#edit-order-date').length ? $('#edit-order-date').val().trim() : $('#order-date').text().trim();
            let status = $('select[name="status"]').val();

            $.ajax({
                url: "{{ route('orders.update', $order->id) }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: orderId,
                    date: orderDate,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);

                        // Revert editable fields to static view
                        let displayDate = new Date(orderDate).toLocaleDateString('en-US', {
                            month: '2-digit',
                            day: '2-digit',
                            year: '2-digit'
                        });

                        $('#order-info').html(`
                            <h4 class="fs-18 fw-semibold m-0">Order #<span id="order-id">${orderId}</span></h4>
                            <p class="m-0">Order Date: <span id="order-date">${displayDate}</span></p>
                        `);

                        $('#edit-order').show();
                        $('#save-order-form').prop('disabled', true);
                    }
                },
                error: function(xhr) {
                    toastr.error('Error updating order');
                }
            });
        });
    });

    // order detail info update
    $(document).ready(function() {
        let editing = false;

        $('#edit-order-info').on('click', function(e) {
            e.preventDefault();
            editing = !editing;

            if (editing) {
                // Switch to edit mode
                $('#edit-icon-order-info').removeClass('ti-pencil').addClass('ti-check');
                $('#edit-text-order-info').hide();

                // Convert text spans to editable inputs
                const sourceText = $('#source-field').text().trim();
                const emailText = $('#email-field').text().trim();
                const destinationText = $('#destination-field').text().trim();

                $('#source-field').html(`<input id="source-field-input" type="text" class="form-control" value="${sourceText}">`);
                $('#email-field').html(`<input id="email-field-input" type="email" class="form-control" value="${emailText}">`);
                $('#destination-field').html(`<input id="destination-field-input" type="text" class="form-control" value="${destinationText}">`);

            } else {
                // Switch back from edit mode (save changes)
                $('#edit-icon-order-info').removeClass('ti-check').addClass('ti-pencil');
                $('#edit-text-order-info').show();

                // Get input values
                const sourceVal = $('#source-field-input').val();
                const emailVal = $('#email-field-input').val();
                const destinationVal = $('#destination-field-input').val();

                // Send AJAX request to update the order info
                $.ajax({
                    url: "{{ route('orders.updateInfo', $order->id) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        source: sourceVal,
                        email: emailVal,
                        destination: destinationVal
                    },
                    beforeSend: function() {
                        // Optional: show loader or disable edit button
                        $('#edit-order-info').addClass('disabled');
                    },
                    success: function(response) {
                        $('#edit-order-info').removeClass('disabled');

                        if (response.success) {
                            toastr.success(response.message);

                            // ✅ Update the text display
                            let finalSource = sourceVal.trim();
                            let sourceUrl = finalSource;

                            // Ensure link has http/https prefix
                            if (sourceUrl && !/^https?:\/\//i.test(sourceUrl)) {
                                sourceUrl = 'https://' + sourceUrl;
                            }

                            // Rebuild the clickable link with icon
                            $('#source-field').html(`
                                <a href="${sourceUrl}" target="_blank" class="text-primary text-decoration-none">
                                    ${finalSource}
                                    <i class="ti ti-external-link text-primary fs-5 align-middle"></i>
                                </a>
                            `);
                            $('#email-field').html(emailVal);
                            $('#destination-field').html(destinationVal);
                        } else {
                            toastr.error(response.message || 'Failed to update order info.');
                        }
                    },
                    error: function(xhr) {
                        $('#edit-order-info').removeClass('disabled');
                        toastr.error('Failed to update order info.');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

    // payment details update
    $(document).ready(function() {
        let editingPayment = false;

        $('#edit-payment-info').on('click', function(e) {
            e.preventDefault();
            editingPayment = !editingPayment;

            if (editingPayment) {
                // Switch to edit mode
                $('#edit-icon-payment-info').removeClass('ti-pencil').addClass('ti-check');
                $('#edit-text-payment-info').hide();

                // Convert spans to inputs
                const cardUsed = $('#card-used-field').text().trim();
                const amountCharged = $('#amount-charged-field').text().replace('$', '').trim();
                const cashBackSource = $('#cash-back-source-field').text().trim();
                const cashBackPercentage = $('#cash-back-percentage-field').text().replace('%', '').trim();

                $('#card-used-field').html(`<input id="card-used-input" type="text" class="form-control form-control-sm" value="${cardUsed}">`);
                $('#amount-charged-field').html(`<input id="amount-charged-input" type="number" step="0.01" class="form-control form-control-sm" value="${amountCharged}">`);
                $('#cash-back-source-field').html(`<input id="cash-back-source-input" type="text" class="form-control form-control-sm" value="${cashBackSource}">`);
                $('#cash-back-percentage-field').html(`<input id="cash-back-percentage-input" type="number" step="0.01" class="form-control form-control-sm" value="${cashBackPercentage}">`);

            } else {
                // Switch back to display mode
                $('#edit-icon-payment-info').removeClass('ti-check').addClass('ti-pencil');
                $('#edit-text-payment-info').show();

                // Collect updated values
                const cardUsedVal = $('#card-used-input').val();
                const amountChargedVal = $('#amount-charged-input').val();
                const cashBackSourceVal = $('#cash-back-source-input').val();
                const cashBackPercentageVal = $('#cash-back-percentage-input').val();

                // Send AJAX update request
                $.ajax({
                    url: "{{ route('orders.updatePayment', $order->id) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        card_used: cardUsedVal,
                        total: amountChargedVal,
                        cash_back_source: cashBackSourceVal,
                        cash_back_percentage: cashBackPercentageVal
                    },
                    beforeSend: function() {
                        $('#edit-payment-info').addClass('disabled');
                    },
                    success: function(response) {
                        $('#edit-payment-info').removeClass('disabled');

                        if (response.success) {
                            toastr.success(response.message);

                            // Update the visible fields
                            $('#card-used-field').text(cardUsedVal);
                            $('#amount-charged-field').text(`$${parseFloat(amountChargedVal).toFixed(2)}`);
                            $('#cash-back-source-field').text(cashBackSourceVal);
                            $('#cash-back-percentage-field').text(`${parseFloat(cashBackPercentageVal).toFixed(2)}%`);
                        } else {
                            toastr.error(response.message || 'Failed to update payment info.');
                        }
                    },
                    error: function(xhr) {
                        $('#edit-payment-info').removeClass('disabled');
                        toastr.error('Failed to update payment info.');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        // Click to edit note
        $('.note-card').on('click', function() {
            const card = $(this).closest('.card');

            // Hide note text and show textarea
            card.find('.note-text').hide();
            card.find('textarea').show().focus();

            // Show check icon
            card.find('.check-icon').show();
        });

        // Click to save note
        $('.check-icon').on('click', function(e) {
            e.preventDefault();

            const card = $(this).closest('.card');
            const textarea = card.find('textarea');
            const noteText = card.find('.note-text');
            const noteValue = textarea.val();

            // Optional: disable icon while saving
            const icon = $(this).find('i');
            icon.removeClass('ti-check').addClass('ti-loader ti-spin');

            // Send AJAX update request
            $.ajax({
                url: "{{ route('orders.updateNote', $order->id) }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    note: noteValue
                },
                success: function(response) {
                    icon.removeClass('ti-loader ti-spin').addClass('ti-check');

                    if (response.success) {
                        toastr.success(response.message);

                        // Update visible note text
                        noteText.text(noteValue);
                    } else {
                        toastr.error(response.message || 'Failed to update note.');
                    }

                    // Hide textarea and check icon
                    textarea.hide();
                    noteText.show();
                    card.find('.check-icon').hide();
                },
                error: function(xhr) {
                    icon.removeClass('ti-loader ti-spin').addClass('ti-check');
                    toastr.error('Failed to update note.');
                    console.error(xhr.responseText);
                }
            });
        });
    });

    $(document).ready(function () {
        function updateSelectColor($select) {
            let status = $select.val();

            let colors = {
                'partially received': 'warning',
                'received in full': 'success',
                'ordered': 'primary',
                'draft': 'secondary',
                'closed': 'info',
                'canceled': 'danger',
                'reconcile': 'dark',
                'breakage': 'light'
            };

            // Remove old Bootstrap color classes
            $.each(colors, function (key, color) {
                $select.removeClass('bg-soft-' + color + ' text-' + color);
            });

            // Add new color class
            let newColor = colors[status] || 'secondary';
            $select.addClass('bg-soft-' + newColor + ' text-' + newColor);
        }

        // Run on change
        $(document).on('change', '.status-select', function () {
            updateSelectColor($(this));
        });

        // ✅ Run once on page load for all selects
        $('.status-select').each(function () {
            updateSelectColor($(this));
        });
    });

    $(document).ready(function () {
        function showSection(type) {
            $("#section-listing, #section-replacement, #section-refund, #section-never")
                .addClass("d-none");

            if (type === "listing") $("#section-listing").removeClass("d-none");
            if (type === "replace") $("#section-replacement").removeClass("d-none");
            if (type === "return") $("#section-refund").removeClass("d-none");
            if (type === "received") $("#section-never").removeClass("d-none");
        }
        // Load default
        showSection($("#eventType").val());
        // When select changes
        $("#eventType").on("change", function () {
            showSection($(this).val());
        });
    });

    // Check All
    $('#qcAll').on('change', function () {
        $('.qc-option').prop('checked', $(this).is(':checked'));
        updateQcStatus();
    });

    // Individual options
    $('.qc-option').on('change', function () {

        // If all selected → Check All = checked
        if ($('.qc-option:checked').length === $('.qc-option').length) {
            $('#qcAll').prop('checked', true);
        } else {
            $('#qcAll').prop('checked', false);
        }

        updateQcStatus();
    });

    // Update button color only
    function updateQcStatus() {
        let selected = $('.qc-option:checked').length;
        let total = $('.qc-option').length;

        // Text always same
        $('#qcCheckText').text('Options');

        // If ALL selected → green button
        if (selected === total && total > 0) {
            qcButtonSuccess();
        }
        // Not all selected → default button
        else {
            qcButtonDefault();
        }
    }

    function qcButtonSuccess() {
        $('.qc-btn').removeClass('btn-light').addClass('btn-success text-white');
    }

    function qcButtonDefault() {
        $('.qc-btn').removeClass('btn-success text-white').addClass('btn-light');
    }

    $(document).on('click', '.create-event-btn', function () {
        let orderId = $(this).data('order-id');
        let itemId  = $(this).data('order-item-id');

        let minPrice  = $(this).data('min');
        let maxPrice  = $(this).data('max');
        let listPrice  = $(this).data('list-price');

        $("#order_id").val(orderId);
        $("#order_item_id").val(itemId);

        $('#list_price').val(listPrice);
        $('#max_list_price').val(maxPrice);
        $('#min_list_price').val(minPrice);
    });

    $('#createEventForm').on('submit', function (e) {
        e.preventDefault();

        let eventType = $('#eventType').val();

        // 1️⃣ Disable all inputs first
        $('#section-listing :input').prop('disabled', true);
        $('#section-replacement :input').prop('disabled', true);
        $('#section-refund :input').prop('disabled', true);
        $('#section-never :input').prop('disabled', true);

        // 2️⃣ Enable only the active section inputs
        if (eventType === 'listing') {
            $('#section-listing :input').prop('disabled', false);
        } else if (eventType === 'replace') {
            $('#section-replacement :input').prop('disabled', false);
        } else if (eventType === 'return') {
            $('#section-refund :input').prop('disabled', false);
        } else if (eventType === 'received') {
            $('#section-never :input').prop('disabled', false);
        }

        // 3️⃣ Now serialize – this will include ONLY enabled inputs
        let formData = $('#createEventForm').serialize();
        formData += '&_token={{ csrf_token() }}';

        // 4️⃣ Select correct route
        let url =
            eventType === 'listing'
                ? "{{ route('ship-events.store') }}"
                : "{{ route('event-logs.store') }}";

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function (response) {
                $('#createEventModal').modal('hide');
                // $('#order-items-table').DataTable().ajax.reload();
                $('#event-table').DataTable().ajax.reload(null, false);

                // Reset form
                $('#createEventForm')[0].reset();

                // Reset QC button
                $('#qcCheckText').text("Options");
                $('.qc-btn').removeClass("btn-success text-white").addClass("btn-light");

                // ✅ Re-enable ALL inputs again
                $('#section-listing :input').prop('disabled', false);
                $('#section-replacement :input').prop('disabled', false);
                $('#section-refund :input').prop('disabled', false);
                $('#section-never :input').prop('disabled', false);

                toastr.success("Event created successfully");
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    });

    $('#event-table').DataTable({
        ajax: {
            url: "{{ route('orders.events', $order->id) }}",
            type: "GET"
        },
        paging: false,
        searching: false,
        info: false,
        ordering: false,
        lengthChange: false,

        columns: [
            {
                data: 'type',
                render: function(type) {
                    if (!type) return '-';
                    let label = type.charAt(0).toUpperCase() + type.slice(1);

                    let badgeClass = 'badge-soft-secondary';
                    if (type === 'listing') badgeClass = 'badge-soft-success';
                    else if (type === 'Event Log') badgeClass = 'badge-soft-warning text-dark';
                    else badgeClass = 'badge-soft-danger';

                    return `<span class="badge ${badgeClass} p-1">${label}</span>`;
                }
            },
            { 
                data: 'asin',
                render: d => d ?? '-'
            },

            { 
                data: 'qty',
                render: d => d ?? '-'
            },

            // ✅ CREATED AT — m/d/y
            {
                data: 'created_at',
                render: function(d){
                    if (!d) return '-';
                    let date = new Date(d);
                    const m = String(date.getMonth() + 1).padStart(2, '0');
                    const t = String(date.getDate()).padStart(2, '0');
                    const y = String(date.getFullYear()).slice(-2);
                    return `${m}/${t}/${y}`;
                }
            },

            // ✅ UPDATED AT — m/d/y
            {
                data: 'updated_at',
                render: function(d){
                    if (!d) return '-';
                    let date = new Date(d);
                    const m = String(date.getMonth() + 1).padStart(2, '0');
                    const t = String(date.getDate()).padStart(2, '0');
                    const y = String(date.getFullYear()).slice(-2);
                    return `${m}/${t}/${y}`;
                }
            },

            {
                data: null,
                render: function (data, type, row) {
                    return `<div class="dropdown">
                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item edit-event-btn" href="#" 
                                        data-id="${row.id}" 
                                        data-type="${row.type ?? 'listing'}">Edit</a></li>
                                    <li><a class="dropdown-item event-delete-btn" href="#" 
                                        data-id="${row.id}" 
                                        data-source="${row.source}">Delete</a></li>
                                </ul>
                            </div>`;
                }

            }
        ]
    });

    $(document).on('click', '.event-delete-btn', function (e) {
        e.preventDefault();

        let id = $(this).data('id');
        let source = $(this).data('source');

        let url = source === "ship_event"
            ? "{{ url('/ship-event') }}/" + id
            : "{{ url('/event-log') }}/" + id;

        Swal.fire({
            title: "Are you sure?",
            text: "This event will be permanently deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it"
        }).then((result) => {

            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },

                    success: function () {
                        $('#event-table').DataTable().ajax.reload();
                        Swal.fire("Deleted!", "Event deleted successfully.", "success");
                    }
                });
            }
        });
    });

    $(document).on('click', '.mark-fixed', function (e) {
        e.preventDefault();

        let orderId = $(this).data('id');

        $.ajax({
            url: "{{ route('orders.markFixed') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                order_id: orderId
            },
            success: function (res) {
                toastr.success("Order marked as Received In Full");
                location.reload();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    });

    let eventsOpen = false;
    $('#toggleShipping').on('click', function () {

        if (!eventsOpen) {
            loadEventsFromServer();
            $(this).html(`Hide Events <i class="ti ti-eye-off"></i>`);
            eventsOpen = true;

        } else {
            collapseAllEvents();
            $(this).html(`Show Events <i class="ti ti-eye"></i>`);
            eventsOpen = false;
        }
    });

    function loadEventsFromServer() {
        let orderId = $('#order-items-table').data('order-id');
        $.ajax({
            url: `/orders/items/${orderId}/events`,
            type: "GET",
            success: function (res) {
                // console.log(res);
                expandAllRows(res.listing, res.errors);
            }
        });
    }

    function expandAllRows(listing, errors) {
        $('#order-items-table tbody tr').each(function () {
            let itemId = $(this).data('item-id');

            // Skip if already expanded
            if ($(this).next().hasClass('event-expanded')) return;

            // Filter events by item_id
            let listingEvents = listing ? listing.filter(ev => ev.order_item_id == itemId) : [];
            let errorEvents   = errors  ? errors.filter(ev => ev.order_item_id == itemId)  : [];

            let expandHtml = `
                <tr class="event-expanded">
                    <td colspan="32" class="px-1 py-1">

                        <h6 class="fw-bold text-primary mb-2">Listing Events</h6>
                        ${buildListingTable(listingEvents)}

                        <h6 class="fw-bold text-danger mt-4 mb-2">Error Events</h6>
                        ${buildErrorTable(errorEvents)}

                    </td>
                </tr>
            `;

            $(this).after(expandHtml);
        });

        initDropdowns();
    }

    function initDropdowns() {
        document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(el => {
            new bootstrap.Dropdown(el);
        });
    }

    function collapseAllEvents() {
        $('.event-expanded').remove();
    }

    function buildListingTable(events) {
        if (!events.length) return `<p class="text-muted">No Listing Events</p>`;

        let rows = events.map(ev => {
            // Determine QC status
            let qcPass = ev.title_matches_flag && ev.image_matches_flag && ev.description_matches_flag && ev.upc_matches_flag;
            let qcBadge = qcPass 
                ? '<span class="badge badge-soft-success p-1">Pass</span>' 
                : '<span class="badge badge-soft-danger p-1">Fail</span>';

            return `
                <tr>
                    <td>ship to fba</td>
                    <td>${ev.shippingbatch?.name ?? '-'}</td>
                    <td>${ev.items ?? '-'}</td>
                    <td>${qcBadge}</td>
                    <td>${ev.order_date ?? '-'}</td>
                    <td>${ev.asin_override ?? '-'}</td>
                    <td>${ev.product_name_override ?? '-'}</td>
                    <td>${ev.condition ?? '-'}</td>
                    <td>${ev.product_upc ?? '-'}</td>
                    <td>${ev.msku_orderride ?? '-'}</td>
                    <td>${ev.shipping_notes ?? '-'}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="#" 
                                    class="dropdown-item">
                                        View
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item edit-event-btn" 
                                    data-id="${ev.id}" 
                                    data-type="listing">
                                    Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger"
                                    href="#">
                                    Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');

        return `
            <table class="table table-bordered table-sm mb-3">
                <thead class="table-light">
                    <tr>
                        <th>Type</th>
                        <th>Shipping Batch</th>
                        <th>Shipped</th>
                        <th>QC</th>
                        <th>Order Date</th>
                        <th>ASIN Override</th>
                        <th>Title Override</th>
                        <th>Condition</th>
                        <th>UPC</th>
                        <th>MSKU</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>${rows}</tbody>
            </table>
        `;
    }

    function buildErrorTable(events) {

        if (!events.length) return `<p class="text-muted">No Error Events</p>`;

        let rows = events.map(ev => `
            <tr>
                <td>${ev.issue_type ?? '-'}</td>
                <td>${ev.item_quantity ?? '-'}</td>
                <td>${ev.tracking_number ?? '-'}</td>
                <td>${ev.refund_expected ?? '-'}</td>
                <td>${ev.refund_actual ?? '-'}</td>
                <td>${checkbox(ev.refunded)}</td>
                <td>${checkbox(ev.cc_charged)}</td>
                <td>${checkbox(ev.cancelled)}</td>
                <td>${ev.supplier_notes ?? '-'}</td>
                <td>${ev.issue_notes ?? '-'}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="#" 
                                class="dropdown-item">
                                    View
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item edit-event-btn" 
                                data-id="${ev.id}" 
                                data-type="${ev.issue_type}">
                                Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger"
                                href="#">
                                Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        `).join('');

        return `
            <table class="table table-bordered table-sm mb-3">
                <thead class="table-light">
                    <tr>
                        <th>Issue Type</th>
                        <th>Qty</th>
                        <th>Tracking</th>
                        <th>Expected Refund</th>
                        <th>Actual Refund</th>
                        <th>Refunded</th>
                        <th>CC Charged</th>
                        <th>Cancelled</th>
                        <th>Supplier Notes</th>
                        <th>Issuer Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>${rows}</tbody>
            </table>
        `;
    }

    // Handle eye icon click per row
    $(document).on('click', '.btn-event-item', function(e) {
        e.preventDefault();

        let $btn = $(this);
        let $row = $btn.closest('tr');                     // row of the clicked eye icon
        let orderId = $btn.data('order-id');              // get order id
        let itemId  = $btn.data('order-item-id');         // get item id

        // If events already expanded, collapse them
        if ($row.next().hasClass('event-expanded')) {
            $row.next().remove();                          // remove expanded row
            $btn.html('<i class="ti ti-eye"></i>');        // reset icon
            return;
        }

        // Fetch events for this item only
        $.ajax({
            url: `/orders/items/${orderId}/events`,
            type: "GET",
            success: function(res) {
                // Filter events for this item
                let listingEvents = res.listing ? res.listing.filter(ev => ev.order_item_id == itemId) : [];
                let errorEvents   = res.errors  ? res.errors.filter(ev => ev.order_item_id == itemId)  : [];

                // Build HTML
                let expandHtml = `
                    <tr class="event-expanded">
                        <td colspan="32" class="px-1 py-1">
                            <h6 class="fw-bold text-primary mb-2">Listing Events</h6>
                            ${buildListingTable(listingEvents)}
                            <h6 class="fw-bold text-danger mt-4 mb-2">Error Events</h6>
                            ${buildErrorTable(errorEvents)}
                        </td>
                    </tr>
                `;

                $row.after(expandHtml);
                initDropdowns();

                // Change icon to hide
                $btn.html('<i class="ti ti-eye-off"></i>');
            }
        });
    });

    function formatDate(d) {
        if (!d) return '-';
        let dt = new Date(d);
        return `${dt.getMonth()+1}/${dt.getDate()}/${dt.getFullYear()}`;
    }

    function checkbox(val) {
        return `<input type="checkbox" disabled ${val ? 'checked' : ''}>`;
    }

    $(document).on("click", ".edit-event-btn", function () {
        let eventId = $(this).data("id");
        let eventType = $(this).data("type");

        // Reset form
        $("#EditEventForm").trigger("reset");


        // Hide all sections first
        $("#edit-section-listing, #edit-section-replacement, #edit-section-refund, #edit-section-never").addClass("d-none");

        // Show the correct section only
        if (eventType === "listing") $("#edit-section-listing").removeClass("d-none");
        if (eventType === "replace") $("#edit-section-replacement").removeClass("d-none");
        if (eventType === "return") $("#edit-section-refund").removeClass("d-none");
        if (eventType === "received") $("#edit-section-never").removeClass("d-none");

        // Load event details from backend
        $.ajax({
            url: "/events/get/" + eventType + "/" + eventId,
            method: "GET",
            success: function (res) {

                let type = res.type;
                let ev = res.data;

                // Fill common fields
                $("#order_id").val(ev.order_id);
                $("#order_item_id").val(ev.order_item_id);
                $("#edit_event_id").val(eventId);
                $("#edit_event_type").val(type);

                // ✅ LISTING
                if (type === "listing") {

                    $("#edit_shipping_batch").val(ev.shipping_batch);
                    $("#edit_items").val(ev.items);
                    $("#edit_expire_date").val(ev.expire_date);
                    $("#edit_product_upc").val(ev.product_upc);
                    $("#edit_msku").val(ev.msku_orderride);
                    $("#edit_list_price").val(ev.list_price_orverride);
                    $("#edit_min_list_price").val(ev.min_orverride);
                    $("#edit_max_list_price").val(ev.max_orverride);
                    $("#edit_shipping_notes").val(ev.shipping_notes);

                    // QC CHECKBOXES
                    $(".edit-qc-option").prop("checked", false);
                    if (ev.upc_matches_flag)
                        $("input.edit-qc-option[value='upc_matches']").prop("checked", true);
                    if (ev.title_matches_flag)
                        $("input.edit-qc-option[value='title_matches']").prop("checked", true);
                    if (ev.image_matches_flag)
                        $("input.edit-qc-option[value='image_matches']").prop("checked", true);
                    if (ev.description_matches_flag)
                        $("input.edit-qc-option[value='description_matches']").prop("checked", true);

                    setTimeout(() => {
                        // Update Check All & button color
                        $('#edit_qcAll').prop(
                            $('.edit-qc-option:checked').length === $('.edit-qc-option').length
                        );

                        updateEditQcStatus();
                    }, 50);

                }

                if (type === "replace") {
                    $("#edit_item_quantity_replace").val(ev.item_quantity);
                    $("#edit_tracking_number_replace").val(ev.tracking_number);
                    $("#edit_supplier_notes_replace").val(ev.supplier_notes);
                    $("#edit_issue_notes_replace").val(ev.issue_notes);
                    $("#edit_received_replace").prop("checked", ev.received == 1);
                }

                if (type === "return") {
                    $("#edit_item_quantity_return").val(ev.item_quantity);
                    $("#edit_refund_expected_return").val(ev.refund_expected);
                    $("#edit_refund_actual_return").val(ev.refund_actual);
                    $("#edit_tracking_number_return").val(ev.tracking_number);
                    $("#edit_supplier_notes_return").val(ev.supplier_notes);
                    $("#edit_issue_notes_return").val(ev.issue_notes);
                    $("#edit_refunded_return").prop("checked", ev.refunded == 1);
                }

                if (type === "received") {
                    $("#edit_item_quantity_received").val(ev.item_quantity);
                    $("#edit_refund_expected_received").val(ev.refund_expected);
                    $("#edit_refund_actual_received").val(ev.refund_actual);
                    $("#edit_tracking_number_received").val(ev.tracking_number);
                    $("#edit_supplier_notes_received").val(ev.supplier_notes);
                    $("#edit_issue_notes_received").val(ev.issue_notes);
                    $("#edit_cancelled_received").prop("checked", ev.cancelled == 1);
                    $("#edit_cc_charged_received").prop("checked", ev.cc_charged == 1);
                    $("#edit_refunded_received").prop("checked", ev.refunded == 1);
                }

                // ✅ FINALLY OPEN MODAL
                $("#EditEventModal").modal("show");
            }
        });
    });

    // Check All
    $('#edit_qcAll').on('change', function () {
        $('.edit-qc-option').prop('checked', $(this).is(':checked'));
        updateEditQcStatus();
    });

    // Individual items
    $('.edit-qc-option').on('change', function () {
        if ($('.edit-qc-option:checked').length === $('.edit-qc-option').length) {
            $('#edit_qcAll').prop('checked', true);
        } else {
            $('#edit_qcAll').prop('checked', false);
        }

        updateEditQcStatus();
    });

    // Update only button color
    function updateEditQcStatus() {
        let selected = $('.edit-qc-option:checked').length;
        let total = $('.edit-qc-option').length;

        // Update text
        $('#editQcCheckText').text('Options');

        // All selected → success
        if (selected === total && total > 0) {
            editQcButtonSuccess();
        } else {
            editQcButtonDefault();
        }
    }

    function editQcButtonSuccess() {
        $('.edit-qc-btn')
            .removeClass('btn-light')
            .addClass('btn-success text-white');
    }

    function editQcButtonDefault() {
        $('.edit-qc-btn')
            .removeClass('btn-success text-white')
            .addClass('btn-light');
    }

    $("#EditEventForm").submit(function(e){
        e.preventDefault();

        let eventId = $("#edit_event_id").val(); // 🚨 You must set hidden input in modal
        let formData = $(this).serialize();

        $.ajax({
            url: "/events/update/" + eventId,
            method: "POST",
            data: formData,
            success: function(res) {
                if(res.success){
                    $("#EditEventModal").modal("hide");
                    toastr.success("Event Updated!");
                    loadTable(); // ✅ refresh listing
                }
            }
        });
    });
</script>
@endsection