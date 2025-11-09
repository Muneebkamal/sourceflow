<!-- Add Attachment Modal -->
<div class="modal fade" id="addAttachmentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Attachment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-2">
                    <label class="form-label">Title</label>
                    <input type="text" id="att-title" class="form-control" placeholder="Enter Title">
                </div>

                <div class="mb-2">
                    <label class="form-label">Choose File</label>
                    <input type="file" id="att-file" class="form-control">
                </div>

                <!-- File Preview (Hidden Initially) -->
                <div id="file-preview" class="d-none">
                    <div class="d-flex justify-content-between align-items-center bg-primary text-white p-2 rounded">
                        <span id="file-name">A file has been selected</span>
                        <i class="bi bi-x-lg fs-5 cursor-pointer" id="remove-file" style="cursor:pointer;"></i>
                    </div>
                </div>

                <div class="mb-2 mt-2">
                    <label class="form-label">Note</label>
                    <textarea id="att-note" class="form-control" placeholder="Enter Note"></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="saveAttachment" class="btn btn-primary">Save Attachment</button>
            </div>

        </div>
    </div>
</div>