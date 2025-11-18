@extends('layouts.app')

@section('title', 'BuyList')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0 text-danger">Buy Lists (Rejected)</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                    <form action="javascript:void(0);">
                        <div class="row g-2 mb-0 align-items-center">
                            <div class="col-auto">
                                <a class="" href="#" target="_blank">
                                    <p class="text-success m-0">🎉 To Add Leads to a Buy List, Use the SF Extension!</p>
                                </a>
                            </div>
                            <div class="col-auto">
                                {{-- <button class="btn btn-soft-primary">
                                    Export
                                </button> --}}
                                <button type="button" class="btn btn-soft-primary" data-bs-toggle="modal" data-bs-target="#createBuylistModal">
                                New Buy List
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row align-items-end mb-3">
        <div class="col-md-7">
            <div class="d-flex align-items-center gap-2">
                <div class="d-flex">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="ti ti-search"></i>
                        </span>
                        <input id="searchInput" type="text" class="form-control" placeholder="Search...">
                    </div>
                </div>

                <!-- Filter + Reset Buttons -->
                <div class="d-flex gap-1">
                    <button id="reset-btn" class="btn btn-danger">Reset</button>
                    <a href="{{ route('orders.items') }}" class="btn btn-soft-primary">View Ordered Leads</a>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="d-flex align-items-end justify-content-md-end gap-1 mt-2 mt-md-0">
                <a href="{{ route('buylists.index') }}" class="btn btn-soft-danger">
                    Back to Buy List <i class="ti ti-ban fs-4"></i>
                </a>

                <div class="btn-group drop-down">
                    <button type="button" class="btn btn-soft-primary dropdown-toggle drop-arrow-none" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                        Select Buy List <i class="ti ti-chevron-down align-middle ms-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-md p-0 shadow">
                        <div class="card border-0 mb-0">
                            <div class="card-header bg-light py-2">
                                <h5 class="mb-0 fw-semibold">Select Buylists</h5>
                            </div>

                            <div class="card-body p-2">
                                <div class="column-list">
                                    <!-- Buy Lists -->
                                    @foreach ($buylist as $list)
                                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                                            <div class="d-flex align-items-center">
                                                <input class="form-check-input me-2 buylist-filter" type="checkbox" value="{{ $list->id }}" id="list-{{ $list->id }}" checked>
                                                <label class="form-check-label mb-0" for="list-{{ $list->id }}">{{ $list->name }}</label>
                                            </div>
                                            <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y">
                                                <button class="btn btn-sm btn-outline-danger delete-buylist" data-id="{{ $list->id }}"><i class="ti ti-trash"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-soft-primary" data-bs-toggle="modal" data-bs-target="#createBuylistModal">Create Buylist <i class="ti ti-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-soft-primary dropdown-toggle drop-arrow-none" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                        <i class="ti ti-adjustments-horizontal"></i> Customize
                    </button>

                    <div class="dropdown-menu dropdown-menu-md p-0 shadow">
                        <div class="card border-0 mb-0">
                            <div class="card-header bg-light py-2">
                                <h5 class="mb-0 fw-semibold text-center">Displayed Order Columns</h5>
                            </div>

                            <div class="card-body p-2">
                                <!-- ✅ Sortable list -->
                                <div class="column-list-draggable"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-2" id="table-info-top"></div>

            <div id="select-count-section" class="col-md-12 d-flex mb-2 align-items-center d-none">
                <div class="dropdown">
                    <button class="btn btn-sm btn-light" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                        <i class="ti ti-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item bulkMoveBtn" href="#">Move to Buylist</a></li>
                        <li><a class="dropdown-item text-danger bulkDelBtn" href="#">Delete</a></li>
                    </ul>
                </div>
                <span class="fw-bold ms-3">Selected: <span id="selectedCount">0</span></span>
            </div>

            <div class="card">
                <div class="card-body border border-4 border-danger p-0">
                    <div class="table-responsive">
                        <table id="rejected-buylist-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                    <th>Rejected At</th>
                                    <th>Rejected By</th>
                                    <th>Rejection Reason</th>
                                    <th>Order Note</th>
                                    <th>Asin</th>
                                    <th>Image</th>
                                    <th>Product Title</th>
                                    <th>Variations</th>
                                    <th>Supplier</th>
                                    <th>Cost</th>
                                    <th>Selling Price</th>
                                    <th>Qty</th>
                                    <th>BSR 90D Avg</th>
                                    <th>Promo</th>
                                    <th>Coupon Code</th>
                                    <th>Product Note</th>
                                    <th>Buyer Note</th>
                                    <th>UPC/GTIN</th>
                                    <th>Brand</th>
                                    <th>Monthly Sold</th>
                                    <th>Offers</th>
                                    <th>Rating</th>
                                    <th>Reviews</th>
                                    <th>Buy List Name</th>
                                    <th>Lead Type</th>
                                    <th>SKU Total Cost</th>
                                    <th>ROI Est</th>
                                    <th>Net Profit Est</th>
                                    <th>BSR Current</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                    {{-- <th class="sticky-col">Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between my-2" id="table-info-bottom"></div>
        </div>
    </div>

    @include('modals.buylists.create-buylist-modal')
    @include('modals.buylists.move-other-buylist-modal')
    @include('modals.order.order-detail.lineitems-edit-modal')
@endsection
    
@section('scripts')
    <script>
        // $(document).ready(function() {
        //     let table = $('#rejected-buylist-table').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: {
        //             url: "{{ route('buylist.data.rejected') }}",
        //             data: function (d) {
        //                 d.buylist_ids = $('.buylist-filter:checked').map(function() {
        //                     return $(this).val();
        //                 }).get();
        //                 d.search = $('#searchInput').val();
        //             }
        //         },
        //         // drawCallback: function () {
        //         //     const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        //         //     tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });
        //         // },
        //         scrollY: '50vh',
        //         scrollX: true,
        //         paging: true,
        //         searching: false,
        //         ordering: true,
        //         lengthChange: true,
        //         columns: [
        //             {
        //                 data: 'id',
        //                 orderable: false,
        //                 render: function(data, type, row) {
        //                     return `<input type="checkbox" class="form-check-input buylist-checkbox" data-id="${row.id}">`;
        //                 }
        //             },
        //             { data: 'created_at' },
        //             { data: 'created_by' },
        //             { data: 'rejection_reason' },
        //             { data: 'asin' },
        //             { data: 'image', orderable: false, searchable: false },
        //             { data: 'name' },
        //             { data: 'variations' },
        //             { data: 'supplier' },
        //             { data: 'bsr' },
        //             { data: 'cost' },
        //             { data: 'order_note' },
        //             { data: 'product_buyer_notes' },
        //             { data: 'actions', orderable: false, searchable: false },
        //         ],
        //         dom: `<'d-flex justify-content-between'<'info-top'i><'d-flex'<'paginate-top'p><'length-top'l>>>t<'d-flex justify-content-between'<'info-bottom'i><'d-flex'<'paginate-bottom'p><'length-bottom'l>>>`,
        //         initComplete: function() {
        //             // Move elements to external containers once
        //             $('#table-info-top').append(
        //                 $('<div class="d-flex justify-content-between w-100"></div>').append(
        //                     $('.info-top'),
        //                     $('<div class="d-flex"></div>').append($('.paginate-top').addClass('me-1'), $('.length-top'))
        //                 )
        //             );

        //             $('#table-info-bottom').append(
        //                 $('<div class="d-flex justify-content-between w-100"></div>').append(
        //                     $('.info-bottom'),
        //                     $('<div class="d-flex"></div>').append($('.paginate-bottom').addClass('me-1'), $('.length-bottom'))
        //                 )
        //             );

        //             // Remove default text and padding
        //             $('.length-top label, .length-bottom label').contents().filter(function() { return this.nodeType === 3; }).remove();
        //             $('.paginate-top ul, .paginate-bottom ul').addClass('p-0 m-0');
        //             $('.dataTables_info, #buylist-table_info, .dataTables_paginate, .paging_simple_numbers').css({ padding: 0, margin: 0 });
        //         },
        //         drawCallback: function() {
        //             // Re-init tooltips
        //             $('[data-bs-toggle="tooltip"]').each(function() { new bootstrap.Tooltip(this); });
        //         }
        //     });

        //     // 🔹 When Buy List checkboxes change, reload the table
        //     $(document).on('change', '.buylist-filter', function() {
        //         table.ajax.reload();
        //     });

        //     // 🔹 Optional: Search + Reset buttons
        //     $('#searchInput').on('keyup', function() {
        //         table.ajax.reload();
        //     });

        //     $('#reset-btn').on('click', function() {
        //         var $btn = $(this);
        //         $btn.prop('disabled', true);
        //         $btn.html('<span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span>Reset');

        //         $('#searchInput').val('');
        //         // $('.buylist-filter').prop('checked', false);

        //         table.ajax.reload(function() {
        //             // Re-enable button after table has fully loaded
        //             $btn.prop('disabled', false);
        //             $btn.html('Reset');
        //         });
        //     });
        // });

        $(document).ready(function () {
            if ($.fn.DataTable.isDataTable('#rejected-buylist-table')) {
                $('#rejected-buylist-table').DataTable().destroy();
                $('#rejected-buylist-table').empty();
            }

            const table = $('#rejected-buylist-table').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                stateSave: true,
                colReorder: true,
                lengthChange: true,
                ajax: {
                    url: "{{ route('buylist.data.rejected') }}",
                    data: function (d) {
                        d.buylist_ids = $('.buylist-filter:checked').map(function () {
                            return $(this).val();
                        }).get();
                        d.search = $('#searchInput').val();
                    }
                },
                scrollY: '50vh',
                scrollX: true,
                paging: true,
                searching: false,
                autoWidth: false,
                ordering: true,
                order: [],
                columns: [
                    { data: 'id', orderable: false, render: data => `<input type="checkbox" class="form-check-input buylist-checkbox" data-id="${data}">` },
                    { data: 'created_at', title: 'Rejected At', defaultContent: '--' },
                    { data: 'created_by', title: 'Rejected By', defaultContent: '--' },
                    { data: 'rejection_reason', title: 'Rejection Reason', defaultContent: '--' },
                    { data: 'order_note', title: 'Order Note', defaultContent: '--' },
                    { data: 'asin', title: 'ASIN', defaultContent: '--' },
                    { data: 'image', title: 'Image', defaultContent: '--', orderable: false, searchable: false },
                    { data: 'name', title: 'Product Title', defaultContent: '--' },
                    { data: 'variations', title: 'Variation Details', defaultContent: '--' },
                    { data: 'supplier', title: 'Supplier', defaultContent: '--' },
                    { data: 'buy_cost', title: 'Buy Cost', defaultContent: '--' },
                    { data: 'selling_price', title: 'Estimated Selling Price', defaultContent: '$0.00', render: d => d ? `$${parseFloat(d).toFixed(2)}` : '$0.00' },
                    { data: 'unit_purchased', title: 'Quantity (To Purchase)', defaultContent: '--' },
                    { data: 'bsr', title: 'BSR 90D Avg', defaultContent: '--' },
                    { data: 'promo', title: 'Promo', defaultContent: '--' },
                    { data: 'coupon_code', title: 'Coupon Code', defaultContent: '--' },
                    { data: 'product_note', title: 'Product Note', defaultContent: '--' },
                    { data: 'product_buyer_notes', title: 'Buyer Note', defaultContent: '--' },
                    { data: 'upc', title: 'UPC/GTIN', defaultContent: '--' },
                    { data: 'brand', title: 'Brand', defaultContent: '--' },
                    { data: 'monthly_sold', title: 'Monthly Sold', defaultContent: '--' },
                    { data: 'offers', title: 'Offers', defaultContent: '--' },
                    { data: 'rating', title: 'Rating', defaultContent: '--' },
                    { data: 'reviews', title: 'Reviews', defaultContent: '--' },
                    { data: 'buylist_name', title: 'Buy List Name', defaultContent: '--' },
                    { data: 'lead_type', title: 'Lead Type', defaultContent: '--' },
                    { data: 'sku_total', title: 'SKU Total Cost', defaultContent: '$0.00', render: d => d ? `$${parseFloat(d).toFixed(2)}` : '$0.00' },
                    { data: 'roi_est', title: 'ROI Est', defaultContent: '--' },
                    { data: 'net_profit_est', title: 'Net Profit Est', defaultContent: '--' },
                    { data: 'bsr_current', title: 'BSR Current', defaultContent: '--' },
                    { data: 'category', title: 'Category', defaultContent: '--' },
                    { data: 'actions', title: 'Actions', orderable: false, searchable: false, defaultContent: '' },
                ],
                dom: `<'d-flex justify-content-between'<'info-top'i><'d-flex'<'paginate-top'p><'length-top'l>>>t<'d-flex justify-content-between'<'info-bottom'i><'d-flex'<'paginate-bottom'p><'length-bottom'l>>>`,
                initComplete: function() {
                    // Move elements to external containers once
                    $('#table-info-top').append(
                        $('<div class="d-flex justify-content-between w-100"></div>').append(
                            $('.info-top'),
                            $('<div class="d-flex"></div>').append($('.paginate-top').addClass('me-1'), $('.length-top'))
                        )
                    );

                    $('#table-info-bottom').append(
                        $('<div class="d-flex justify-content-between w-100"></div>').append(
                            $('.info-bottom'),
                            $('<div class="d-flex"></div>').append($('.paginate-bottom').addClass('me-1'), $('.length-bottom'))
                        )
                    );

                    // Remove default text and padding
                    $('.length-top label, .length-bottom label').contents().filter(function() { return this.nodeType === 3; }).remove();
                    $('.paginate-top ul, .paginate-bottom ul').addClass('p-0 m-0');
                    $('.dataTables_info, #buylist-table_info, .dataTables_paginate, .paging_simple_numbers').css({ padding: 0, margin: 0, });
                },
                drawCallback: function() {
                    // Re-init tooltips
                    $('[data-bs-toggle="tooltip"]').each(function() { new bootstrap.Tooltip(this); });
                }
            });

            /** 🧩 1. Dynamically build checkbox + drag list */
            const $list = $(".column-list-draggable").empty();
            table.columns().every(function (index) {
                const col = this;
                const data = col.dataSrc();
                const title = col.header().textContent.trim();

                // skip hidden placeholders (first and last column)
                if (data === 'id' || data === 'actions') return;

                const checked = col.visible() ? 'checked' : '';
                const disabled = data === 'name' ? 'disabled' : '';

                const item = `
                    <div class="d-flex justify-content-between align-items-center draggable-item" data-col="${data}">
                        <div>
                            <input class="form-check-input" type="checkbox" id="col-${data}" ${checked} ${disabled}>
                            <label class="form-check-label ms-2" for="col-${data}">${title}</label>
                        </div>
                        <i class="ti ti-grip-vertical grip-icon"></i>
                    </div>`;
                $list.append(item);
            });

            /** 🧭 Helper: get index by data name */
            function getColIndex(dataName) {
                const columns = table.settings().init().columns;
                return columns.findIndex(c => c.data === dataName);
            }

            /** ✅ 2. Checkbox show/hide logic */
            $(document).on('change', '.column-list-draggable .form-check-input', function () {
                const dataName = $(this).attr('id').replace('col-', '');
                const colIndex = getColIndex(dataName);
                const visible = $(this).is(':checked');
                if (colIndex >= 0) table.column(colIndex).visible(visible);
                table.state.save();
            });

            /** ✅ 3. Make list draggable and reorder columns properly */
            $(".column-list-draggable").sortable({
                handle: ".grip-icon",
                update: function () {
                    const totalCols = table.columns().count();
                    const firstFixed = 0;
                    const lastFixed = totalCols - 1;

                    const newOrder = [firstFixed];
                    $(".column-list-draggable .draggable-item").each(function () {
                        const dataName = $(this).data("col");
                        const colIndex = getColIndex(dataName);
                        if (colIndex >= 1 && colIndex <= lastFixed - 1) {
                            newOrder.push(colIndex);
                        }
                    });
                    newOrder.push(lastFixed);

                    // Apply new order to DataTable
                    table.colReorder.order(newOrder, true);
                    table.state.save();

                    // Sync list visually after reorder
                    syncListWithTable();
                }
            });

            /** 🔁 4. Sync list order when columns are reordered from table */
            table.on('column-reorder', function () {
                syncListWithTable();
            });

            /** 🧭 Helper: sync draggable list order with current table order */
            function syncListWithTable() {
                const order = table.colReorder.order();
                const $list = $(".column-list-draggable");
                const $items = [];

                order.forEach(function (i) {
                    const col = table.column(i);
                    const data = col.dataSrc();
                    if (data !== 'id' && data !== 'actions') {
                        const $item = $list.find(`.draggable-item[data-col="${data}"]`);
                        if ($item.length) $items.push($item);
                    }
                });

                // Rebuild list in same order as DataTable
                $list.append($items);
            }

            /** 🔍 5. Search + filter reload */
            $(document).on('change', '.buylist-filter', () => table.ajax.reload());
            $('#searchInput').on('keyup', () => table.ajax.reload());

            /** 🔄 6. Reset button */
            $('#reset-btn').on('click', function () {
                const $btn = $(this);
                $btn.prop('disabled', true).html('<span class="spinner-grow spinner-grow-sm me-1"></span>Reset');
                $('#searchInput').val('');
                table.state.clear();
                table.ajax.reload(() => {
                    $btn.prop('disabled', false).html('Reset');
                });
            });
        });

        // Open edit modal from Buylist DataTable
        $(document).ready(function () {
            let editItemId = null;

            // 🟦 Handle Edit Button Click
            $(document).on('click', '.edit-smart-item', function (e) {
                e.preventDefault();

                const modal = $('#editItemsModal');
                const data = $(this).data();
                editItemId = data.id; // store item ID

                // 🧾 Optional summary fields
                let formattedDate = '-';
                if (data.date) {
                    const dateObj = new Date(data.date);
                    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                    const day = String(dateObj.getDate()).padStart(2, '0');
                    const year = dateObj.getFullYear();
                    formattedDate = `${month}/${day}/${year}`;
                }

                modal.find('#smart-date').text(formattedDate);
                modal.find('#smart-supplier').text(data.supplier ?? '-');
                modal.find('#smart-buy-cost').text(data.cost ? `$${parseFloat(data.cost).toFixed(2)}` : '$0');
                modal.find('#smart-net-cost').text(data.selling_price ? `$${parseFloat(data.selling_price).toFixed(2)}` : '$0');
                modal.find('#smart-roi').text(data.roi ? `${data.roi}%` : '0%');
                modal.find('#smart-bsr').text(data.bsr ?? '-');

                if (data.source_url) {
                    modal.find('#supplier-link').attr('href', data.source_url).show();
                } else {
                    modal.find('#supplier-link').attr('href', '#').hide();
                }

                // 📝 Fill form fields
                modal.find('#editItemsModalLabel').text(data.name ?? '-');
                modal.find('#name').val(data.name ?? '');
                modal.find('#asin').val(data.asin ?? '');
                modal.find('#category').val(data.category ?? '');
                modal.find('#unitsPurchased').val(data.unit_purchased ?? '');
                modal.find('#costPerUnit').val(data.cost ?? '');
                modal.find('#sellingPrice').val(data.selling_price ?? '');
                modal.find('#netProfit').val(data.net_profit ?? '');
                modal.find('#roi').val(data.roi ?? '');
                modal.find('#bsr_ninety').val(data.bsr ?? '');
                modal.find('#msku').val(data.msku ?? '');
                modal.find('#listPrice').val(data.list_price ?? '');
                modal.find('#minPrice').val(data.min ?? '');
                modal.find('#maxPrice').val(data.max ?? '');
                modal.find('#supplier').val(data.supplier ?? '');
                modal.find('#source_url').val(data.source_url ?? '');
                modal.find('#brand').val(data.brand ?? '');
                modal.find('#variation').val(data.variation ?? '');
                modal.find('#promo').val(data.promo ?? '');
                modal.find('#coupon_code').val(data.coupon ?? '');
                modal.find('#product_note').val(data.product_notes ?? '');
                modal.find('#buyerNote').val(data.buyer_notes ?? '');

                // 🪟 Show modal
                modal.modal('show');
            });

            // 🟩 Handle AJAX Form Submit
            $('#edit-items-form').on('submit', function (e) {
                e.preventDefault();

                if (!editItemId) {
                    toastr.error('No item selected for editing.');
                    return;
                }

                const formData = $(this).serializeArray();
                formData.push({ name: 'id', value: editItemId });

                $.ajax({
                    url: '{{ route("orders.updateItem") }}', // <-- Your update route
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            $('#editItemsModal').modal('hide');
                            toastr.success(response.message);
                            $('#rejected-buylist-table').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error(response.message || 'Failed to update item.');
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        toastr.error('Server error occurred.');
                    }
                });
            });
        });

        $(document).ready(function () {
            let selectedItemIds = [];

            // ✅ Single reject click
            $(document).on('click', '.reject-item', function (e) {
                e.preventDefault();
                selectedItemIds = [$(this).data('id')];
                $('#rejectItemModal').modal('show');
            });

            // ✅ Bulk reject click
            $(document).on('click', '.rejectItemsBtn', function (e) {
                e.preventDefault();

                selectedItemIds = $('#rejected-buylist-table tbody input.buylist-checkbox:checked')
                    .map(function () { return $(this).data('id'); }).get();

                if (selectedItemIds.length === 0) {
                    toastr.error('Please select at least one item to reject.');
                    return;
                }

                $('.dropdown-menu').removeClass('show');
                $('#rejectItemModal').modal('show');
            });

            // ✅ Toggle custom reason input
            $(document).on('change', '#select-rejection-reason', function () {
                if ($(this).val() === 'Custom') {
                    $('#customReasonContainer').removeClass('d-none');
                } else {
                    $('#customReasonContainer').addClass('d-none');
                }
            });

            // ✅ Save reject reason (single or bulk)
            $('#rejectItemSave').on('click', function () {
                const selectedReason = $('#select-rejection-reason').val();
                const customReason = $('#customReason').val();
                const finalReason = selectedReason === 'Custom' ? customReason : selectedReason;

                if (!finalReason) {
                    toastr.error('Please select or enter a reason.');
                    return;
                }

                if (selectedItemIds.length === 0) {
                    toastr.error('No items selected.');
                    return;
                }

                $.ajax({
                    url: '{{ route("orders.rejectItemsBulk") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: selectedItemIds,
                        reason: finalReason
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#rejectItemModal').modal('hide');
                            toastr.success('Items rejected successfully.');
                            $('#rejected-buylist-table').DataTable().ajax.reload();
                        } else {
                            toastr.error('Failed to reject items.');
                        }
                    },
                    error: function () {
                        toastr.error('Server error.');
                    }
                });
            });

            // ✅ Select all checkboxes
            $(document).on('change', '#selectAll', function () {
                const checked = $(this).is(':checked');
                $('#rejected-buylist-table tbody input.buylist-checkbox').prop('checked', checked);
                updateSelectionUI();
            });

            // ✅ Handle single checkbox
            $(document).on('change', '#rejected-buylist-table tbody input.buylist-checkbox', function () {
                const allChecked =
                    $('#rejected-buylist-table tbody input.buylist-checkbox').length ===
                    $('#rejected-buylist-table tbody input.buylist-checkbox:checked').length;

                $('#selectAll').prop('checked', allChecked);
                updateSelectionUI();
            });

            // ✅ Update selection count and button
            function updateSelectionUI() {
                const count = $('#rejected-buylist-table tbody input.buylist-checkbox:checked').length;
                $('#selectedCount').text(count);

                if (count > 0) {
                    $('#select-count-section').removeClass('d-none');
                } else {
                    $('#select-count-section').addClass('d-none');
                }
            }

            // ✅ Reset when DataTable reloads
            $('#rejected-buylist-table').on('draw.dt', function () {
                $('#selectAll').prop('checked', false);
                updateSelectionUI();
            });

            // ✅ SINGLE DELETE
            $(document).on('click', '.delete-buylist-item', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This item will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/buylist/${id}`,
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire('Deleted!', response.message || 'Item deleted.', 'success');
                                    $('#rejected-buylist-table').DataTable().ajax.reload();
                                } else {
                                    Swal.fire('Failed!', response.message || 'Could not delete the item.', 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error', 'Server error. Please try again later.', 'error');
                            }
                        });
                    }
                });
            });

            // ✅ BULK DELETE
            $(document).on('click', '.bulkDelBtn', function (e) {
                e.preventDefault();

                let ids = $('#rejected-buylist-table tbody input.buylist-checkbox:checked')
                    .map(function () { return $(this).data('id'); }).get();

                if (ids.length === 0) {
                    toastr.error('Please select at least one item to delete.');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete ${ids.length} item(s).`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete all!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("buylist.bulkDelete") }}', // ✅ create this route
                            method: 'POST',
                            data: { _token: '{{ csrf_token() }}', ids: ids },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire('Deleted!', response.message || 'Items deleted successfully.', 'success');
                                    $('#rejected-buylist-table').DataTable().ajax.reload();
                                    updateSelectionUI();
                                } else {
                                    Swal.fire('Failed!', response.message || 'Failed to delete items.', 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error', 'Server error. Please try again later.', 'error');
                            }
                        });
                    }
                });
            });
        });

        // ✅ Single duplicate click
        $(document).on('click', '.duplicate-item', function (e) {
            e.preventDefault();
            const id = $(this).data('id');

            Swal.fire({
                title: 'Duplicate this item?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, duplicate it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/buylist/${id}/duplicate`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $('#rejected-buylist-table').DataTable().ajax.reload();
                            } else {
                                toastr.error(response.message || 'Duplication failed.');
                            }
                        },
                        error: function () {
                            toastr.error('Server error.');
                        }
                    });
                }
            });
        });

        $(document).ready(function () {

            $(document).on('click', '.move-item', function (e) {
                e.preventDefault();

                let itemId = $(this).data('id');

                $('#selectedItemIds').val(itemId);
                $('#moveItemCount').text('(1)');
                $('#moveToBuylistModal').modal('show');
            });

            // Bulk move click
            $(document).on('click', '.bulkMoveBtn', function (e) {
                e.preventDefault();

                let selectedIds = $('#rejected-buylist-table tbody input[type="checkbox"]:checked')
                    .map(function () { return $(this).data('id'); }).get();

                if (selectedIds.length === 0) {
                    Swal.fire('No Items Selected', 'Please select at least one item to move.', 'warning');
                    return;
                }

                $('#selectedItemIds').val(selectedIds.join(','));
                $('#moveItemCount').text(`(${selectedIds.length})`);
                $('#moveToBuylistModal').modal('show');
            });

            // Submit form
            $('#moveToBuylistForm').submit(function (e) {
                e.preventDefault();

                let buylistId = $('#targetBuylist').val();
                let itemIds = $('#selectedItemIds').val();

                if (!buylistId) {
                    Swal.fire('Required', 'Please select a target buylist.', 'error');
                    return;
                }

                $.ajax({
                    url: "{{ route('buylist.moveItems') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        buylist_id: buylistId,
                        item_ids: itemIds
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire('Moved!', res.message, 'success');
                            $('#moveToBuylistModal').modal('hide');
                            $('#rejected-buylist-table').DataTable().ajax.reload();
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                });
            });
        });

        $(document).ready(function () {
            $('#createBuylistBtn').on('click', function () {
                let name = $('#buylist_name').val().trim();

                if (!name) {
                    Swal.fire('Required', 'Please enter a buylist name.', 'warning');
                    return;
                }

                $.ajax({
                    url: "{{ route('buylist.store') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: name
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire('Created!', res.message, 'success');
                            $('#createBuylistModal').modal('hide');
                            $('#buylist_name').val('');

                            // Append new buylist to dropdown instantly
                            $('.column-list').append(`
                                <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                                    <div class="d-flex align-items-center">
                                        <input class="form-check-input me-2 buylist-filter" type="checkbox" value="${res.data.id}" id="list-${res.data.id}" checked>
                                        <label class="form-check-label mb-0" for="list-${res.data.id}">${res.data.name}</label>
                                    </div>
                                    <div class="column-actions d-none position-absolute end-0 top-50 translate-middle-y">
                                        <button class="btn btn-sm btn-outline-danger delete-buylist" data-id="${res.data.id}"><i class="ti ti-trash"></i></button>
                                    </div>
                                </div>
                            `);
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong while creating buylist.', 'error');
                    }
                });
            });

            // Delete Buylist
            $(document).on('click', '.delete-buylist', function (e) {
                e.preventDefault();
                let btn = $(this);
                let id = btn.data('id');

                Swal.fire({
                    title: 'Delete Buylist?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/buylist/${id}/delete`, // ✅ your delete route
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (res) {
                                if (res.success) {
                                    Swal.fire('Deleted!', res.message, 'success');
                                    btn.closest('.column-item').remove();
                                } else {
                                    Swal.fire('Error', res.message, 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error', 'Failed to delete buylist.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection