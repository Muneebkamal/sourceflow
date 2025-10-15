<!-- Create Event Modal -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="createEventLabel">Create Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="createEventForm">
                    <div class="mb-3">
                        <label for="eventType" class="form-label fw-bold">Event Type</label>
                        <select id="eventType" class="form-select">
                        <option value="listing">Listing Event</option>
                        <option value="replacement">Replacement Event</option>
                        <option value="return_for_refund">Return for Refund Event</option>
                        <option value="never_received">Never Received Event</option>
                        </select>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                        <label for="shippingBatchId" class="form-label fw-bold">Shipping Batch ID</label>
                        <select id="shippingBatchId" class="form-select">
                            <option disabled selected value="">Select Shipping Batch</option>
                        </select>
                        </div>

                        <div class="col-md-6">
                        <label for="platform" class="form-label fw-bold">Platform</label>
                        <select id="platform" class="form-select">
                            <option value="fba">FBA - Fulfillment by Amazon</option>
                            <option value="fbm">FBM - Fulfillment by Merchant</option>
                            <option value="ebay">Ebay</option>
                        </select>
                        </div>

                        <div class="col-md-6">
                        <label for="toShip" class="form-label fw-bold">Listing/Shipping Count</label>
                        <input id="toShip" type="number" class="form-control">
                        </div>

                        <div class="col-md-6">
                        <label for="qcCheck" class="form-label fw-bold">QC Check</label>
                        <select id="qcCheck" class="form-select">
                            <option value="">Select Option</option>
                            <option value="passed">Passed</option>
                            <option value="failed">Failed</option>
                        </select>
                        </div>

                        <div class="col-md-6">
                        <label for="expirationDate" class="form-label fw-bold">Expiration Date</label>
                        <input id="expirationDate" type="date" class="form-control">
                        </div>

                        <div class="col-md-6">
                        <label for="upc" class="form-label fw-bold">UPC</label>
                        <input id="upc" type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                        <label for="msku" class="form-label fw-bold">MSKU</label>
                        <input id="msku" type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                        <label for="list_price" class="form-label fw-bold">List Price</label>
                        <input id="list_price" type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                        <label for="min_list_price" class="form-label fw-bold">Min List Price</label>
                        <input id="min_list_price" type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                        <label for="max_list_price" class="form-label fw-bold">Max List Price</label>
                        <input id="max_list_price" type="text" class="form-control">
                        </div>

                        <div class="col-12">
                        <label for="shipToFbaNotes" class="form-label fw-bold">Ship to FBA Notes</label>
                        <textarea id="shipToFbaNotes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="createEventForm" class="btn btn-primary">Create Event</button>
            </div>
        </div>
    </div>
</div>