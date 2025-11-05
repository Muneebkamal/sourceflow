<!-- Edit Event Modal -->
<div class="modal fade" id="EditEventModal" tabindex="-1" aria-labelledby="EditEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editEventLabel">Update Item Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="EditEventForm">
                    @csrf
                    <input type="hidden" id="order_id" name="order_id">
                    <input type="hidden" id="order_item_id" name="order_item_id">
                    <input type="hidden" name="event_type" id="edit_event_type">
                    <input type="hidden" id="edit_event_id" name="event_id">

                    <!-- LISTING EVENT -->
                    <div id="edit-section-listing" class="d-none">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Shipping Batch ID</label>
                                <select name="shipping_batch" id="edit_shipping_batch" class="form-select">
                                    <option selected disabled>Select Shipping Batch</option>
                                    @foreach ($shippings as $shipping)
                                        <option value="{{ $shipping->id }}">{{ $shipping->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Platform</label>
                                <select name="platform" id="edit_platform" class="form-select">
                                    <option value="fba">FBA - Fulfillment by Amazon</option>
                                    <option value="fbm">FBM - Fulfillment by Merchant</option>
                                    <option value="ebay">Ebay</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Listing/Shipping Count</label>
                                <input type="number" name="items" id="edit_items" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">QC Check</label>

                                <div class="dropdown" style="overflow:visible;">
                                    <button class="btn btn-light edit-qc-btn border w-100 d-flex justify-content-between align-items-center"
                                        type="button" data-bs-toggle="dropdown">
                                        <span id="editQcCheckText">Options</span>
                                        <i class="bi bi-chevron-down"></i>
                                    </button>

                                    <ul class="dropdown-menu p-3" style="max-height:220px; overflow-y:auto; z-index:999999;">
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="edit_qcAll">
                                                <label class="form-check-label" for="edit_qcAll">Check All</label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input edit-qc-option" name="edit_qc_check[]" value="upc_matches" type="checkbox">
                                                <label class="form-check-label">UPC Matches</label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input edit-qc-option" name="edit_qc_check[]" value="title_matches" type="checkbox">
                                                <label class="form-check-label">Title Matches</label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input edit-qc-option" name="edit_qc_check[]" value="image_matches" type="checkbox">
                                                <label class="form-check-label">Image Matches</label>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input edit-qc-option" name="edit_qc_check[]" value="description_matches" type="checkbox">
                                                <label class="form-check-label">Description Matches</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Expiration Date</label>
                                <input type="date" name="expire_date" id="edit_expire_date" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">UPC</label>
                                <input type="text" name="product_upc" id="edit_product_upc" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">MSKU</label>
                                <input type="text" name="msku" id="edit_msku" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">List Price</label>
                                <input id="edit_list_price" name="list_price" type="text" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Min List Price</label>
                                <input id="edit_min_list_price" name="min_list_price" type="text" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Max List Price</label>
                                <input id="edit_max_list_price" name="max_list_price" type="text" class="form-control">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Ship to FBA Notes</label>
                                <textarea class="form-control" name="shipping_notes" id="edit_shipping_notes"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- REPLACEMENT EVENT -->
                    <div id="edit-section-replacement" class="d-none">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Number of Items</label>
                                <input type="number" name="item_quantity_replace" id="edit_item_quantity_replace" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tracking Number</label>
                                <input type="text" name="tracking_number_replace" id="edit_tracking_number_replace" class="form-control">
                            </div>

                            <div class="col-12 d-flex align-items-center gap-2">
                                <label class="form-label mb-0">Received?</label>
                                <input type="checkbox" name="received_replace" id="edit_received_replace" class="form-check-input" value="1">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Supplier Notes</label>
                                <textarea class="form-control" name="supplier_notes_replace" id="edit_supplier_notes_replace"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Issue Notes</label>
                                <textarea class="form-control" name="issue_notes_replace" id="edit_issue_notes_replace"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- RETURN FOR REFUND -->
                    <div id="edit-section-refund" class="d-none">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Number of Items</label>
                                <input type="number" name="item_quantity_return" id="edit_item_quantity_return" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Expected Refund</label>
                                <input type="number" name="refund_expected_return" id="edit_refund_expected" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Actual Refund</label>
                                <input type="number" name="refund_actual_return" id="edit_refund_actual" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tracking Number</label>
                                <input type="text" name="tracking_number_return" id="edit_tracking_number_return" class="form-control">
                            </div>

                            <div class="col-12 d-flex align-items-center gap-2">
                                <label class="form-label mb-0">Refunded?</label>
                                <input type="checkbox" name="refunded_return" id="edit_refunded_return" value="1" class="form-check-input">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Supplier Notes</label>
                                <textarea class="form-control" name="supplier_notes_return" id="edit_supplier_notes_return"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Issue Notes</label>
                                <textarea class="form-control" name="issue_notes_return" id="edit_issue_notes_return"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- NEVER RECEIVED -->
                    <div id="edit-section-never" class="d-none">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Number of Items</label>
                                <input type="number" name="item_quantity_received" id="edit_item_quantity_received" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Expected Refund</label>
                                <input type="number" name="refund_expected_received" id="edit_refund_expected_received" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Actual Refund</label>
                                <input type="number" name="refund_actual_received" id="edit_refund_actual_received" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tracking Number</label>
                                <input type="text" name="tracking_number_received" id="edit_tracking_number_received" class="form-control">
                            </div>

                            <div class="col-12 d-flex flex-wrap gap-4">
                                <div class="d-flex align-items-center gap-2">
                                    <label class="form-label mb-0">Cancelled?</label>
                                    <input type="checkbox" name="cancelled_received" id="edit_cancelled_received" value="1" class="form-check-input">
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <label class="form-label mb-0">CC Charged?</label>
                                    <input type="checkbox" name="cc_charged_received" id="edit_cc_charged_received" value="1" class="form-check-input">
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <label class="form-label mb-0">Refunded?</label>
                                    <input type="checkbox" name="refunded_received" id="edit_refunded_received" value="1" class="form-check-input">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Supplier Notes</label>
                                <textarea name="supplier_notes_received" id="edit_supplier_notes_received" class="form-control"></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Issue Notes</label>
                                <textarea name="issue_notes_received" id="edit_issue_notes_received" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="EditEventForm" class="btn btn-primary">Update Event</button>
            </div>
        </div>
    </div>
</div>