<!-- Modal -->
<div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="templateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="templateModalLabel">Upload Templates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-2">
                <ul class="list-group list-group-flush">
                    @foreach ($templates as $temp)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $temp->name }}</span>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary view-template-btn" data-id="{{ $temp->id }}" data-name="{{ $temp->name }}">
                                    <i class="ti ti-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>