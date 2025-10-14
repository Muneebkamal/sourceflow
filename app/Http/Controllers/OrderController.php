<?php

namespace App\Http\Controllers;

use App\Models\LineItem;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('orders.index');
    }

    public function getData(Request $request)
    {
        $orders = Order::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $orders->where(function($query) use ($search) {
                $query->where('order_id', 'like', "%{$search}%")
                    ->orWhere('source', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status != 'all') {
            $orders->where('status', $request->status);
        }

        // 3. Date range filter
        if ($request->filled('dateRange')) {
            $dates = explode(' - ', $request->dateRange);
            if (count($dates) === 2) {
                $start = Carbon::parse($dates[0])->startOfDay();
                $end = Carbon::parse($dates[1])->endOfDay();
                $orders->whereBetween('date', [$start, $end]);
            }
        }

        // ======= DATA TABLE =======
        return DataTables::of($orders->select([
                'id',
                'status',
                'order_id',
                'source',
                'date',
                'total',
                'created_at',
                'total_units_purchased',
                'total_units_received',
                'total_units_shipped',
                'unit_errors',
                'note'
            ]))
            ->addColumn('checkbox', fn() => '<input type="checkbox" class="form-check-input">')
            ->editColumn('date', fn($row) => $row->date ? Carbon::parse($row->date)->format('m/d/y') : '-')
            ->editColumn('source', function ($row) {
                if (!$row->source) return '-';
                $source = preg_match('/^https?:\/\//', $row->source) ? $row->source : 'https://' . $row->source;
                return '<a href="' . e($source) . '" target="_blank" class="text-decoration-none">' . e($row->source) . '</a>';
            })
            ->editColumn('status', function ($row) {
                $statuses = [
                    'partially received' => 'warning',
                    'received in full'   => 'success',
                    'ordered'            => 'primary',
                    'draft'              => 'secondary',
                    'closed'             => 'info',
                    'canceled'           => 'danger',
                    'reconcile'          => 'dark',
                    'breakage'           => 'light',
                ];

                $options = '';
                foreach ($statuses as $status => $color) {
                    $selected = $row->status === $status ? 'selected' : '';
                    $options .= '<option value="' . e($status) . '" class="bg-white text-dark" ' . $selected . '>' . ucfirst($status) . '</option>';
                }

                $currentColor = $statuses[$row->status] ?? 'secondary';

                return '<select class="form-select form-select-sm status-select bg-soft-' . $currentColor . ' text-' . $currentColor . '" 
                            data-id="' . e($row->id) . '">' . $options . '</select>';
            })
            ->rawColumns(['status'])
            ->editColumn('order_item_count', function ($order) {
                $badges = [
                    'ordered'  => $order->total_units_purchased,
                    'received' => $order->total_units_received,
                    'shipped'  => $order->total_units_shipped,
                    'errors'   => $order->unit_errors,
                ];

                $colors = [
                    'ordered'  => 'bg-light text-dark',
                    'received' => 'bg-info',
                    'shipped'  => 'bg-success',
                    'errors'   => 'bg-danger',
                ];

                $html = '';
                foreach ($badges as $key => $val) {
                    $html .= $val != 0
                        ? '<span class="badge ' . $colors[$key] . ' me-3" data-bs-toggle="tooltip" title="' . ucfirst($key) . '">' . $val . '</span>'
                        : '<span class="me-3" data-bs-toggle="tooltip" title="' . ucfirst($key) . '">-</span>';
                }

                return '<div class="d-flex justify-content-center align-items-center" style="cursor: pointer;">' . $html . '</div>';
            })
            ->addColumn('event', fn() => '-')
            ->addColumn('actions', function ($row) {
                $showUrl = route('order.show', $row->id);
                return '
                    <div class="d-flex justify-content-center gap-1">
                        <a href="' . $showUrl . '" class="btn btn-sm btn-light"><i class="ti ti-eye"></i></a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy</a></li>
                                <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                            </ul>
                        </div>
                    </div>';
            })
            ->rawColumns(['checkbox', 'status', 'source', 'order_item_count', 'actions'])
            ->make(true);
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
        $order = Order::where('id', $id)->first();
        return view('orders.show', compact('order'));
    }

    public function getOrderItems($orderId)
    {
        $items = LineItem::where('order_id', $orderId)->get();

        return DataTables::of($items)
            ->addColumn('checkbox', fn($row) =>
                '<input type="checkbox" class="form-check-input">'
            )
            ->addColumn('image', fn($row) =>
                '<img src="' . asset('storage/products-imgs/' . $row->product_id . '/thumb.jpg') . '" width="50" class="rounded">'
            )
            ->addColumn('name', fn($row) =>
                e($row->name ?? '-')
            )
            ->addColumn('variation_details', fn($row) =>
                e($row->variation_details ?? '-')
            )
            ->addColumn('asin', fn($row) =>
                $row->asin
                    ? '<a href="https://www.amazon.com/dp/' . e($row->asin) . '" target="_blank">' . e($row->asin) . '</a>'
                    : '-'
            )
            ->addColumn('msku', fn($row) => e($row->msku ?? '-'))
            ->addColumn('qty', fn($row) => e($row->unit_purchased ?? 0))

            ->addColumn('cost', function ($row) {
                $buyCost = floatval($row->buy_cost ?? 0);
                return '$' . number_format($buyCost, 2);
            })

            ->addColumn('sku_total', function ($row) {
                $buyCost = floatval($row->buy_cost ?? 0);
                $qty = intval($row->unit_purchased ?? 1);

                // ✅ sku_total = buy_cost * qty
                $lineTotal = $buyCost * $qty;

                return '$' . number_format($lineTotal, 2);
            })

            ->addColumn('orlef', function ($row) {
                $ordered  = intval($row->total_units_purchased ?? 0);
                $received = intval($row->total_units_received ?? 0);
                $listed   = intval($row->total_units_shipped ?? 0);
                $error    = intval($row->unit_errors ?? 0);
                $fixed    = intval($row->units_fixed ?? 0);

                $orderedBadge = $ordered != 0 
                    ? '<span class="badge bg-light text-dark me-2" data-bs-toggle="tooltip" title="Ordered">'.$ordered.'</span>' 
                    : '<span class="me-2" data-bs-toggle="tooltip" title="Ordered">-</span>';

                $receivedBadge = $received != 0 
                    ? '<span class="badge bg-info me-2" data-bs-toggle="tooltip" title="Received">'.$received.'</span>' 
                    : '<span class="me-2" data-bs-toggle="tooltip" title="Received">-</span>';

                $listedBadge = $listed != 0 
                    ? '<span class="badge bg-success me-2" data-bs-toggle="tooltip" title="Listed">'.$listed.'</span>' 
                    : '<span class="me-2" data-bs-toggle="tooltip" title="Listed">-</span>';

                $errorBadge = $error != 0 
                    ? '<span class="badge bg-danger me-2" data-bs-toggle="tooltip" title="Error">'.$error.'</span>' 
                    : '<span class="me-2" data-bs-toggle="tooltip" title="Error">-</span>';

                $fixedBadge = $fixed != 0 
                    ? '<span class="badge bg-primary me-2" data-bs-toggle="tooltip" title="Fixed">'.$fixed.'</span>' 
                    : '<span class="me-2" data-bs-toggle="tooltip" title="Fixed">-</span>';

                return '
                    <div class="d-flex justify-content-center align-items-center text-nowrap">
                        ' . $orderedBadge . '
                        ' . $receivedBadge . '
                        ' . $listedBadge . '
                        ' . $errorBadge . '
                        ' . $fixedBadge . '
                    </div>';
            })
            ->addColumn('product_note', fn($row) => e($row->product_note ?? '-'))
            ->addColumn('buyer_note', fn($row) => e($row->product_buyer_notes ?? '-'))
            ->addColumn('actions', function ($row) {
                return '
                    <div class="d-flex justify-content-center gap-1">
                        <a href="#" class="btn btn-sm btn-light"><i class="ti ti-eye"></i></a>
                        <a href="#" class="btn btn-sm btn-light"><i class="ti ti-plus"></i></a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Edit Item</a></li>
                                <li><a class="dropdown-item" href="#">Duplicate Item</a></li>
                                <li><a class="dropdown-item text-danger" href="#">Delete Item</a></li>
                            </ul>
                        </div>
                    </div>';
            })
            ->addColumn('raw', fn($row) => [
                'id' => $row->id,
                'product_id' => $row->product_id,
                'name' => $row->name,
                'asin' => $row->asin,
                'variation_details' => $row->variation_details,
                'msku' => $row->msku,
                'qty' => $row->unit_purchased,
                'cost' => $row->buy_cost,
                'selling_price' => $row->selling_price,
                'net_profit' => $row->net_profit,
                'list_price' => $row->list_price,
                'min' => $row->min,
                'max' => $row->max,
                'roi' => $row->roi,
                'source_url' => $row->source_url,
                'promo' => $row->promo,
                'coupon_code' => $row->coupon_code,
                'bsr' => $row->bsr,
                'buy_cost' => $row->buy_cost,
                'category' => $row->category,
                'supplier' => $row->supplier,
                'create_at' => $row->created_at ? $row->created_at->format('m/d/Y') : null,
                'product_note' => $row->product_note,
                'buyer_note' => $row->product_buyer_notes,
                'image' => asset('storage/products-imgs/' . $row->product_id . '/thumb.jpg'),
            ])
            ->rawColumns(['checkbox', 'image', 'asin', 'orlef', 'actions'])
            ->make(true);
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
