<div class="modal fade" id="addShippingBatchModal" tabindex="-1" aria-labelledby="addShippingBatchLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 rounded-3 shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="addShippingBatchLabel">Add New Shipping Batch</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <!-- Name -->
          <div class="col-md-12">
            <label for="batchName" class="form-label">Name</label>
            <input type="text" class="form-control" id="batchName" placeholder="Enter batch name">
          </div>

          <!-- Status -->
          <div class="col-md-6">
            <label for="batchStatus" class="form-label">Status</label>
            <select id="batchStatus" class="form-select">
              <option selected disabled>Choose status</option>
              <option value="open">Open</option>
              <option value="close">Close</option>
              <option value="in transit">In transit</option>
            </select>
          </div>

          <!-- Shipped At -->
          <div class="col-md-6">
            <label for="shippedAt" class="form-label">Shipped At</label>
            <input type="text" class="form-control" id="shippedAt" placeholder="mm/dd/yyyy">
          </div>

          <!-- Tracking Number -->
          <div class="col-md-6">
            <label for="trackingNumber" class="form-label">Tracking Number</label>
            <input type="text" class="form-control" id="trackingNumber" placeholder="Enter tracking number">
          </div>

          <!-- Marketplace -->
          <div class="col-md-6">
            <label for="marketplace" class="form-label">Marketplace</label>
            <input type="text" class="form-control" id="marketplace" placeholder="Enter marketplace">
          </div>

          <!-- Note -->
          <div class="col-md-12">
            <label for="note" class="form-label">Note</label>
            <textarea id="note" class="form-control" rows="3" placeholder="Enter any additional note"></textarea>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-soft-primary" id="saveShippingBatchBtn">Save</button>
      </div>
    </div>
  </div>
</div>
