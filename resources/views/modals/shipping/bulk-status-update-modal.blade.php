<div class="modal fade" id="bulkStatusModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-3 shadow">
      <div class="modal-header">
        <h5 class="modal-title">Update Status for Selected</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <select id="bulkStatusSelect" class="form-select">
          <option selected disabled>Select status</option>
          <option value="open">Open</option>
          <option value="in_transit">In Transit</option>
          <option value="closed">Closed</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-soft-primary" id="bulkStatusSaveBtn">Update</button>
      </div>
    </div>
  </div>
</div>
