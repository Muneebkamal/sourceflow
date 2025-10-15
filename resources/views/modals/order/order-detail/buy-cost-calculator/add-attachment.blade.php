<!-- Add Attachment Modal -->
<div class="modal fade" id="addAttachmentModal" tabindex="-1" aria-labelledby="addAttachmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fw-bold" id="addAttachmentLabel">Add Attachment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form id="addAttachmentForm">
            <div class="modal-body">
            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
            </div>

            <div class="mb-3">
                <label for="file" class="form-label fw-semibold">File</label>
                <input type="file" class="form-control" id="file" name="file">
            </div>

            <div class="mb-3">
                <label for="note" class="form-label fw-semibold">Note</label>
                <textarea id="note" class="form-control" name="note" rows="3" placeholder="Enter Note"></textarea>
            </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Attachment</button>
            </div>
        </form>
        </div>
    </div>
</div>