@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Dashboard (in progress)</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                    
                </div>
            </div>
        </div>
    </div>


    <div class="row g-2">

        <!-- Card Template Example -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
            <div class="card-header d-flex align-items-center gap-2 border-0 p-0 px-3 pt-3">
                <div class="badge badge-soft-primary">
                    <i class="ti ti-calendar-event fs-2"></i>
                </div>
                <div>
                <h4 class="mb-0 fw-bold">Today</h4>
                <small id="today-date" class="text-muted">--/--/--</small>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="row g-2 text-center">
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Leads Added</small>
                    <h6 id="today-leads" class="fw-bold mb-0">0</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Added to Buy List</small>
                    <h6 id="today-buy" class="fw-bold mb-0">$0</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Ordered Inventory</small>
                    <h6 id="today-ordered" class="fw-bold mb-0">$0</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Shipped Items</small>
                    <h6 id="today-shipped" class="fw-bold mb-0">0</h6>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>

        <!-- This Week -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
            <div class="card-header d-flex align-items-center gap-2 border-0 p-0 px-3 pt-3">
                <div class="badge badge-soft-primary">
                    <i class="ti ti-calendar-event fs-2"></i>
                </div>
                <div>
                <h4 class="mb-0 fw-bold">This Week</h4>
                <small id="this-week-date" class="text-muted">--/--/-- - --/--/--</small>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="row g-2 text-center">
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Leads Added</small>
                    <h6 id="week-leads" class="fw-bold mb-0">0</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Added to Buy List</small>
                    <h6 id="week-buy" class="fw-bold mb-0">$0</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Ordered Inventory</small>
                    <h6 id="week-ordered" class="fw-bold mb-0">$0</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Shipped Items</small>
                    <h6 id="week-shipped" class="fw-bold mb-0">0</h6>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Last Week -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
            <div class="card-header d-flex align-items-center gap-2 border-0 p-0 px-3 pt-3">
                <div class="badge badge-soft-primary">
                    <i class="ti ti-calendar-event fs-2"></i>
                </div>
                <div>
                <h4 class="mb-0 fw-bold">Last Week</h4>
                <small id="last-week-date" class="text-muted">--/--/-- - --/--/--</small>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="row g-2 text-center">
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Leads Added</small>
                    <h6 id="lastweek-leads" class="fw-bold mb-0">0</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Added to Buy List</small>
                    <h6 id="lastweek-buy" class="fw-bold mb-0">$0</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Ordered Inventory</small>
                    <h6 id="lastweek-ordered" class="fw-bold mb-0">$0</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Shipped Items</small>
                    <h6 id="lastweek-shipped" class="fw-bold mb-0">0</h6>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Last 30 Days -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
            <div class="card-header d-flex align-items-center gap-2 border-0 p-0 px-3 pt-3">
                <div class="badge badge-soft-primary">
                    <i class="ti ti-calendar-event fs-2"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold">Last 30 Days</h4>
                    <small id="last30-date" class="text-muted">--/--/-- - --/--/--</small>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="row g-2 text-center">
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Leads Added</small>
                    <h6 id="last30-leads" class="fw-bold mb-0">0</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Added to Buy List</small>
                    <h6 id="last30-buy" class="fw-bold mb-0">$0</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Ordered Inventory</small>
                    <h6 id="last30-ordered" class="fw-bold mb-0">$0</h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="bg-soft-primary rounded p-2">
                    <small class="text-muted">Shipped Items</small>
                    <h6 id="last30-shipped" class="fw-bold mb-0">0</h6>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-4">Irregular TimeSeries</h4>
                    <div dir="ltr">
                        <div id="area-timeSeries" class="apex-charts" data-colors="#39afd1,#fa5c7c,#727cf5"></div>
                    </div>
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
    </div>

@endsection

@section('scripts')
<!-- Apex Charts js -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/moment/moment.js') }}"></script>
    
    <!-- Apex Chart Area Demo js -->
    <script src="{{ asset('assets2/stock-prices.js') }}"></script>
    <script src="{{ asset('assets2/series1000.js') }}"></script>
    <script src="{{ asset('assets2/github-data.js') }}"></script>
    <script src="{{ asset('assets2/irregular-data-series.js') }}"></script>
    
    

    <!-- Apex Area Chart demo js -->
    <script src="{{ asset('assets/js/pages/chart-apex-area.js') }}"></script>

<script>
    function setDashboardDates() {
    const options = { timeZone: 'America/New_York', year: '2-digit', month: '2-digit', day: '2-digit' };
    const today = new Date().toLocaleDateString('en-US', options);
    document.getElementById('today-date').textContent = today;

    const now = new Date();
    const startOfWeek = new Date(now);
    startOfWeek.setDate(now.getDate() - now.getDay() + 1);
    const endOfWeek = new Date(startOfWeek);
    endOfWeek.setDate(startOfWeek.getDate() + 6);
    document.getElementById('this-week-date').textContent = `${startOfWeek.toLocaleDateString('en-US', options)} - ${endOfWeek.toLocaleDateString('en-US', options)}`;

    const lastWeekStart = new Date(startOfWeek);
    lastWeekStart.setDate(startOfWeek.getDate() - 7);
    const lastWeekEnd = new Date(startOfWeek);
    lastWeekEnd.setDate(startOfWeek.getDate() - 1);
    document.getElementById('last-week-date').textContent = `${lastWeekStart.toLocaleDateString('en-US', options)} - ${lastWeekEnd.toLocaleDateString('en-US', options)}`;

    const last30Start = new Date();
    last30Start.setDate(now.getDate() - 29);
    document.getElementById('last30-date').textContent = `${last30Start.toLocaleDateString('en-US', options)} - ${today}`;
    }
    setDashboardDates();
</script>
@endsection
