@extends('layouts.app')

@section('title', 'Buy Cost Calculator')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Buy Cost Calculator</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                    <form action="javascript:void(0);">
                        <div class="row g-2 mb-0 align-items-center">
                            <div class="col-auto">
                                <button class="btn btn-primary">
                                    Save & Go To Order
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row card">
                <div class="col-md-12 card-body">
                    <div class="row g-3">
                        <div class="col-sm-6 col-md">
                        <label for="order_id" class="form-label fw-semibold">Order ID</label>
                        <input type="text" class="form-control" id="order_id" name="order_id" value="{{ $order->order_id }}" autocomplete="off">
                        </div>

                        <div class="col-sm-6 col-md">
                        <label for="source" class="form-label fw-semibold">Source</label>
                        <input type="text" class="form-control" id="source" name="source" value="{{ $order->source }}" autocomplete="source">
                        </div>

                        <div class="col-sm-6 col-md">
                        <label for="destination" class="form-label fw-semibold">Destination</label>
                        <input type="text" class="form-control" id="destination" name="destination" value="{{ $order->destination }}" autocomplete="destination">
                        </div>

                        <div class="col-sm-6 col-md">
                        <label for="email_used" class="form-label fw-semibold">Email Used</label>
                        <input type="text" class="form-control" id="email_used" name="email_used" value="{{ $order->email }}" autocomplete="email_used">
                        </div>

                        <div class="col-sm-6 col-md">
                        <label for="calculator_type" class="form-label fw-semibold">Calculator Type</label>
                        <select class="form-select" id="calculator_type" name="calculator_type" autocomplete="calculator_type">
                            <option value="SKU Total">SKU Total</option>
                            <option value="Cost Per Unit">Cost Per Unit</option>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                            <th scope="col">ASIN</th>
                            <th scope="col">Image</th>
                            <th scope="col">Product Title</th>
                            <th scope="col">Variation Details</th>
                            <th scope="col" class="text-center">Tax Exempt</th>
                            <th scope="col"># of Units</th>
                            <th scope="col">Cost Per Unit ($)</th>
                            <th scope="col">SKU Total ($)</th>
                            <th scope="col" class="bg-success-subtle">Cost Per Unit<br>Calculated</th>
                            <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->LineItems as $item)
                                <tr>
                                    <td>{{ $item->asin }}</td>
                                    <td>
                                        <img src="https://app.sourceflow.io/storage/images/no-image-thumbnail.png" alt="Product Image" class="img-fluid rounded" width="50">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>---</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <input type="checkbox" class="form-check">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" value="{{ $item->unit_purchased }}">
                                    </td>
                                    <td>${{ $item->buy_cost }}</td>
                                    <td>${{ $item->sku_total }}</td>
                                    <td>$</td>
                                    <td class="text-center">
                                        <i class="ti ti-trash text-danger fs-3"></i>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-2 card bg-light">
                    <div class="card-header border-bottom">
                        <h4 class="card-title fw-bold">Order Totals</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="mb-1 mt-2">
                            <label for="pre_tax_discount" class="form-label">Pre-Tax Discount</label>
                            <input type="text" class="form-control" id="pre_tax_discount" name="pre_tax_discount" value="{{ $order->pre_tax_discount }}" autocomplete="pre_tax_discount">
                        </div>

                        <div class="mb-1">
                            <label for="post_tax_discount" class="form-label">Post-Tax Discount</label>
                            <input type="text" class="form-control" id="post_tax_discount" name="post_tax_discount" value="{{ $order->post_tax_discount }}" autocomplete="post_tax_discount">
                        </div>

                        <div class="mb-1">
                            <label for="shipping_total" class="form-label">Shipping Cost</label>
                            <input type="text" class="form-control" value="{{ $order->shipping_cost }}" id="shipping_total" name="shipping_total" autocomplete="shipping_total">
                        </div>

                        <div class="mb-1">
                            <label for="tax_paid" class="form-label">Sales Tax</label>
                            <input type="text" class="form-control" value="{{ $order->sales_tax }}" id="tax_paid" name="tax_paid" autocomplete="tax_paid">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label for="sales_tax_shipping" class="form-label mb-0">Sales Tax Paid on Shipping</label>
                            <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="sales_tax_shipping" @if($order->is_sale_tax_shipping == 1) checked @endif>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Sales Tax Rate</span>
                            <span class="fw-semibold">{{ $order->sales_tax_rate }}%</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal (Pre-Tax)</span>
                            <span class="fw-semibold">${{ $order->subtotal }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">Grand Total</span>
                            <span class="fw-bold text-dark">${{ $order->total }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md-10">
                    <div class="row g-2">
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
                                    <h5 class="mb-0">Payment Source</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <!-- Card Used -->
                                        <div class="col-md-6">
                                            <label for="card_used" class="form-label fw-semibold">Card Used</label>
                                            <input type="text" class="form-control" id="card_used" name="card_used" value="{{ $order->card_used }}" autocomplete="card_used">
                                        </div>

                                        <!-- Amount Charged -->
                                        <div class="col-md-6">
                                            <label for="amount_charged" class="form-label fw-semibold">Amount Charged</label>
                                            <input type="number" class="form-control" id="amount_charged" name="amount_charged" value="{{ $order->subtotal }}" autocomplete="off">
                                        </div>

                                        <!-- Cash Back Source -->
                                        <div class="col-md-6">
                                            <label for="cash_back_source" class="form-label fw-semibold">Cash Back Source</label>
                                            <input type="text" class="form-control" id="cash_back_source" name="cash_back_source" value="{{ $order->cash_back_source }}" autocomplete="cash_back_source">
                                        </div>

                                        <!-- Cash Back % -->
                                        @php
                                            $cash_back_amount = $order->cash_back_percentage / 100 * $order->subtotal;
                                            $without_shipping_cash_back_amount = $order->subtotal - $order->shipping_cost;
                                            $without_shipping_cash_back_amount = $order->cash_back_percentage / 100 * $without_shipping_cash_back_amount;
                                        @endphp

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label for="cash_percentage" class="form-label fw-semibold mb-0">
                                                    Cash Back %
                                                    <small class="text-muted">
                                                        (<span id="cash_with_shipping">${{ number_format($cash_back_amount, 2) }}</span>)
                                                    </small>
                                                </label>

                                                <!-- Info icon with dynamic tooltip -->
                                                <i class="ti ti-info-circle text-muted"
                                                id="tooltipInfo"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="${{ number_format($without_shipping_cash_back_amount, 2) }} based on Sub Total without tax and shipping"
                                                style="cursor: pointer;">
                                                </i>
                                            </div>

                                            <input type="number" step=".01"
                                                value="{{ $order->cash_back_percentage }}"
                                                class="form-control mt-1"
                                                id="cash_percentage"
                                                name="cash_percentage"
                                                autocomplete="off">

                                            <!-- Hidden values -->
                                            <input type="hidden" id="subtotal" value="{{ $order->subtotal }}">
                                            <input type="hidden" id="shipping_cost" value="{{ $order->shipping_cost }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header border-bottom">
                                    <h5 class="mb-0">Order Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        <!-- Created -->
                                        <div class="col-md-6">
                                            <label for="created" class="form-label fw-semibold">Created</label>
                                            <div class="fw-bold text-muted">{{ $order->created_at->format('m/d/y') }}</div>
                                        </div>

                                        <!-- Date Ordered -->
                                        <div class="col-md-6">
                                            <label for="date_ordered" class="form-label fw-semibold">Date Ordered</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="fw-bold text-muted d-flex align-items-center justify-content-between w-100" style="max-width:180px;">
                                                <span id="displayDate">{{ \Carbon\Carbon::parse($order->date)->format('m/d/y') }}</span>
                                                <input type="date" id="editDate" class="form-control form-control-sm d-none" style="max-width:150px;">
                                                <i class="ti ti-edit text-muted ms-2" id="editIcon" style="font-size: 14px; cursor: pointer;"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Last Updated -->
                                        <div class="col-md-6">
                                            <label for="last_updated" class="form-label fw-semibold">Last Updated</label>
                                            <div class="fw-bold text-muted">{{ $order->updated_at->format('m/d/y') }}</div>
                                        </div>

                                        <!-- Order Status -->
                                        <div class="col-md-6">
                                            <label for="order_status" class="form-label fw-semibold">Order Status</label>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between border-bottom">
                                    <h5 class="mb-0">Gift Card Used</h5>
                                    <a href="#" class="text-decoration-none">
                                        <i class="ti ti-gift"></i> Add Gift Card
                                    </a>
                                </div>
                                <div class="card-body">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="card-title mb-0 fw-bold text-dark">Attachments</h5>
                            <button class="btn btn-link text-primary d-flex align-items-center p-0"
                                    data-bs-toggle="modal" data-bs-target="#addAttachmentModal">
                                <i class="ti ti-upload me-1"></i>
                                Upload
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <p class="fw-medium mb-1 text-secondary">No attachments available.</p>
                                <p class="text-muted small mb-0">Please upload a file to see it here.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.order.order-detail.buy-cost-calculator.add-attachment')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.note-card').on('click', function() {
            $(this).find('.note-text').hide();
            $(this).find('textarea').show().focus();

            $(this).closest('.card').find('.check-icon').show();
        });

        $('.check-icon').on('click', function(e) {
            e.preventDefault();
            var card = $(this).closest('.card');
            var textarea = card.find('textarea');
            var noteText = card.find('.note-text');

            noteText.text(textarea.val());
            textarea.hide();
            noteText.show();

            $(this).hide();
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
        $('#editIcon').on('click', function () {
            let currentDate = `{{ \Carbon\Carbon::parse($order->date)->format('Y-m-d') }}`; // Format for <input type="date">
            
            // Set value and toggle visibility
            $('#editDate').val(currentDate).removeClass('d-none').focus();
            $('#displayDate').addClass('d-none');
            $(this).addClass('d-none');
        });

        // When user changes or leaves input
        $('#editDate').on('change blur', function () {
            let newDate = $(this).val();
            if (newDate) {
                let formatted = new Date(newDate);
                let month = (formatted.getMonth() + 1).toString().padStart(2, '0');
                let day = formatted.getDate().toString().padStart(2, '0');
                let year = formatted.getFullYear().toString().slice(-2);
                $('#displayDate').text(`${month}/${day}/${year}`);
            }
            $('#displayDate').removeClass('d-none');
            $('#editIcon').removeClass('d-none');
            $(this).addClass('d-none');
        });
    });

    $(document).ready(function () {
        // Initialize tooltip
        const tooltipEl = document.getElementById('tooltipInfo');
        let tooltip = new bootstrap.Tooltip(tooltipEl);

        // When cashback % changes
        $('#cash_percentage').on('input', function () {
            let percentage = parseFloat($(this).val()) || 0;
            let subtotal = parseFloat($('#subtotal').val()) || 0;
            let shipping = parseFloat($('#shipping_cost').val()) || 0;

            // Calculate values
            let cashWithShipping = (percentage / 100) * subtotal;
            let cashWithoutShipping = (percentage / 100) * (subtotal - shipping);

            // Update display and tooltip
            $('#cash_with_shipping').text(`$${cashWithShipping.toFixed(2)}`);

            // Update tooltip text dynamically
            tooltip.dispose(); // remove old tooltip
            $('#tooltipInfo').attr(
                'title',
                `$${cashWithoutShipping.toFixed(2)} based on Sub Total without tax and shipping`
            );

            // Reinitialize tooltip with new title
            tooltip = new bootstrap.Tooltip(tooltipEl);
        });
    });
</script>
@endsection