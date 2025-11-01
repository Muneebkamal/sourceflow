<div class="modal fade" id="bulkTagsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Tags to Selected Items</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div id="tagsList">
                    @foreach($tags as $tag)
                        <div class="form-check mb-2">
                            <input class="form-check-input tag-checkbox"
                                   type="checkbox"
                                   value="{{ $tag->id }}"
                                   id="tag-{{ $tag->id }}">
                            <label class="form-check-label badge bg-{{ $tag->color }}-subtle text-{{ $tag->color }} fw-semibold"
                                   for="tag-{{ $tag->id }}">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="applyTagsBtn">Apply</button>
            </div>

        </div>
    </div>
</div>
