@extends('layouts.app')
@section('title', 'Home')
@section('styles')
    <style>
    .dashboard-card {
    border-radius: 12px;
    background-color: #f8f9ff;
    padding: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    height: 100%;
}
.stat-box {
    background-color: #e9edf7;
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    text-align: center;
}
.stat-box label {
    font-size: 0.75rem;
    color: #6c757d;
    margin: 0;
}
.stat-box div {
    font-weight: 600;
    font-size: 1rem;
    margin-top: 0.25rem;
}
.card-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}
.card-header small {
    color: #6c757d;
}
</style>
@endsection
@section('content')

    <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
          <div class="row align-items-center">
            <div class="col-md-6">
              <div class="title">
                <h2>Dashboard (in progress)</h2>
              </div>
            </div>

          </div>
          <!-- end row -->
        </div>
        <!-- Bootstrap 5 + Bootstrap Icons CDN -->

      <!-- Bootstrap 5 + Bootstrap Icons -->



        <div class="row g-3">

            <!-- Today -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="dashboard-card">
                <div class="card-header">
                <i class="bi bi-calendar-event fs-5"></i>
                <div>
                    <h6 class="mb-0">Today</h6>
                    <small id="today-date">--/--/--</small>
                </div>
                </div>
                <div class="row g-2">
                <div class="col-6">
                    <div class="stat-box">
                    <label>Leads Added</label>
                    <div id="today-leads">0</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                    <label>Added to Buy List</label>
                    <div id="today-buy">$0</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                    <label>Ordered Inventory</label>
                    <div id="today-ordered">$0</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                    <label>Shipped Items</label>
                    <div id="today-shipped">0</div>
                    </div>
                </div>
                </div>
            </div>
            </div>

            <!-- This Week -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="dashboard-card">
                <div class="card-header">
                <i class="bi bi-calendar-week fs-5"></i>
                <div>
                    <h6 class="mb-0">This Week</h6>
                    <small id="this-week-date">--/--/-- - --/--/--</small>
                </div>
                </div>
                <div class="row g-2">
                <div class="col-6">
                    <div class="stat-box">
                    <label>Leads Added</label>
                    <div id="week-leads">0</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                    <label>Added to Buy List</label>
                    <div id="week-buy">$0</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                    <label>Ordered Inventory</label>
                    <div id="week-ordered">$0</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                    <label>Shipped Items</label>
                    <div id="week-shipped">0</div>
                    </div>
                </div>
                </div>
            </div>
            </div>

            <!-- Last Week -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="dashboard-card">
                <div class="card-header">
                <i class="bi bi-calendar-week fs-5"></i>
                <div>
                    <h6 class="mb-0">Last Week</h6>
                    <small id="last-week-date">--/--/-- - --/--/--</small>
                </div>
                </div>
                <div class="row g-2">
                <div class="col-6">
                    <div class="stat-box">
                    <label>Leads Added</label>
                    <div id="lastweek-leads">0</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                    <label>Added to Buy List</label>
                    <div id="lastweek-buy">$0</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                    <label>Ordered Inventory</label>
                    <div id="lastweek-ordered">$0</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                    <label>Shipped Items</label>
                    <div id="lastweek-shipped">0</div>
                    </div>
                </div>
                </div>
            </div>
            </div>

            <!-- Last 30 Days -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="dashboard-card">
                <div class="card-header">
                <i class="bi bi-calendar-range fs-5"></i>
                <div>
                    <h6 class="mb-0">Last 30 Days</h6>
                    <small id="last30-date">--/--/-- - --/--/--</small>
                </div>
                </div>
                <div class="row g-2">
                <div class="col-6">
                    <div class="stat-box">
                    <label>Leads Added</label>
                    <div id="last30-leads">0</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                    <label>Added to Buy List</label>
                    <div id="last30-buy">$0</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                    <label>Ordered Inventory</label>
                    <div id="last30-ordered">$0</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-box">
                    <label>Shipped Items</label>
                    <div id="last30-shipped">0</div>
                    </div>
                </div>
                </div>
            </div>
            </div>

        </div>


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
