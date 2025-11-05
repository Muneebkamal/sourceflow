<?php

namespace App\Http\Controllers;

use App\Models\Buylist;
use App\Models\Lead;
use App\Models\LineItem;
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
        $buylist = Buylist::all();
        return view('smart-data.index', compact('tags', 'buylist'));
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
                ->addColumn('checkbox', fn($lead) => '<input type="checkbox" class="form-check-input smart-data-checkbox" data-id="'.$lead->id.'">')

                // 🖼️ Static image (no image column in DB)
                ->addColumn('image', fn() => '<img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="60">')

                ->addColumn('type', function ($lead) {
                    // ICON + COLOR BASED ON TYPE
                    $typeIcon = '';

                    if ($lead->type == 'normal') {
                        $typeIcon = '<i class="ti ti-trophy text-warning fs-4 me-1" data-bs-toggle="tooltip"
                        title="Normal"></i>';
                    } elseif ($lead->type == 'bonus') {
                        $typeIcon = '<i class="ti ti-sparkles text-primary fs-4 me-1" data-bs-toggle="tooltip"
                        title="Bouns"></i>';
                    }

                    if ($lead->is_replenishable) {
                        $typeIcon .= '<i class="ti ti-leaf text-success fs-4 me-1" data-bs-toggle="tooltip"
                        title="Replenishable"></i>';
                    }

                    if ($lead->is_hazmat) {
                        $typeIcon .= '<i class="ti ti-alert-triangle fs-4 text-danger me-1" data-bs-toggle="tooltip"
                        title="Hazmat"></i>';
                    }

                    if ($lead->is_caution) {
                        $typeIcon .= '<i class="ti ti-circle-minus fs-4 text-danger me-1" data-bs-toggle="tooltip"
                        title="Caution"></i>';
                    }


                    return '
                        <div class="d-flex align-items-center flex-wrap gap-1">

                            <!-- ✅ SHOW ICONS BEFORE BUTTON -->
                            <div class="lead-type-icons-'.$lead->id.'">'.$typeIcon.'</div>

                            <div class="dropdown">
                                <button class="btn btn-sm btn-soft-primary dropdown-toggle drop-arrow-none add-type-btn"
                                    type="button"
                                    data-id="' . $lead->id . '"
                                    data-bs-auto-close="outside"
                                    data-bs-toggle="dropdown">
                                    <i class="ti ti-plus"></i> Add Type
                                </button>

                                <div class="dropdown-menu p-0" style="min-width:250px;">

                                    <div class="card m-0 border-0">
                                        <div class="card-header py-2 bg-light">
                                            <h6 class="mb-0">Lead Type</h6>
                                        </div>

                                        <div class="card-body p-2">

                                            <!-- Normal -->
                                            <div class="form-check mb-1">
                                                <input class="form-check-input lead-type-radio"
                                                    type="radio"
                                                    id="normal_'.$lead->id.'"
                                                    name="type_'.$lead->id.'"
                                                    value="normal"
                                                    '.($lead->type == "normal" ? "checked" : "").'>
                                                <label class="form-check-label" for="normal_'.$lead->id.'">Normal</label>
                                            </div>

                                            <!-- Bonus -->
                                            <div class="form-check mb-1">
                                                <input class="form-check-input lead-type-radio"
                                                    type="radio"
                                                    id="bonus_'.$lead->id.'"
                                                    name="type_'.$lead->id.'"
                                                    value="bonus"
                                                    '.($lead->type == "bonus" ? "checked" : "").'>
                                                <label class="form-check-label" for="bonus_'.$lead->id.'">Bonus</label>
                                            </div>

                                            <!-- Replenishable -->
                                            <div class="form-check mb-1">
                                                <input class="form-check-input lead-type-check"
                                                    type="checkbox"
                                                    data-field="is_replenishable"
                                                    '.($lead->is_replenishable ? "checked" : "").'>
                                                <label class="form-check-label">Replenishable
                                                </label>
                                            </div>

                                            <!-- Hazmat -->
                                            <div class="form-check mb-1">
                                                <input class="form-check-input lead-type-check"
                                                    type="checkbox"
                                                    data-field="is_hazmat"
                                                    '.($lead->is_hazmat ? "checked" : "").'>
                                                <label class="form-check-label">Hazmat</label>
                                            </div>

                                            <!-- Caution -->
                                            <div class="form-check mb-1">
                                                <input class="form-check-input lead-type-check"
                                                    type="checkbox"
                                                    data-field="is_caution"
                                                    '.($lead->is_caution ? "checked" : "").'>
                                                <label class="form-check-label">Caution</label>
                                            </div>

                                        </div>

                                        <div class="card-footer d-flex justify-content-end gap-2 py-2">
                                            <button type="button" class="btn btn-sm btn-light close-dropdown-btn">Close</button>
                                            <button type="button" class="btn btn-sm btn-primary save-type-btn" data-id="' . $lead->id . '">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                })

                ->addColumn('tags', function ($lead) {
                    $tags = Tag::all();
                    $leadTagIds = $lead->tags 
                    ? explode(',', $lead->tags) 
                    : [];
                    
                    $selectedBadges = '';
                    if (!empty($leadTagIds)) {
                        foreach ($leadTagIds as $tagId) {
                            $t = $tags->where('id', $tagId)->first();
                            if ($t) {
                                $selectedBadges .= '<span class="badge bg-'.$t->color.'-subtle text-'.$t->color.' fw-semibold me-1 mb-1">'
                                                . $t->name . '</span>';
                            }
                        }
                    }

                    $buttonText = empty($leadTagIds) 
                        ? '<i class="ti ti-plus"></i> Add Tags' 
                        : 'Manage Tags';

                    $html = '
                        <div>
                            <div class="mb-1">'.$selectedBadges.'</div> 
                            <div class="dropdown">
                                <button class="btn btn-sm btn-soft-primary dropdown-toggle drop-arrow-none add-tag-btn"
                                        type="button"
                                        data-id="' . $lead->id . '"
                                        data-bs-auto-close="outside"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    '.$buttonText.'
                                </button>

                                <div class="dropdown-menu p-0" style="min-width:250px;">
                                    <div class="card m-0 border-0">
                                        <div class="card-header py-2 bg-light">
                                            <h6 class="mb-0">Lead Tags</h6>
                                        </div>
                                        <div class="card-body p-2">
                    ';

                    foreach ($tags as $tag) {
                        $checked = in_array($tag->id, $leadTagIds) ? 'checked' : '';
                        $html .= '
                            <div class="form-check mb-1">
                                <input class="form-check-input lead-tag-checkbox"
                                    type="checkbox" '.$checked.'
                                    id="tag_'.$tag->id.'_'.$lead->id.'"
                                    value="'.$tag->id.'">
                                <label class="form-check-label badge bg-'.$tag->color.'-subtle text-'.$tag->color.' fw-semibold"
                                    for="tag_'.$tag->id.'_'.$lead->id.'">
                                    '.$tag->name.'
                                </label>
                            </div>
                        ';
                    }

                    $html .= '
                                        </div>
                                        <div class="card-footer d-flex justify-content-end gap-2 py-2">
                                            <button type="button" class="btn btn-sm btn-light close-dropdown-btn" data-id="' . $lead->id . '">Close</button>
                                            <button type="button" class="btn btn-sm btn-primary save-tags-btn" data-id="' . $lead->id . '">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';

                    return $html;
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
                        <div class="d-flex justify-content-center flex-column gap-1 actions-buttons">
                            <button class="btn btn-sm btn-success movetobuylist" data-id="' . $lead->id . '"><i class="ti ti-currency-dollar"></i></button>
                            <a href="' . e($url) . '" class="btn btn-sm btn-light"><i class="ti ti-external-link"></i></a>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item copyNameBtn" href="#" data-name="' . e($lead->name) . '">
                                        <i class="ti ti-copy me-2"></i> Copy to Clipboard
                                    </a></li>
                                    <li><a class="dropdown-item edit-lead-modal" data-id="' . $lead->id . '" href="#">
                                        <i class="ti ti-edit me-2"></i> Edit Item Details
                                    </a></li>
                                    <li><a class="dropdown-item delSingleSmartData" data-id="'. $lead->id .'" href="#">
                                        <i class="ti ti-trash text-danger me-2"></i> Delete Lead
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    ';
                })
                ->rawColumns(['checkbox', 'image', 'type', 'tags', 'name', 'asin', 'supplier', 'actions'])
                ->make(true);
        }
    }

    public function showSmartData($id)
    {
        try {
            $lead = Lead::findOrFail($id);

            $lead->image_url = $lead->image_url ?? 'https://app.sourceflow.io/storage/images/no-image-thumbnail.png';
            $buylist = LineItem::whereIn('lead_id', [$lead->id])
                ->whereNotNull('buylist_id')
                ->get();

            $buylistIds = $buylist->pluck('buylist_id')->toArray();

            return response()->json([
                'success' => true,
                'lead' => $lead,
                'buylist_ids' => $buylistIds
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lead not found.'
            ], 404);
        }
    }

    public function addItem(Request $request)
    {
        // dd($request->all());
        $lead = Lead::where('id', $request->lead_id)->first();
        try {
            foreach ($request->buylist_ids as $buylistId) {
                LineItem::create([
                    'lead_id' => $request->lead_id,
                    'is_buylist' => 1,
                    'buylist_id' => $buylistId,
                    'name' => $request->name,
                    'asin' => $request->asin,
                    'buy_cost' => $request->buy_cost,
                    'selling_price' => $request->est_selling_price,
                    'unit_purchased' => $request->purchaseQty,
                    'msku' => $request->msku,
                    'list_price' => $request->list_price,
                    'min' => $request->min,
                    'max' => $request->max,
                    'net_profit' => $request->net_profit,
                    'bsr' => $request->bsr_ninety,
                    'source_url' => $request->source_url,
                    'supplier' => $request->supplier,
                    'promo' => $request->promo,
                    'coupon_code' => $request->coupon_code,
                    'product_buyer_notes' => $request->buyer_note,
                    'order_note' => $request->product_note,

                    'category' => $lead->category,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => count($request->buylist_ids) . ' Buy List(s) updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function saveTags(Request $request)
    {
        $lead = Lead::find($request->lead_id);

        if (!$lead) {
            return response()->json(['error' => 'Lead not found']);
        }

        // Save comma separated IDs directly
        $lead->tags = $request->tags;
        $lead->save();

        return response()->json(['success' => true]);
    }

    public function BulkTags(Request $request)
    {
        $leadIds = $request->lead_ids; // array of lead IDs
        $tags = $request->tags;         // string like "1,3,5"

        // Update all leads in one query
        Lead::whereIn('id', $leadIds)->update(['tags' => $tags]);

        return response()->json([
            'success' => true,
            'message' => 'Tags applied to selected leads.'
        ]);
    }

    public function saveType(Request $request)
    {
        $lead = Lead::findOrFail($request->lead_id);

        $lead->type = $request->type;
        $lead->is_replenishable = $request->is_replenishable;
        $lead->is_hazmat = $request->is_hazmat;
        $lead->is_caution = $request->is_caution;

        $lead->save();

        return response()->json(['success' => true]);
    }

    public function updateLead(Request $request)
    {
        try {
            $lead = Lead::findOrFail($request->e_lead_id);

            // Update lead fields
            $lead->name = $request->e_l_name;
            $lead->asin = $request->e_l_asin;
            // $lead->parent_asin = $request->e_l_parent_asin;
            $lead->category = $request->e_l_category;
            $lead->cost = $request->e_l_buy_cost;
            $lead->sell_price = $request->e_l_selling_price;
            $lead->net_profit = $request->e_l_net_profit;
            $lead->roi = $request->e_l_roi;
            $lead->bsr = $request->e_l_bsr_ninety;
            $lead->supplier = $request->e_l_supplier;
            $lead->url = $request->e_l_source_url;
            // $lead->brand = $request->e_l_brand;
            $lead->promo = $request->e_l_promo;
            $lead->coupon = $request->e_l_coupon_code;
            $lead->notes = $request->e_l_product_note;

            $lead->type = $request->type;
            $lead->is_replenishable = $request->is_replenishable;
            $lead->is_hazmat = $request->is_hazmat;
            $lead->is_caution = $request->is_caution;
            $lead->save();

            return response()->json([
                'success' => true,
                'lead' => $lead,
                'message' => 'Lead updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating lead: ' . $e->getMessage()
            ], 500);
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
         $lead = Lead::find($id);

        if (!$lead) {
            return response()->json(['status' => 'error', 'message' => 'Lead not found'], 404);
        }

        $lead->delete();

        return response()->json(['status' => 'success', 'message' => 'Lead deleted']);
    }
}
