<!-- Bulk Move Leads Modal -->
<div class="modal fade" id="bulkMoveLeadModal" tabindex="-1" aria-labelledby="bulkMoveLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkMoveLeadModalLabel">Move Selected Leads to Source</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="bulkMoveLeadForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="leadSourceSelect" class="form-label fw-semibold">Select Lead Source</label>
                        <select id="leadSourceSelect" name="leadSource" class="form-select" required>
                            <option value="">-- Select Source --</option>
                            @foreach ($sources as $source)
                                <option value="{{ $source->id }}">{{ $source->list_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Move Leads</button>
                </div>
            </form>
        </div>
    </div>
</div>