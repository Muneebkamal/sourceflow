<div class="modal fade" id="rejectItemModal" tabindex="-1" aria-labelledby="rejectItemModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectItemModalLabel">Reject Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="mb-2">
          <label for="select-rejection-reason" class="form-label">Select a reason for rejection</label>
          <select id="select-rejection-reason" class="form-select">
            <option value="Out of Stock">Out of Stock</option>
            <option value="Source page error">Source page error</option>
            <option value="Coupon/Sale Expired">Coupon/Sale Expired</option>
            <option value="Failed Payment">Failed Payment</option>
            <option value="Custom">Custom</option>
          </select>
        </div>

        <div id="customReasonContainer" class="d-none">
          <label for="customReason" class="form-label">Custom Reason</label>
          <textarea id="customReason" class="form-control" placeholder="Enter your reason..."></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="rejectItemSave" class="btn btn-danger">Reject</button>
      </div>
    </div>
  </div>
</div>