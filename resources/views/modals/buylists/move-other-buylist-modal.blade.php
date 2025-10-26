<!-- Move to Buylist Modal -->
<div class="modal fade" id="moveToBuylistModal" tabindex="-1" aria-labelledby="moveToBuylistModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          Move to Buy List <span id="moveItemCount" class="text-muted fw-normal">(0)</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="moveToBuylistForm">
          @csrf
          <div class="mb-3">
            <label class="form-label">Move buylist items to another buylist?</label>
            <select id="targetBuylist" class="form-select" name="buylist_id" required>
              <option value="">Select Buylist</option>
              @foreach ($buylist as $list)
                <option value="{{ $list->id }}">{{ $list->name }}</option>
              @endforeach
            </select>
          </div>

          <input type="hidden" id="selectedItemIds" name="selectedItemIds">

          <div class="text-end">
            <button type="submit" class="btn btn-primary">Move Items</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
