<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SmartDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();
        return view('smart-data.index', compact('tags'));
    }

    public function getSmartData(Request $request)
    {
        if ($request->ajax()) {
            $leads = Lead::query();

            // ✅ Search filter
            if (!empty($request->searchValue)) {
                $search = $request->searchValue;
                $type = $request->searchType;

                if ($type === 'name') {
                    $leads->where('name', 'like', "%{$search}%");
                } elseif ($type === 'asin') {
                    $leads->where('asin', 'like', "%{$search}%");
                } elseif ($type === 'source_url') {
                    $leads->where('url', 'like', "%{$search}%");
                } else {
                    $leads->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                        ->orWhere('asin', 'like', "%{$search}%")
                        ->orWhere('url', 'like', "%{$search}%");
                    });
                }
            }

            // ✅ Date range filter
            if (!empty($request->dateRange)) {
                [$start, $end] = explode(' - ', $request->dateRange);
                $leads->whereBetween('date', [
                    Carbon::parse($start)->startOfDay(),
                    Carbon::parse($end)->endOfDay()
                ]);
            }

            // ✅ Numeric filters
            if ($request->chkNetProfit && ($request->net_profit_min || $request->net_profit_max)) {
                $leads->when($request->net_profit_min, fn($q) => $q->where('net_profit', '>=', $request->net_profit_min))
                    ->when($request->net_profit_max, fn($q) => $q->where('net_profit', '<=', $request->net_profit_max));
            }

            if ($request->chkSellingPrice && ($request->sell_price_min || $request->sell_price_max)) {
                $leads->when($request->sell_price_min, fn($q) => $q->where('sell_price', '>=', $request->sell_price_min))
                    ->when($request->sell_price_max, fn($q) => $q->where('sell_price', '<=', $request->sell_price_max));
            }

            // if ($request->chk90DayAvg && ($request->avg90_min || $request->avg90_max)) {
            //     $leads->when($request->avg90_min, fn($q) => $q->where('roi', '>=', $request->avg90_min))
            //         ->when($request->avg90_max, fn($q) => $q->where('roi', '<=', $request->avg90_max));
            // }

            if ($request->chkROI && ($request->roi_min || $request->roi_max)) {
                $leads->when($request->roi_min, fn($q) => $q->where('roi', '>=', $request->roi_min))
                    ->when($request->roi_max, fn($q) => $q->where('roi', '<=', $request->roi_max));
            }

            if ($request->excludeHazmat === 'true') {
                $leads->where('is_hazmat', 1);
            }

            if ($request->excludeDisputed === 'true') {
                $leads->where('is_disputed', 1);
            }


            $leads->orderByDesc('date');

            return DataTables::of($leads)
                ->addColumn('checkbox', fn($lead) => '<input type="checkbox" class="form-check-input">')

                // 🖼️ Static image (no image column in DB)
                ->addColumn('image', fn() => '<img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="60">')

                ->addColumn('type', function ($lead) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle drop-arrow-none" type="button" data-bs-auto-close="outside" id="typeDropdown' . $lead->id . '" data-bs-toggle="dropdown" aria-expanded="false" data-bs-tooltip="tooltip"
                            data-bs-placement="top" title="Add Type">
                                <i class="ti ti-plus"></i>
                            </button>
                            <div class="dropdown-menu p-0" aria-labelledby="typeDropdown' . $lead->id . '" style="min-width: 250px;">
                                <div class="card m-0 border-0">
                                    <div class="card-header py-2 bg-light">
                                        <h6 class="mb-0">Lead Type</h6>
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="radio" name="type_' . $lead->id . '" id="normal_' . $lead->id . '" value="normal">
                                            <label class="form-check-label" for="normal_' . $lead->id . '">Normal</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="radio" name="type_' . $lead->id . '" id="bonus_' . $lead->id . '" value="bonus">
                                            <label class="form-check-label" for="bonus_' . $lead->id . '">Bonus</label>
                                        </div>

                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="replenishable_' . $lead->id . '">
                                            <label class="form-check-label" for="replenishable_' . $lead->id . '">Replenishable</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="hazmat_' . $lead->id . '">
                                            <label class="form-check-label" for="hazmat_' . $lead->id . '">Hazmat</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="disputed_' . $lead->id . '">
                                            <label class="form-check-label" for="disputed_' . $lead->id . '">Caution</label>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end gap-2 py-2">
                                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown">Close</button>
                                        <button type="button" class="btn btn-sm btn-primary save-type-btn" data-id="' . $lead->id . '">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                })

                ->addColumn('tags', function ($lead) {
                    $badges = [];
                    if ($lead->is_hazmat) {
                        $badges[] = '<span class="badge bg-danger">Hazmat</span>';
                    }
                    if ($lead->is_disputed) {
                        $badges[] = '<span class="badge bg-warning text-dark">Disputed</span>';
                    }

                    if (!empty($badges)) {
                        return implode(' ', $badges);
                    }

                    return '
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle drop-arrow-none" type="button" data-bs-auto-close="outside" id="typeDropdown' . $lead->id . '" data-bs-toggle="dropdown" aria-expanded="false" data-bs-tooltip="tooltip"
                            data-bs-placement="top" title="Add Tags">
                                <i class="ti ti-plus"></i>
                            </button>
                            <div class="dropdown-menu p-0" aria-labelledby="typeDropdown' . $lead->id . '" style="min-width: 250px;">
                                <div class="card m-0 border-0">
                                    <div class="card-header py-2 bg-light">
                                        <h6 class="mb-0">Lead Tags</h6>
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="addedToBuyList_{{ $lead->id }}">
                                            <label class="form-check-label badge bg-primary-subtle text-primary fw-semibold" for="addedToBuyList_{{ $lead->id }}">Added to Buy List</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="ann_{{ $lead->id }}">
                                            <label class="form-check-label badge bg-primary-subtle text-primary fw-semibold" for="ann_{{ $lead->id }}">ANN</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="ayadded_{{ $lead->id }}">
                                            <label class="form-check-label badge bg-primary-subtle text-primary fw-semibold" for="ayadded_{{ $lead->id }}">AY ADDED</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="duplicate_{{ $lead->id }}">
                                            <label class="form-check-label badge bg-primary-subtle text-primary fw-semibold" for="duplicate_{{ $lead->id }}">Duplicate</label>
                                        </div>
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="checkbox" id="followup_{{ $lead->id }}">
                                            <label class="form-check-label badge bg-danger-subtle text-danger fw-semibold" for="followup_{{ $lead->id }}">Followup</label>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end gap-2 py-2">
                                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="dropdown">Close</button>
                                        <button type="button" class="btn btn-sm btn-primary save-type-btn" data-id="' . $lead->id . '">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                })
                // 🧮 Static bsr_current
                ->addColumn('bsr_current', fn() => '--')

                ->editColumn('name', function ($lead) {
                    $fullName = e($lead->name);
                    return '
                        <div class="text-truncate-multiline" data-bs-toggle="tooltip" data-bs-placement="top" title="' . $fullName . '">
                            ' . $fullName . '
                        </div>
                    ';
                })

                ->editColumn('date', fn($lead) => Carbon::parse($lead->date)->format('m/d/y'))

                ->editColumn('asin', function ($lead) {
                    if (empty($lead->asin)) {
                        return '--';
                    }
                    $asin = e($lead->asin);
                    $url = "https://www.amazon.com/dp/{$asin}?th=1&psc=1";
                    return '<a href="' . $url . '" target="_blank" class="text-primary text-decoration-none fw-semibold">' . $asin . '</a>';
                })

                ->editColumn('supplier', function ($lead) {
                    if (empty($lead->supplier)) {
                        return '--';
                    }
                    $supplier = e($lead->supplier);
                    $url = $lead->url;

                    if (!empty($url)) {
                        $url = trim((string) $url);
                        if (!Str::startsWith($url, ['http://', 'https://'])) {
                            $url = 'https://' . $url;
                        }

                        return '<a href="' . e($url) . '" target="_blank" 
                                    class="text-primary text-decoration-none fw-semibold" 
                                    data-bs-toggle="tooltip" title="' . e($url) . '">
                                    ' . $supplier . '
                                </a>';
                    }

                    return $supplier ?: '--';
                })

                ->editColumn('cost', fn($lead) => '$' . number_format((float)$lead->cost, 2))
                ->editColumn('sell_price', fn($lead) => '$' . number_format((float)$lead->sell_price, 2))
                ->editColumn('net_profit', fn($lead) => '$' . number_format((float)$lead->net_profit, 2))

                ->editColumn('updated_at', fn($lead) => Carbon::parse($lead->updated_at)->format('m/d/y'))

                ->addColumn('actions', function ($lead) {
                    $url = $lead->url ?: '#';
                    if (!empty($lead->url) && !Str::startsWith($lead->url, ['http://', 'https://'])) {
                        $url = 'https://' . $lead->url;
                    }
                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-sm btn-success"><i class="ti ti-currency-dollar"></i></button>
                            <a href="' . e($url) . '" class="btn btn-sm btn-light"><i class="ti ti-external-link"></i></a>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i> Copy to Clipboard</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i> Edit Item Details</a></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i> Delete Lead</a></li>
                                </ul>
                            </div>
                        </div>
                    ';
                })
                ->rawColumns(['checkbox', 'image', 'type', 'tags', 'name', 'asin', 'supplier', 'actions'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
