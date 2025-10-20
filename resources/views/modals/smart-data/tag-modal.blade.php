<div class="modal fade" id="tagModal" tabindex="-1" aria-labelledby="tagModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="tagModalLabel">Create Tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="TagsForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="leadListSourceName" class="form-label fw-semibold">Enter Tag Name</label>
                        <input type="text" id="leadListSourceName" name="leadListSourceName" class="form-control" required>
                    </div>
                    <div class="">
                        <label for="">Select Tag Color</label>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <button class="btn btn-soft-success w-100">Success</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-soft-info w-100">Info</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-soft-primary w-100">Primary</button>
                            </div>
                             <div class="col-md-4">
                                <button class="btn btn-soft-secondary w-100">Secondary</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-soft-danger w-100">Danger</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-soft-warning w-100">Warning</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-soft-dark w-100">Dark</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-soft-light w-100">Light</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>