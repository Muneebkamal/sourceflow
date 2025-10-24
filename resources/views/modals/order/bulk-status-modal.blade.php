<div class="modal fade" id="bulkStatusModal" tabindex="-1" aria-labelledby="bulkStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label for="bulkStatusSelect" class="form-label">Select new status:</label>
        <select id="bulkStatusSelect" class="form-select">
          <option value="">Select Status</option>
          <option value="ordered">Ordered</option>
          <option value="partially received">Partially Received</option>
          <option value="received in full">Received in Full</option>
          <option value="closed">Closed</option>
          <option value="canceled">Canceled</option>
          <option value="reconcile">Reconcile</option>
          <option value="breakage">Breakage</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="bulkStatusSave" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
