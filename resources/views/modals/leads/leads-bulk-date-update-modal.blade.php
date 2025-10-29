<div class="modal fade" id="bulkPublishDateModal" tabindex="-1" aria-labelledby="bulkPublishDateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkPublishDateModalLabel">Change Publish Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="bulkPublishDateForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="publishDateTime" class="form-label fw-semibold">Select Date & Time</label>
                        <input type="datetime-local" id="publishDateTime" name="publishDateTime" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Date</button>
                </div>
            </form>
        </div>
    </div>
</div>