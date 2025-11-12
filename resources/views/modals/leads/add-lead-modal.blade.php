<!-- Add New Lead Modal -->
<div class="modal fade" id="addLeadModal" tabindex="-1" aria-labelledby="addLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeadModalLabel">Add New Lead</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addLeadForm">
                @csrf
                
                <input type="hidden" name="lead_id" id="lead_id">
                <div class="modal-body p-4 overflow-auto" style="max-height:70vh;">
                    <!-- Lead Source -->
                    <div class="mb-2">
                        <label class="form-label">Lead Source:</label>
                        <select class="form-select" name="lead_source" id="lead_source_id">
                            @foreach ($sources as $source)
                                <option value="{{ $source->id }}">{{ $source->list_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Product Title -->
                    <div class="mb-2">
                        <label class="form-label" for="name">Product Title:</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <!-- ASINs and Category -->
                    <div class="row g-2 mb-2">
                        <div class="col-md-4">
                            <label class="form-label" for="asin">ASIN:</label>
                            <input type="text" class="form-control" id="asin" name="asin">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="parent_asin">Parent ASIN:</label>
                            <input type="text" class="form-control" id="parent_asin" name="parent_asin">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="category">Category:</label>
                            <input type="text" class="form-control" id="category" name="category">
                        </div>
                    </div>

                    <!-- Cost and Profit Info -->
                    <div class="row g-2 mb-2">
                        <div class="col">
                            <label class="form-label" for="cost">Cost</label>
                            <input type="number" step="0.01" class="form-control" id="cost" name="cost">
                        </div>
                        <div class="col">
                            <label class="form-label" for="selling_price">Selling Price</label>
                            <input type="number" step="0.01" class="form-control" id="selling_price" name="selling_price">
                        </div>
                        <div class="col">
                            <label class="form-label" for="net_profit_input">Net Profit</label>
                            <input type="number" step="0.01" class="form-control" id="net_profit_input" name="net_profit">
                        </div>
                        <div class="col">
                            <label class="form-label" for="roi_input">ROI (%)</label>
                            <input type="number" step="0.01" class="form-control" id="roi_input" name="roi">
                        </div>
                        <div class="col">
                            <label class="form-label" for="bsr_ninety">90D BSR Avg.</label>
                            <input type="number" class="form-control" id="bsr_ninety" name="bsr_ninety">
                        </div>
                    </div>

                    <!-- Supplier and Links -->
                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label" for="supplier">Supplier</label>
                            <input type="text" class="form-control" id="supplier" name="supplier">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="source_url">Source URL</label>
                            <input type="url" class="form-control" id="source_url" name="source_url">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="brand">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="bsr_current">Current BSR</label>
                            <input type="number" class="form-control" id="bsr_current" name="bsr_current">
                        </div>
                    </div>

                    <!-- Promo and Coupon -->
                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <label class="form-label" for="promo">Promo</label>
                            <input type="text" class="form-control" id="promo" name="promo">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="coupon_code">Coupon Code</label>
                            <input type="text" class="form-control" id="coupon_code" name="coupon_code">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-2">
                        <label class="form-label" for="list_item_note">Item Notes</label>
                        <textarea class="form-control" id="list_item_note" name="list_item_note" rows="3"></textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Lead</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
