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
                                <button id="orderSaveBtn" class="btn btn-primary">
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
                    <table class="table table-hover align-middle" id="savedItemsContainer">
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
                                    <td>
                                        <input type="hidden" class="line-item-id" value="{{ $item->id }}">{{ $item->asin }}
                                    </td>
                                    <td>
                                        <img src="https://app.sourceflow.io/storage/images/no-image-thumbnail.png"
                                            alt="Product Image" class="img-fluid rounded" width="50">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>---</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <input type="checkbox" class="form-check">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control unit-input" value="{{ $item->unit_purchased }}">
                                    </td>
                                    <td class="buy-cost">${{ $item->buy_cost }}</td>
                                    <td class="sku-total">${{ $item->sku_total }}</td>
                                    <td class="bg-success-subtle">$0.00</td>
                                    <td class="text-center">
                                        <i class="ti ti-trash text-danger delLineItem fs-3"></i>
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
                            <input type="text" class="form-control" id="pre_tax_discount" name="pre_tax_discount"
                                value="{{ $order->pre_tax_discount }}" autocomplete="pre_tax_discount">
                        </div>

                        <div class="mb-1">
                            <label for="post_tax_discount" class="form-label">Post-Tax Discount</label>
                            <input type="text" class="form-control" id="post_tax_discount" name="post_tax_discount"
                                value="{{ $order->post_tax_discount }}" autocomplete="post_tax_discount">
                        </div>

                        <div class="mb-1">
                            <label for="shipping_total" class="form-label">Shipping Cost</label>
                            <input type="text" class="form-control" value="{{ $order->shipping_cost }}"
                                id="shipping_total" name="shipping_total" autocomplete="shipping_total">
                        </div>

                        <div class="mb-1">
                            <label for="tax_paid" class="form-label">Sales Tax</label>
                            <input type="text" class="form-control" value="{{ $order->sales_tax }}"
                                id="tax_paid" name="tax_paid" autocomplete="tax_paid">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label for="sales_tax_shipping" class="form-label mb-0">Sales Tax Paid on Shipping</label>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" id="sales_tax_shipping"
                                    @if($order->is_sale_tax_shipping == 1) checked @endif>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Sales Tax Rate</span>
                            <span class="fw-semibold" id="sales_tax_rate_display">{{ $order->sales_tax_rate }}%</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal (Pre-Tax)</span>
                            <span class="fw-semibold" id="subtotal_display">${{ $order->subtotal }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">Grand Total</span>
                            <span class="fw-bold text-dark" id="grand_total_display">${{ $order->total }}</span>
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
                                    id="add-attach-btn"
                                    data-order-id="{{ $order->id }}">
                                <i class="ti ti-upload me-1"></i>
                                Upload
                            </button>
                        </div>
                        <div class="card-body" id="attachments-list">
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

    @include('modals.order.order-detail.add-attachment-modal')
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // 🟢 Click to edit note
        $(document).on('click', '.note-card', function () {
            const card = $(this).closest('.card');
            
            // Hide note text, show textarea, and focus it
            card.find('.note-text').hide();
            card.find('textarea').show().focus();
            
            // Show the check icon
            card.find('.check-icon').show();
        });

        // Click the check icon to save (locally only)
        $(document).on('click', '.check-icon', function (e) {
            e.preventDefault();

            const card = $(this).closest('.card');
            const textarea = card.find('textarea');
            const noteText = card.find('.note-text');
            const noteValue = textarea.val().trim();

            // Update visible note text
            noteText.text(noteValue || ''); // keep it blank if empty

            // Hide textarea and check icon, show text
            textarea.hide();
            noteText.show();
            card.find('.check-icon').hide();
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

    $(document).ready(function () {

        function renderEditableInputs() {
            const calculatorType = $('#calculator_type').val();

            $('#savedItemsContainer tbody tr').each(function () {
                const $row = $(this);
                const buyCostVal = $row.find('.buy-cost').data('value') || $row.find('.buy-cost').text().replace('$', '').trim();
                const skuTotalVal = $row.find('.sku-total').data('value') || $row.find('.sku-total').text().replace('$', '').trim();

                $row.find('.buy-cost').data('value', buyCostVal);
                $row.find('.sku-total').data('value', skuTotalVal);

                if (calculatorType === 'Cost Per Unit') {
                    $row.find('.buy-cost').html(`<input type="number" class="form-control buy-cost-input" value="${buyCostVal}">`);
                    $row.find('.sku-total').text(`$${parseFloat(skuTotalVal).toFixed(2)}`);
                } else {
                    $row.find('.buy-cost').text(`$${parseFloat(buyCostVal).toFixed(2)}`);
                    $row.find('.sku-total').html(`<input type="number" class="form-control sku-total-input" value="${skuTotalVal}">`);
                }
            });
        }

        renderEditableInputs();
        calculateTotals();

        $('#calculator_type').on('change', function () {
            renderEditableInputs();
            calculateTotals();
        });

        $(document).on('input change',
            '#pre_tax_discount, #post_tax_discount, #shipping_total, #tax_paid, #sales_tax_shipping, .unit-input, .buy-cost-input, .sku-total-input',
            function () {
                calculateTotals();
            }
        );

        function calculateTotals() {
            const calculatorType = $('#calculator_type').val();
            const preTaxDiscount = parseFloat($('#pre_tax_discount').val()) || 0;
            const postTaxDiscount = parseFloat($('#post_tax_discount').val()) || 0;
            const shippingCost = parseFloat($('#shipping_total').val()) || 0;
            const taxPaidAmount = parseFloat($('#tax_paid').val()) || 0; // 🟢 tax as absolute value
            const isSalesTaxOnShipping = $('#sales_tax_shipping').is(':checked');

            let lineItemsTotal = 0;
            let totalUnits = 0;
            const rows = [];

            $('#savedItemsContainer tbody tr').each(function () {
                const $row = $(this);
                const units = parseFloat($row.find('.unit-input').val()) || 0;

                let buyCost = 0;
                let skuTotal = 0;

                if (calculatorType === 'Cost Per Unit') {
                    buyCost = parseFloat($row.find('.buy-cost-input').val()) || 0;
                    skuTotal = units * buyCost;
                    $row.find('.sku-total').text(`$${skuTotal.toFixed(2)}`);
                } else {
                    skuTotal = parseFloat($row.find('.sku-total-input').val()) || 0;
                    buyCost = units > 0 ? (skuTotal / units) : 0;
                    $row.find('.buy-cost').text(`$${buyCost.toFixed(2)}`);
                }

                rows.push({ $row, units, buyCost, skuTotal });
                lineItemsTotal += skuTotal;
                totalUnits += units;
            });

            const subtotalBeforeTax = lineItemsTotal - preTaxDiscount;
            let totalTaxableBase = subtotalBeforeTax;
            if (isSalesTaxOnShipping) totalTaxableBase += shippingCost;

            // 🟢 Calculate tax rate based on entered tax amount
            const salesTaxRate = totalTaxableBase > 0 ? (taxPaidAmount / totalTaxableBase) * 100 : 0;

            const grandTotal = subtotalBeforeTax + taxPaidAmount + shippingCost - postTaxDiscount;
            const safeLineTotal = lineItemsTotal > 0 ? lineItemsTotal : 0;

            // 🟢 Per-item calculations
            rows.forEach(function (r) {
                const proportion = safeLineTotal > 0 ? (r.skuTotal / safeLineTotal) : 0;
                const preTaxAlloc = preTaxDiscount * proportion;
                const postTaxAlloc = postTaxDiscount * proportion;
                const shippingAlloc = shippingCost * proportion;
                const taxAlloc = taxPaidAmount * proportion;

                const itemFinal = r.skuTotal - preTaxAlloc + shippingAlloc + taxAlloc - postTaxAlloc;
                const perUnitCalculated = r.units > 0 ? (itemFinal / r.units) : 0;

                r.$row.find('td.bg-success-subtle').text(`$${perUnitCalculated.toFixed(2)}`);
            });

            // 🟢 Update summary
            $('#subtotal_display').text(`$${Math.max(0, subtotalBeforeTax).toFixed(2)}`);
            $('#grand_total_display').text(`$${Math.max(0, grandTotal).toFixed(2)}`);
            $('#sales_tax_rate_display').text(`${salesTaxRate.toFixed(2)}%`);
        }
    });

    $(document).on('click', '#orderSaveBtn', function (e) {
        e.preventDefault();

        const $btn = $(this);
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');

        // 🟢 Collect order-level data
        const orderData = {
            order_id: $('#order_id').val(),
            source: $('#source').val(),
            destination: $('#destination').val(),
            email_used: $('#email_used').val(),
            calculator_type: $('#calculator_type').val(),
            pre_tax_discount: $('#pre_tax_discount').val(),
            post_tax_discount: $('#post_tax_discount').val(),
            shipping_total: $('#shipping_total').val(),
            sales_tax: $('#tax_paid').val(),
            is_sale_tax_shipping: $('#sales_tax_shipping').is(':checked') ? 1 : 0,
            sales_tax_rate: $('#sales_tax_rate_display').text().replace('%', '').trim(),
            subtotal: $('#subtotal_display').text().replace('$', '').trim(),
            total: $('#grand_total_display').text().replace('$', '').trim(),
            note: $('textarea[name="note"]').val(),
            card_used: $('#card_used').val(),
            amount_charged: $('#amount_charged').val(),
            cash_back_source: $('#cash_back_source').val(),
            cash_back_percentage: $('#cash_percentage').val(),
            status: $('select[name="status"]').val(),
            date_ordered: $('#editDate').val() || $('#displayDate').text().trim()
        };

        // 🟢 Collect line items data
        const lineItems = [];
        $('#savedItemsContainer tbody tr').each(function () {
            const $row = $(this);
            const item = {
                id: $row.find('.line-item-id').val(),
                asin: $row.find('td:eq(0)').text().trim(),
                unit_purchased: $row.find('.unit-input').val(),
                buy_cost: $row.find('.buy-cost-input').length
                    ? $row.find('.buy-cost-input').val()
                    : $row.find('.buy-cost').text().replace('$', '').trim(),
                sku_total: $row.find('.sku-total-input').length
                    ? $row.find('.sku-total-input').val()
                    : $row.find('.sku-total').text().replace('$', '').trim(),
                cost_per_unit_calculated: $row.find('.bg-success-subtle').text().replace('$', '').trim(),
                tax_exempt: $row.find('input.form-check').is(':checked') ? 1 : 0
            };
            lineItems.push(item);
        });

        // 🟢 AJAX call to save all data
        $.ajax({
            url: '{{ route("orders.updateFull", $order->id) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                order: orderData,
                line_items: lineItems
            },
            success: function (response) {
                if (response.success) {
                    toastr.success('Order updated successfully!');
                    $btn.html('Saved');
                    setTimeout(() => {
                        window.location.href = `/order/${response.order_id}`;
                    }, 800);
                } else {
                    toastr.error(response.message || 'Failed to update order.');
                    $btn.prop('disabled', false).text('Save & Go To Order');
                }
            },
            error: function () {
                toastr.error('Server error. Please try again.');
                $btn.prop('disabled', false).text('Save & Go To Order');
            }
        });
    });

    $(document).ready(function() {
        // Delete icon click
        $(document).on('click', '.delLineItem', function() {
            const row = $(this).closest('tr');
            const lineItemId = row.find('.line-item-id').val();

            Swal.fire({
                title: "Delete or Move?",
                html: `
                    <p class="mb-2">Do you want to delete this item or move it back to the Buylist?</p>
                    <div class="form-check d-flex align-items-start justify-content-center">
                        <input class="form-check-input me-2" type="checkbox" id="moveToBuylistCheckbox">
                        <label class="form-check-label" for="moveToBuylistCheckbox">
                            Move this item to Buylist instead of deleting
                        </label>
                    </div>
                `,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, continue!"
            }).then((result) => {
                if (result.isConfirmed) {
                    const isBuylist = $('#moveToBuylistCheckbox').is(':checked') ? 1 : 0;

                    $.ajax({
                        url: "{{ route('orders.deleteLineItem') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            line_item_id: lineItemId,
                            is_buylist: isBuylist
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Done!",
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                // Fade out the row smoothly
                                row.fadeOut(400, function() {
                                    $(this).remove();
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: response.message || "Something went wrong."
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: "Server error occurred."
                            });
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    });
    
    // When file is selected
    $('#att-file').on('change', function () {
        let file = this.files[0];

        if (file) {
            $('#file-name').text(file.name);
            $('#file-preview').removeClass('d-none');
        }
    });

    // Remove selected file
    $('#remove-file').on('click', function () {
        $('#att-file').val('');      // Clear input
        $('#file-preview').addClass('d-none');
    });

    $(document).ready(function() {
        let orderId = {{ $order->id }};
        loadAttachments(orderId); // Load attachments on page load

        // Handle Upload button click (optional modal)
        $('#add-attach-btn').on('click', function() {
            $('#addAttachmentModal').modal('show');
        });

        function loadAttachments(orderId) {
            $.ajax({
                url: `/orders/${orderId}/attachments`,
                method: 'GET',
                success: function(res) {
                    let container = $('#attachments-list');
                    container.empty();

                    if (res.length === 0) {
                        container.html(`
                            <div class="text-center">
                                <p class="fw-medium mb-1 text-secondary">No attachments available.</p>
                                <p class="text-muted small mb-0">Please upload a file to see it here.</p>
                            </div>
                        `);
                        return;
                    }

                    let html = '<div class="row g-2">';
                    res.forEach(att => {
                        html += `
                        <div class="col-12" data-id="${att.id}">
                            <div class="card shadow-sm border-0 m-0">
                                <div class="card-body d-flex align-items-center p-1">
                                    <div class="me-3 d-flex align-items-center justify-content-center border rounded" style="width:64px; height:64px;">
                                        <svg class="h-10 w-10 text-slate-400" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="currentColor" d="M23.3333 3.33334H10C8.16667 3.33334 6.66667 4.83334 6.66667 6.66668V33.3333C6.66667 35.1667 8.16667 36.6667 10 36.6667H30C31.8333 36.6667 33.3333 35.1667 33.3333 33.3333V13.3333L23.3333 3.33334ZM30 33.3333H10V6.66668H23.3333V13.3333H30V33.3333ZM20 28.3333C18.1667 28.3333 16.6667 26.8333 16.6667 25V15.8333C16.6667 15.3667 17.0333 15 17.5 15C17.9667 15 18.3333 15.3667 18.3333 15.8333V25H21.6667V15.8333C21.6667 13.5333 19.8 11.6667 17.5 11.6667C15.2 11.6667 13.3333 13.5333 13.3333 15.8333V25C13.3333 28.6833 16.3167 31.6667 20 31.6667C23.6833 31.6667 26.6667 28.6833 26.6667 25V18.3333H23.3333V25C23.3333 26.8333 21.8333 28.3333 20 28.3333Z"></path>
                                        </svg>
                                    </div>
                                    <div class="text-start">
                                        <h5 class="card-title mb-1" 
                                            data-bs-title="${att.note}" 
                                            data-bs-toggle="tooltip" 
                                            data-bs-placement="top">
                                            ${att.name}
                                        </h5>
                                        <small class="text-muted">${att.created_at}</small>
                                        <div class="mt-1">
                                            <a href="/attachments/${att.id}/download" target="_blank" class="me-2">Download</a>
                                            <a href="#" class="text-danger delete-attachment">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
                    });
                    html += '</div>';
                    container.html(html);

                    // Initialize Bootstrap tooltip
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    })
                },
                error: function(err) {
                    console.error(err);
                    toastr.error('Failed to load attachments.');
                }
            });
        }

        // Save attachment via AJAX
        $('#saveAttachment').on('click', function () {
            const title = $('#att-title').val();
            const note  = $('#att-note').val();
            const fileInput = $('#att-file')[0].files[0];

            if (!fileInput) {
                toastr.error('Please select a file!');
                return;
            }

            const formData = new FormData();
            formData.append('title', title);
            formData.append('note', note);
            formData.append('file', fileInput);
            formData.append('order_id', {{ $order->id }});
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '/save-attachment',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.success) {
                        toastr.success('Attachment saved successfully!');
                        $('#addAttachmentModal').modal('hide');
                        loadAttachments({{ $order->id }});
                    } else {
                        toastr.error(res.message || 'Failed to save attachment');
                    }
                },
                error: function (err) {
                    console.error(err.responseText);
                    toastr.error('Server error. Please try again.');
                }
            });
        });

        $('#add-attach-modal').on('click', function (e) {
            e.preventDefault();

            // Open second modal on top of first
            const addModal = new bootstrap.Modal(document.getElementById('addAttachmentModal'), {
                backdrop: false, // first modal backdrop stays
                keyboard: false
            });
            addModal.show();
        });

        // Delete attachment dynamically
        $(document).on('click', '.delete-attachment', function() {
            let attachmentId = $(this).closest('[data-id]').data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the attachment!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/orders/attachments/${attachmentId}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(res) {
                            Swal.fire('Deleted!', 'Attachment has been deleted.', 'success');
                            loadAttachments({{ $order->id }}); // reload list
                        },
                        error: function(err) {
                            console.error(err);
                            Swal.fire('Error!', 'Failed to delete attachment.', 'error');
                        }
                    });
                }
            });
        });
    });

</script>
@endsection