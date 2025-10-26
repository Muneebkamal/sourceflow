@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <div class="row mt-2">
        <div class="col-md-12 mt-2">
            <form id="order-form">
                <div class="page-title-head d-flex align-items-sm-start flex-sm-row flex-column" style="height: auto;">
                    <div class="d-flex align-items-center flex-grow-1">
                        <a href="{{ route('shipping.index') }}" class="btn btn-soft-primary"><i class="ti ti-arrow-left fs-2"></i></a>
                        <div class="ms-2" id="order-info">
                            <h4 class="fs-18 fw-semibold m-0">Shipping Batch</span></h4>
                        </div>
                    </div>

                    
                    <div class="mt-3 mt-sm-0">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Shipping Batch Details
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card h-100">
                                        <div class="card-header border-bottom">
                                            <h5 class="mb-0">Batch Info</h5>
                                        </div>

                                        <div class="card-body">
                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Name</span>
                                                <span class="fw-bold text-dark">
                                                    {{ $shipping->name }}
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Status</span>
                                                <span class="fw-bold text-dark">
                                                    {{ $shipping->status }}
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted"># Items</span>
                                                <span class="fw-bold text-dark">
                                                    {{ $shipping->items ?? '-' }}
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Shipping At</span>
                                                <span class="fw-bold text-dark">
                                                    {{ \Carbon\Carbon::parse($shipping->created_at)->format('m/d/y') }}
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Marketplace</span>
                                                <span class="fw-bold text-dark">
                                                    {{ $shipping->market_place }}
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-between pb-2">
                                                <span class="text-muted">Tracking #</span>
                                                <span class="fw-bold text-dark">
                                                    {{ $shipping->tracking_number }}
                                                </span>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <span class="text-muted">Note</span>
                                                <span class="fw-bold text-dark">
                                                    {{ $shipping->notes }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="m-0">Batch Items (<span id="items-count">0</span>)</h4>
            </div>

            <div class="card mt-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="batch-items-table" class="table align-middle w-100 mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-nowrap small">
                                    <th><input type="checkbox" class="form-check-input"></th>
                                    <th>Asin</th>
                                    <th>Product Title</th>
                                    <th>Ship Quantity</th>
                                    <th>MSKU</th>
                                    <th>List Price</th>
                                    <th>Min List Price</th>
                                    <th>Max List Price</th>
                                    <th>Product UPC</th>
                                    <th>Unit Purchased</th>
                                    <th>Purchase Date</th>
                                    <th>Platform</th>
                                    <th>Condition</th>
                                    <th>Shipping Note</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Expiration Date</th>
                                    <th>Actions</th>
                                    {{-- <th class="sticky-col">Actions</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection