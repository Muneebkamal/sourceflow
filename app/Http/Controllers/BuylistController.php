<?php

namespace App\Http\Controllers;

use App\Models\Buylist;
use App\Models\LineItem;
use App\Models\Notification;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BuylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buylist = Buylist::all();
        return view('buylists.index', compact('buylist'));
    }

    public function rejected()
    {
        $buylist = Buylist::all();
        return view('buylists.rejected', compact('buylist'));
    }

    public function getData(Request $request)
    {
        // If no buylist selected → return empty result
        if (!$request->has('buylist_ids') || empty($request->buylist_ids)) {
            return DataTables::of(collect())->make(true);
        }

        $query = LineItem::with('buylist')
            ->where('is_buylist', '1')
            ->where('is_rejected', 0)
            ->whereIn('buylist_id', $request->buylist_ids)
            ->orderByDesc('id');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('asin', 'like', "%{$search}%")
                ->orWhere('supplier', 'like', "%{$search}%");
            });
        }

        $buylist = $query->get();

        return DataTables::of($buylist)
            ->addColumn('image', fn($row) => '<img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="60">')
            ->editColumn('created_at', fn($b) => \Carbon\Carbon::parse($b->created_at)->format('m/d/y'))
            ->editColumn('name', function ($b) {
                $fullName = e($b->name);
                return "<div class='text-truncate-multiline' data-bs-toggle='tooltip' title='{$fullName}'>{$fullName}</div>";
            })
            ->editColumn('buy_cost', fn($b) => '$' . number_format((float)$b->buy_cost, 2))
            ->addColumn('variations', function ($b) {
                $badges = '';
                if ($b->is_hot) $badges .= '<span class="badge bg-primary">Hot</span> ';
                if ($b->is_new) $badges .= '<span class="badge bg-success">New</span>';
                return $badges;
            })
            ->editColumn('asin', function ($b) {
                if (empty($b->asin)) return '--';
                $asin = e($b->asin);
                $url = "https://www.amazon.com/dp/{$asin}?th=1&psc=1";
                return "<a href='{$url}' target='_blank' class='text-primary text-decoration-none fw-semibold'>{$asin}</a>";
            })
            ->editColumn('supplier', function ($b) {
                if (empty($b->supplier)) return '--';
                $supplier = e($b->supplier);
                $url = $b->source_url;
                if ($url) {
                    if (!\Illuminate\Support\Str::startsWith($url, ['http://', 'https://'])) $url = 'https://' . $url;
                    return "<a href='{$url}' target='_blank' class='text-primary text-decoration-none fw-semibold' data-bs-toggle='tooltip' title='{$url}'>{$supplier}</a>";
                }
                return $supplier;
            })
            ->addColumn('buylist_name', function ($b) {
                return $b->buylist ? e($b->buylist->name) : '--';
            })
            ->addColumn('actions', function ($b) {
                $url = $b->source_url;
                $buyCostUrl = $b->order_id ? route('buy.cost.calculator', $b->buylist_id) : '#';

                return '
                    <div class="d-flex justify-content-center gap-1">
                        <a href="'. $url .'" target="_blank" class="btn btn-sm btn-light">
                            <i class="ti ti-external-link"></i>
                        </a>
                        <a href="' . $buyCostUrl . '" target="_blank" class="btn btn-sm btn-light">
                            <i class="ti ti-shopping-cart"></i>
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item text-danger delete-buylist-item" data-id="' . $b->id . '" href="#">
                                        <i class="ti ti-trash me-2"></i>Delete
                                    </a>
                                </li>
                                <li>
                                    <a href="#" 
                                    class="dropdown-item edit-smart-item"
                                    data-id="' . $b->id . '"
                                    data-name="' . e($b->name) . '"
                                    data-asin="' . e($b->asin) . '"
                                    data-msku="' . e($b->msku) . '"
                                    data-unit_purchased="' . e($b->unit_purchased) . '"
                                    data-list_price="' . e($b->list_price) . '"
                                    data-category="' . e($b->category) . '"
                                    data-supplier="' . e($b->supplier) . '"
                                    data-cost="' . e($b->buy_cost) . '"
                                    data-selling_price="' . e($b->selling_price) . '"
                                    data-net_profit="' . e($b->net_profit) . '"
                                    data-roi="' . e($b->roi) . '"
                                    data-min="' . e($b->min) . '"
                                    data-max="' . e($b->max) . '"
                                    data-bsr="' . e($b->bsr) . '"
                                    data-source_url="' . e($b->source_url) . '"
                                    data-promo="' . e($b->promo) . '"
                                    data-coupon="' . e($b->coupon_code) . '"
                                    data-date="' . e($b->created_at) . '"
                                    data-product_notes="' . e($b->order_note) . '"
                                    data-buyer_notes="' . e($b->product_buyer_notes) . '">
                                        <i class="ti ti-edit me-2"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item duplicate-item" data-id="' . $b->id . '" href="#">
                                        <i class="ti ti-copy me-2"></i>Duplicate
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item reject-item" data-id="' . $b->id . '" href="#">
                                        <i class="ti ti-ban me-2"></i>Reject Item
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item move-item" data-id="' . $b->id . '" href="#">
                                        <i class="ti ti-arrow-right me-2"></i>Move to Other Buy List
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['name', 'asin', 'image', 'variations', 'supplier', 'actions'])
            ->make(true);
    }

    public function export()
    {
        $items = LineItem::with('buylist')
            ->where('is_buylist', 1)
            ->where('is_rejected', 0)
            ->whereNotNull('buylist_id')
            ->get();

        $filename = 'buy-list-items-report-' . now()->format('Y-m-d_H-i') . '-' . substr(uniqid(), -5) . '.csv';
        $path = storage_path('app/reports/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $file = fopen($path, 'w');

        $headers = [
            'Date Added','ASIN','Image','Title','Variations','Supplier','Cost','Selling Price','Qty',
            'BSR 90D Avg','Promo','Coupon Code','Product Note','Buyer Note','UPC/GTIN','Brand',
            'Monthly Sold','Offers','Rating','Reviews','Buy List Name','Lead Type','Category',
            'ASIN Link','Supplier Link'
        ];
        fputcsv($file, $headers);

        foreach ($items as $item) {
            $row = [
                isset($item->created_at) ? Carbon::parse($item->created_at)->format('n/j/Y') : null,
                $item->asin ?? null,
                $item->image ?? null,
                $item->name ?? null,
                $item->variations ?? null,
                $item->supplier ?? null,
                $item->buy_cost ?? null,
                $item->selling_price ?? null,
                $item->unit_purchased ?? null,
                $item->bsr ?? null,
                $item->promo ?? null,
                $item->coupon_code ?? null,
                $item->order_note ?? null,
                $item->product_buyer_notes ?? null,
                $item->upc ?? null,
                $item->brand ?? null,
                $item->monthly_sold ?? null,
                $item->offers ?? null,
                $item->rating ?? null,
                $item->reviews ?? null,
                optional($item->buylist)->name ?? null, // Buylist Name
                $item->lead_type ?? null,
                $item->category ?? null,
                $item->asin ? 'https://www.amazon.com/dp/' . $item->asin : null,
                $item->source_url ?? null,
            ];
            fputcsv($file, $row);
        }

        fclose($file);

        // Save notification
        $notification = Notification::create([
            'title' => 'Buy List Report Ready',
            'message' => 'Your report is ready.',
            'file_url' => route('download.report', $filename),
            'file_name' => $filename,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Buy List report generated successfully!',
            'notification' => $notification
        ]);
    }

    public function getDataRejected(Request $request)
    {
        if (!$request->has('buylist_ids') || empty($request->buylist_ids)) {
            return DataTables::of(collect())->make(true);
        }

        $query = LineItem::with('createdBy')->where('is_buylist', '1')->where('is_rejected', '1')
            ->whereIn('buylist_id', $request->buylist_ids)
            ->orderByDesc('id');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('asin', 'like', "%{$search}%")
                ->orWhere('supplier', 'like', "%{$search}%");
            });
        }

        $buylist = $query->get();

        return DataTables::of($buylist)
            ->addColumn('image', fn($row) => '<img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="60">')
            ->editColumn('created_at', fn($b) => \Carbon\Carbon::parse($b->created_at)->format('m/d/y'))
            ->editColumn('name', function ($b) {
                $fullName = e($b->name);
                return "<div class='text-truncate-multiline' data-bs-toggle='tooltip' title='{$fullName}'>{$fullName}</div>";
            })
            ->editColumn('cost', fn($b) => '$' . number_format((float)$b->cost, 2))
            ->addColumn('variations', function ($b) {
                $badges = '';
                if ($b->is_hot) $badges .= '<span class="badge bg-primary">Hot</span> ';
                if ($b->is_new) $badges .= '<span class="badge bg-success">New</span>';
                return $badges;
            })
            ->editColumn('asin', function ($b) {
                if (empty($b->asin)) return '--';
                $asin = e($b->asin);
                $url = "https://www.amazon.com/dp/{$asin}?th=1&psc=1";
                return "<a href='{$url}' target='_blank' class='text-primary text-decoration-none fw-semibold'>{$asin}</a>";
            })
            ->editColumn('supplier', function ($b) {
                if (empty($b->supplier)) return '--';
                $supplier = e($b->supplier);
                $url = $b->source_url;
                if ($url) {
                    if (!\Illuminate\Support\Str::startsWith($url, ['http://', 'https://'])) $url = 'https://' . $url;
                    return "<a href='{$url}' target='_blank' class='text-primary text-decoration-none fw-semibold' data-bs-toggle='tooltip' title='{$url}'>{$supplier}</a>";
                }
                return $supplier;
            })
            ->addColumn('created_by', function ($b) {
                return $b->createdBy?->name ?? '--';
            })
            ->addColumn('actions', function ($b) {
                $url = $b->source_url;
                return '
                    <div class="d-flex justify-content-center gap-1">
                        <a href="'. $url .'" target="_blank" class="btn btn-sm btn-light"><i class="ti ti-external-link"></i></a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item text-danger delete-buylist-item" data-id="' . $b->id . '" href="#">
                                        <i class="ti ti-trash me-2"></i>Delete
                                    </a>
                                </li>
                                <li>
                                    <a href="#" 
                                    class="dropdown-item edit-smart-item"
                                    data-id="' . $b->id . '"
                                    data-name="' . e($b->name) . '"
                                    data-asin="' . e($b->asin) . '"
                                    data-msku="' . e($b->msku) . '"
                                    data-unit_purchased="' . e($b->unit_purchased) . '"
                                    data-list_price="' . e($b->list_price) . '"
                                    data-category="' . e($b->category) . '"
                                    data-supplier="' . e($b->supplier) . '"
                                    data-cost="' . e($b->buy_cost) . '"
                                    data-selling_price="' . e($b->selling_price) . '"
                                    data-net_profit="' . e($b->net_profit) . '"
                                    data-roi="' . e($b->roi) . '"
                                    data-min="' . e($b->min) . '"
                                    data-max="' . e($b->max) . '"
                                    data-bsr="' . e($b->bsr) . '"
                                    data-source_url="' . e($b->source_url) . '"
                                    data-promo="' . e($b->promo) . '"
                                    data-coupon="' . e($b->coupon_code) . '"
                                    data-date="' . e($b->created_at) . '"
                                    data-product_notes="' . e($b->order_note) . '"
                                    data-buyer_notes="' . e($b->product_buyer_notes) . '">
                                        <i class="ti ti-edit me-2"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item duplicate-item" data-id="' . $b->id . '" href="#">
                                        <i class="ti ti-copy me-2"></i>Duplicate
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item move-item" data-id="' . $b->id . '" href="#">
                                        <i class="ti ti-arrow-right me-2"></i>Move to Other Buy List
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['name', 'asin', 'image', 'variations', 'supplier', 'actions'])
            ->make(true);
    }

    public function rejectItemsBulk(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No items selected']);
        }

        LineItem::whereIn('id', $ids)->update([
            'rejection_reason' => $request->reason,
            'is_rejected' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Items rejected successfully']);
    }

    public function duplicateItem($id)
    {
        $item = LineItem::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }

        $duplicate = $item->replicate();
        $duplicate->created_at = now();
        $duplicate->updated_at = now();
        $duplicate->save();

        return response()->json(['success' => true, 'message' => 'Item duplicated successfully.']);
    }

    public function moveItems(Request $request)
    {
        $request->validate([
            'buylist_id' => 'required|exists:buylists,id',
            'item_ids' => 'required|string',
        ]);

        $itemIds = explode(',', $request->item_ids);

        LineItem::whereIn('id', $itemIds)->update([
            'buylist_id' => $request->buylist_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Items moved successfully!']);
    }

    public function createMultipleItemsOrder(Request $request)
    {
        // dd($request->all());
        $itemIds = $request->input('ids', []);
        $order_id = $this->createOrderForItem();
        $units = 0;
        foreach ($itemIds as $id) {
            $item = LineItem::find($id);
            $total_sku = $item ->unit_purchased * $item->buy_cost;
            $item->is_buylist = 0;
            // $item->buylist_id = null;
            $item->sku_total = $total_sku;
            $item->order_id = $order_id;
            $item->save();
            $units += $item->unit_purchased;
        }
        $findOrder = Order::where('id',$order_id)->first();
        $findOrder->total_units_purchased  = $units;
        $findOrder->total = $request->buy_cost * $request->unit_purchased;
        $findOrder->subtotal = $request->buy_cost * $request->unit_purchased;
        $findOrder->save();
        return response()->json(['success' => true, 'message' => 'Orders created successfully.','order_id'=>$order_id]);
    }

    private function createOrderForItem(){
        $order = Order::create([
            'date' => now(),
            'status' => 'ordered',
        ]);
        return $order->id;
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
        $buylist = Buylist::create([
            'name' => $request->name,
            'creatd_by' => auth()->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Buylist created successfully!',
            'data' => $buylist
        ]);
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

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No IDs provided.']);
        }

        try {
            LineItem::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Selected items deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyBuylistItem($id)
    {
        $buylist = LineItem::find($id);

        if (!$buylist) {
            return response()->json(['success' => false, 'message' => 'Item not found.']);
        }

        $buylist->delete();

        return response()->json(['success' => true, 'message' => 'Item deleted successfully.']);
    }

    public function destroy($id)
    {
        $buylist = Buylist::find($id);
        if (!$buylist) {
            return response()->json(['success' => false, 'message' => 'Buylist not found.']);
        }

        $buylist->delete();

        return response()->json(['success' => true, 'message' => 'Buylist deleted successfully!']);
    }

}
