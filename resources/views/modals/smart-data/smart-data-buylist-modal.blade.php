<!-- Modal -->
<div class="modal fade" id="editItemsModal" tabindex="-1" aria-labelledby="editItemsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content h-100">
      
      <div class="modal-header flex-column align-items-start">
        <div class="d-flex align-items-start w-100 gap-3">
          <!-- Product Image -->
          <img src="https://app.sourceflow.io/storage/images/no-image-thumbnail.png" 
               alt="Product Image"
               class="rounded"
               style="width:60px; height:60px; object-fit:cover;">

          <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-start">
              <h3 class="modal-title mb-2" id="editItemsModalLabel">Product Title</h3>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="d-flex justify-content-between align-items-center flex-wrap">
              <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 gap-sm-4 mb-2 mb-sm-0">
                <div class="d-flex align-items-center gap-2 fw-semibold text-secondary">
                  <img src="https://app.sourceflow.io/storage/images/amazon-icon.png"
                       alt="Amazon"
                       class="rounded"
                       style="width:24px; height:24px;">
                  Amazon
                </div>

                <div class="d-flex align-items-center gap-2">
                  <label class="form-label mb-0 fw-medium" id="asin-label">-</label>
                  <i class="ti ti-clipboard-text text-primary fs-5"></i>
                </div>

                <button type="button" class="btn btn-link text-primary fw-semibold p-0 d-flex align-items-center gap-2" id="open-links-btn">
                  Open Links <i class="ti ti-external-link fs-5"></i>
                </button>
              </div>

                <div class="d-flex align-items-center">
                    <span id="item-position" class="text-muted small fw-semibold me-2">1 of 1</span>
                    <button type="button" id="prev-item" class="btn btn-sm btn-outline-secondary me-1" disabled>
                        <i class="ti ti-chevron-left"></i>
                    </button>
                    <button type="button" id="next-item" class="btn btn-sm btn-outline-secondary">
                        <i class="ti ti-chevron-right"></i>
                    </button>
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-body">
        <ul class="nav nav-tabs nav-justified card-header-tabs nav-bordered w-50 mb-3">
          <li class="nav-item">
            <a href="#add-buylist-tab" data-bs-toggle="tab" class="nav-link active">Add to Buy List</a>
          </li>
          <li class="nav-item">
            <a href="#smart-data-tab" data-bs-toggle="tab" class="nav-link">Smart Data</a>
          </li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane show active" id="add-buylist-tab">
            <form id="edit-items-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-md-4">
                        <label for="purchaseQty" class="form-label"># to Purchase</label>
                        <div class="input-group">
                            <button class="btn btn-outline-secondary btn-minus" type="button">−</button>
                            <input type="number" id="purchaseQty" class="form-control text-center" value="1" min="1">
                            <button class="btn btn-outline-secondary btn-plus" type="button">+</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="name" class="form-label">Est. Selling Price</label>
                        <input type="number" id="est_selling_price" name="est_selling_price" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="multiBuyList" class="form-label">Buy List *</label>
                        <select id="multiBuyList" class="form-select" data-choices-removeItem name="choices-multiple-remove-button" multiple>
                            @foreach ($buylist as $list)
                                <option value="{{ $list->id }}">{{ $list->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-2">
                    <label for="buyerNote" class="form-label">Buyer Note</label>
                    <textarea id="buyerNote" rows="3" class="form-control" name="buyer_note" placeholder="Any notes for the buyer"></textarea>
                </div>

                <button id="leadFieldsHideShow" class="btn btn-soft-primary mt-2" type="button">Show Details <i class="ti ti-chevron-down"></i></button>

                <div id="leadFieldsSection" class="d-none">
                    <div class="row g-2 mt-2">
                        <div class="col-md-3">
                        <label for="msku" class="form-label">MSKU</label>
                        <input type="text" class="form-control" id="msku" name="msku">
                        </div>
                        <div class="col-md-3">
                        <label for="listPrice" class="form-label">List Price</label>
                        <input type="number" step="0.001" class="form-control" id="listPrice" max="99999" name="list_price">
                        </div>
                        <div class="col-md-3">
                        <label for="minPrice" class="form-label">Min Price</label>
                        <input type="number" class="form-control" id="minPrice" max="99999" name="min">
                        </div>
                        <div class="col-md-3">
                        <label for="maxPrice" class="form-label">Max Price</label>
                        <input type="number" class="form-control" id="maxPrice" max="99999" name="max">
                        </div>
                    </div>
                    <hr>
                    <h4>Edit Buy List Item</h4>
                    <div class="my-2">
                        <label for="name" class="form-label">Product Title</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>

                    <div class="row g-2">
                        <div class="col-md-4">
                        <label for="asin" class="form-label">ASIN</label>
                        <input type="text" class="form-control" id="asin" name="asin">
                        </div>
                        <div class="col-md-4">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="category">
                        </div>
                        <div class="col-md-4">
                        <label for="unitsPurchased" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="unitsPurchased" name="unit_purchased">
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-md-2">
                        <label for="costPerUnit" class="form-label">Cost</label>
                        <input type="number" step="0.001" value="0.00" class="form-control" id="costPerUnit" name="buy_cost">
                        </div>
                        <div class="col-md-2">
                        <label for="sellingPrice" class="form-label">Selling Price</label>
                        <input type="number" class="form-control" value="0.00" id="sellingPrice" name="selling_price">
                        </div>
                        <div class="col-md-2">
                        <label for="netProfit" class="form-label">Net Profit</label>
                        <input type="number" class="form-control" value="0.00" id="netProfit" name="net_profit">
                        </div>
                        <div class="col-md-3">
                        <label for="roi" class="form-label">ROI (0.00%)</label>
                        <input type="text" class="form-control" id="roi" name="roi">
                        </div>
                        <div class="col-md-3">
                        <label for="bsr_ninety" class="form-label">90D BSR Avg.</label>
                        <input type="text" class="form-control" id="bsr_ninety" name="bsr_ninety">
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-md-3">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input type="text" class="form-control" id="supplier" name="supplier">
                        </div>
                        <div class="col-md-3">
                        <label for="source_url" class="form-label">Source URL</label>
                        <input type="url" class="form-control" id="source_url" name="source_url">
                        </div>
                        <div class="col-md-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand">
                        </div>
                        <div class="col-md-3">
                        <label for="variation" class="form-label">Variation Details</label>
                        <input type="text" class="form-control" id="variation" name="variation_details">
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-md-6">
                        <label for="promo" class="form-label">Promo</label>
                        <input type="text" class="form-control" id="promo" name="promo">
                        </div>
                        <div class="col-md-6">
                        <label for="coupon_code" class="form-label">Coupon Code</label>
                        <input type="text" class="form-control" id="coupon_code" name="coupon_code">
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="product_note" class="form-label">Product Note</label>
                        <textarea id="product_note" rows="3" class="form-control" name="product_note"></textarea>
                    </div>
                </div>
            </form>
          </div>

          <div class="tab-pane" id="smart-data-tab">
            <div class="mt-4">
              <div class="card border-0">
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-6 col-sm-4"><span class="text-muted d-block">Date</span><label id="smart-date" class="form-label fw-semibold mb-0">-</label></div>
                    <div class="col-6 col-sm-4">
                        <span class="text-muted d-block">Supplier Name</span>
                        <div class="d-flex align-items-center">
                            <label id="smart-supplier" class="form-label fw-semibold mb-0">-</label>
                            <a href="#" id="supplier-link" target="_blank" class="ms-2 text-primary" title="View Supplier">
                            <i class="ti ti-external-link"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4"><span class="text-muted d-block">Buy Cost</span><label id="smart-buy-cost" class="form-label fw-semibold mb-0">$0</label></div>
                    <div class="col-6 col-sm-4"><span class="text-muted d-block">Net Cost</span><label id="smart-net-cost" class="form-label fw-semibold mb-0">$0</label></div>
                    <div class="col-6 col-sm-4"><span class="text-muted d-block">ROI</span><label id="smart-roi" class="form-label fw-semibold mb-0">0%</label></div>
                    <div class="col-6 col-sm-4"><span class="text-muted d-block">BSR</span><label id="smart-bsr" class="form-label fw-semibold mb-0">-</label></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" form="edit-items-form" class="btn btn-primary">Save Changes</button>
      </div>
    </div>
  </div>
</div>