<!-- Modal -->
<div class="modal fade" id="editFailedLeadsModal" tabindex="-1" aria-labelledby="editFailedLeadsModallLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      
      <div class="modal-header flex-column align-items-start">
        <div class="d-flex align-items-start w-100 gap-3">
          <!-- Product Image -->
          {{-- <img src="https://app.sourceflow.io/storage/images/no-image-thumbnail.png" 
               alt="Product Image"
               class="rounded"
               style="width:60px; height:60px; object-fit:cover;"> --}}

          <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-start">
              <h3 class="modal-title mb-2">Edit Failed List Item</h3>
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

                <div class="d-flex align-items-center gap-1">
                  <label class="form-label mb-0 fw-medium" id="asin-label">-</label>
                  <i class="ti ti-clipboard-text text-primary asin-copy-icon fs-5"></i>
                </div>

                <button type="button" class="btn btn-link text-primary fw-semibold p-0 d-flex align-items-center gap-1" id="open-links-btn">
                  Open Links <i class="ti ti-external-link fs-5"></i>
                </button>
              </div>

                <div class="d-flex align-items-center">
                    <span id="item-position-failed" class="text-muted small fw-semibold me-2">1 of 1</span>
                    <button type="button" id="prev-item-failed" class="btn btn-sm btn-outline-secondary me-1" disabled>
                        <i class="ti ti-chevron-left"></i>
                    </button>
                    <button type="button" id="next-item-failed" class="btn btn-sm btn-outline-secondary">
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
            <a href="#edit-lead-tab" id="edit-lead-tab-tab" data-bs-toggle="tab" class="nav-link active">Edit</a>
          </li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane show active" id="edit-lead-tab">
            <form id="failed-lead-edit-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="source_id_failed" id="source_id_failed">
                  <div class="row">
                    <div class="col-md-12 my-2">
                      <label for="e_l_name" class="form-label">Product Title</label>
                      <input type="text" class="form-control" id="e_l_name" name="e_l_name">
                    </div>
                  </div>

                  <div class="row g-2">
                    <div class="col-md-6">
                        <label for="e_l_category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="e_l_category" name="e_l_category">
                    </div>
                    <div class="col-md-6">
                      <label for="e_l_asin" class="form-label">ASIN</label>
                      <input type="text" class="form-control" id="e_l_asin" name="e_l_asin">
                    </div>
                  </div>

                    <div class="row g-2 mt-2">
                        <div class="col-md-6">
                            <label for="e_l_source_url" class="form-label">Source URL</label>
                            <input type="url" class="form-control" id="e_l_source_url" name="e_l_source_url">
                        </div>
                        <div class="col-md-6">
                            <label for="e_l_supplier" class="form-label">Supplier</label>
                            <input type="text" class="form-control" id="e_l_supplier" name="e_l_supplier">
                        </div>
                    <div class="col-md-6">
                        <label for="e_l_bsr_ninety" class="form-label">90D BSR Avg.</label>
                        <input type="text" class="form-control" id="e_l_bsr_ninety" name="e_l_bsr_ninety">
                    </div>
                    <div class="col-md-6">
                        <label for="e_l_costPerUnit" class="form-label">Cost</label>
                        <input type="number" step="0.001" value="0.00" class="form-control" id="e_l_costPerUnit" name="e_l_buy_cost">
                    </div>
                      <div class="col-md-6">
                        <label for="e_l_sellingPrice" class="form-label">Selling Price</label>
                        <input type="number" class="form-control" value="0.00" id="e_l_sellingPrice" name="e_l_selling_price">
                      </div>
                      <div class="col-md-6">
                        <label for="e_l_currency_code" class="form-label">Currency Code</label>
                        <input type="text" class="form-control" id="e_l_currency_code" name="e_l_currency_code">
                      </div>
                      {{-- <div class="col">
                      <label for="e_l_netProfit" class="form-label">Net Profit</label>
                      <input type="number" class="form-control" value="0.00" id="e_l_netProfit" name="e_l_net_profit">
                      </div>
                      <div class="col">
                      <label for="e_l_roi" class="form-label">ROI (0.00%)</label>
                      <input type="text" class="form-control" id="e_l_roi" name="e_l_roi">
                      </div> --}}
                      
                  </div>

                  <div class="row g-2 mt-2">
                      {{-- <div class="col-md-6">
                      <label for="e_l_brand" class="form-label">Brand</label>
                      <input type="text" class="form-control" id="e_l_brand" name="e_l_brand">
                      </div> --}}

                      <div class="col-md-6">
                      <label for="e_l_promo" class="form-label">Promo</label>
                      <input type="text" class="form-control" id="e_l_promo" name="e_l_promo">
                      </div>
                      <div class="col-md-6">
                      <label for="e_l_coupon_code" class="form-label">Coupon Code</label>
                      <input type="text" class="form-control" id="e_l_coupon_code" name="e_l_coupon_code">
                      </div>

                      <div class="col-md-6">
                      <label for="e_l_line_item_note" class="form-label">List Item Note</label>
                      <input type="text" class="form-control" id="e_l_line_item_note" name="e_l_line_item_note">
                      </div>
                      <div class="col-md-6">
                      <label for="e_l_publish_time" class="form-label">Publish Time</label>
                      <input type="date" class="form-control" id="e_l_publish_time" name="e_l_publish_time">
                      </div>
                      <div class="col-md-6">
                        <label for="e_l_parent_asin" class="form-label">Parent ASIN</label>
                        <input type="text" class="form-control" id="e_l_parent_asin" name="e_l_parent_asin">
                       </div>
                       <div class="col-md-6">
                        <label for="e_l_roi" class="form-label">ROI (0.00%)</label>
                        <input type="number" class="form-control" id="e_l_roi" name="e_l_roi">
                        </div>
                        <div class="col-md-6">
                        <label for="e_l_netProfit" class="form-label">Net Profit</label>
                        <input type="number" class="form-control" value="0.00" id="e_l_netProfit" name="e_l_net_profit">
                        </div>
                         <div class="col-md-6">
                        <label for="e_l_tags" class="form-label">Tags</label>
                        <input type="number" class="form-control" value="0.00" id="e_l_tags" name="e_l_tags">
                        </div>
                  </div>

                  {{-- <div class="mt-3">
                      <label for="e_l_product_note" class="form-label">Product Note</label>
                      <textarea id="e_l_product_note" rows="3" class="form-control" name="e_l_product_note"></textarea>
                  </div> --}}
            </form>
            <div class="modal-footer mt-2">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
              <button type="submit" form="failed-lead-edit-form" class="btn btn-primary">Save</button>
            </div>
          </div>
        </div>
      </div>

      
    </div>
  </div>
</div>