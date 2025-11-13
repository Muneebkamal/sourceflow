<!-- Modal -->
<div class="modal fade" id="templateDetailModal" tabindex="-1" aria-labelledby="templateDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="templateDetailModalLabel">Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-2">
                <input type="hidden" id="template_id_edit">
                <div class="mb-3">
                    <label for="template_name_edit">Template Name:</label>
                    <input type="text" class="form-control" id="template_name_edit" name="template_name_edit">
                </div>
                <li class="list-group-item border-top p-0">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="fw-bold">Column</span>
                        </div>
                        <div class="col-md-6">
                            <span class="fw-bold">Value</span>
                        </div>
                    </div>
                </li>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="updateTemplateBtn">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>