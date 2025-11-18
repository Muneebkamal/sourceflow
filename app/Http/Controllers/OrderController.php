<?php

namespace App\Http\Controllers;

use App\Models\EventLog;
use App\Models\LineItem;
use App\Models\Notification;
use App\Models\Order;
use App\Models\ShipEvent;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use League\Csv\Writer;

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

        $orders->latest('id');

        // ======= DATA TABLE =======
        return DataTables::of($orders->select([
            'id',
            'status',
            'order_id',
            'source',
            'email',
            'date',
            'total',
            'created_at',
            'updated_at',
            'total_units_purchased',
            'total_units_received',
            'total_units_shipped',
            'unit_errors',
            'shipping_cost',
            'card_used',
            'destination',
            'cash_back_source',
            'cash_back_percentage',
            'note'
        ]))
        ->addColumn('checkbox', fn($row) => '<input type="checkbox" class="form-check-input" data-id="' . $row->id . '">')
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
        ->editColumn('created_at', function ($row) {
            return $row->created_at ? Carbon::parse($row->created_at)->format('m/d/Y') : '-';
        })
        ->editColumn('updated_at', function ($row) {
            return $row->updated_at ? Carbon::parse($row->updated_at)->format('m/d/Y') : '-';
        })
        ->addColumn('closed', fn() => '-')
        ->addColumn('supplier', fn() => '-')
        ->addColumn('amount_charged', fn() => '')
        ->addColumn('cashback', fn() => '-')

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
                            <li><a href="' . $showUrl . '" class="dropdown-item" href="#">Edit</a></li>
                            <li><a class="dropdown-item duplicateBtn" data-id="' . $row->id . '" href="#">Duplicate</a></li>
                            <li><a class="dropdown-item text-danger singleDelBtn" data-id="' . $row->id . '" href="#">Delete</a></li>
                        </ul>
                    </div>
                </div>';
        })
        ->rawColumns(['checkbox', 'status', 'source', 'order_item_count', 'actions'])
        ->make(true);
    }

    public function export()
    {
        $orders = Order::all();

        $filename = 'orders-report-' . now()->format('Y-m-d_H-i') . '-' . substr(uniqid(), -5) . '.csv';
        $path = storage_path('app/reports/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $file = fopen($path, 'w');

        $headers = [
            'Created','Order Date','Updated','Closed','Order #','Email','Supplier','Subtotal','Tax','Tax Rate',
            'Shipping','Order Total','Card Used','Amount Charged','Order Status','Destination','Units',
            'Received','Shipped','Errors','Fixed','Order Note','Cash Back Src','Cash Back %','Cash Back'
        ];
        fputcsv($file, $headers);

        foreach ($orders as $order) {
            $row = [
                isset($order->created_at) ? Carbon::parse($order->created_at)->format('m/d/Y') : null,
                isset($order->date) ? Carbon::parse($order->date)->format('m/d/Y') : null,
                isset($order->updated_at) ? Carbon::parse($order->updated_at)->format('m/d/Y') : null,
                isset($order->closed_at) ? Carbon::parse($order->closed_at)->format('m/d/Y') : null,
                $order->order_id ?? null,
                $order->email ?? null,
                $order->supplier_name ?? null,
                $order->subtotal ?? null,
                $order->sale_tax ?? null,
                $order->sale_tax_rate ?? null,
                $order->shipping_cost ?? null,
                $order->total ?? null,
                $order->card_used ?? null,
                $order->amount_charged ?? null,
                $order->status ?? null,
                $order->destination ?? null,
                $order->total_units_purchased ?? null,
                $order->total_units_received ?? null,
                $order->total_units_shipped ?? null,
                $order->unit_errors ?? null,
                $order->fixed ?? null,
                $order->note ?? null,
                $order->cash_back_source ?? null,
                $order->cash_back_percentage ?? null,
                $order->cash_back ?? null,
            ];
            fputcsv($file, $row);
        }

        fclose($file);

        // Save notification
        $notification = Notification::create([
            'title' => 'Orders Report Ready',
            'message' => 'Your report is ready.',
            'file_url' => route('download.report', $filename),
            'file_name' => $filename,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Orders report generated successfully!',
            'notification' => $notification
        ]);
    }

    public function ordersItems()
    {
        $shippings = Shipping::all();
        return view('orders.orders-items', compact('shippings'));
    }

    public function getDataOrdersItems(Request $request)
    {
        // ✅ Start query using join
        $lineItems = LineItem::query()
            ->where('line_items.is_buylist', 0)
            ->join('orders', 'orders.id', '=', 'line_items.order_id')
            ->select([
                'line_items.*',
                'orders.date as order_date',
                // 'orders.order_id as order_id',
                'orders.status as status',
                'orders.subtotal as subtotal',
                'orders.total as order_total',
                'orders.card_used as card_used',
                'orders.destination as destination',
                'orders.note as parent_order_note',
                'orders.email as email',
            ]);

        // ✅ Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $lineItems->where(function($query) use ($search) {
                $query->where('line_items.order_id', 'like', "%{$search}%")
                    ->orWhere('line_items.name', 'like', "%{$search}%");
            });
        }

        // ✅ Status filter
        if ($request->filled('status') && $request->status != 'all') {
            $lineItems->where('orders.status', $request->status);
        }

        // ✅ Date range filter (from orders table)
        if ($request->filled('dateRange')) {
            $dates = explode(' - ', $request->dateRange);
            if (count($dates) === 2) {
                $start = \Carbon\Carbon::parse($dates[0])->startOfDay();
                $end = \Carbon\Carbon::parse($dates[1])->endOfDay();
                $lineItems->whereBetween('orders.date', [$start, $end]);
            }
        }

        // ✅ DataTables
        return DataTables::of($lineItems)
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="form-check-input item-checkbox" data-id="' . $row->id . '">';
            })
            ->editColumn('date', fn($row) => $row->order_date ? \Carbon\Carbon::parse($row->order_date)->format('m/d/y') : '-')
            ->editColumn('source', function ($row) {
                if (!$row->source) return '-';
                $source = preg_match('/^https?:\/\//', $row->source) ? $row->source : 'https://' . $row->source;
                return '<a href="' . e($source) . '" target="_blank" class="text-decoration-none">' . e($row->source) . '</a>';
            })
            ->editColumn('name', function ($b) {
                $fullName = e($b->name);
                return "<div class='text-truncate-multiline' data-bs-toggle='tooltip' title='{$fullName}'>{$fullName}</div>";
            })
            ->editColumn('supplier', function ($b) {
                if (empty($b->supplier)) return '--';

                $supplier = e($b->supplier);
                $url = $b->source_url ?? '';

                if (!empty($url)) {
                    if (!\Illuminate\Support\Str::startsWith($url, ['http://', 'https://'])) {
                        $url = 'https://' . $url;
                    }

                    return "<a href='{$url}' target='_blank' class='text-primary text-decoration-none fw-semibold' data-bs-toggle='tooltip' title='{$url}'>{$supplier}</a>";
                }

                return $supplier;
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

                $color = $statuses[$row->status] ?? 'secondary';

                return '<span class="p-1 fs-5 badge bg-soft-' . $color . ' text-' . $color . '">'
                        . ucfirst($row->status) .
                    '</span>';
            })
            ->editColumn('order_item_count', function ($row) {
                $badges = [
                    'ordered'  => $row->total_units_purchased,
                    'received' => $row->total_units_received,
                    'shipped'  => $row->total_units_shipped,
                    'errors'   => $row->unit_errors,
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
            ->addColumn('image', fn($row) => '<img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="60">')
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? Carbon::parse($row->created_at)->format('m/d/Y') : '-';
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at ? Carbon::parse($row->updated_at)->format('m/d/Y') : '-';
            })
            ->addColumn('actions', function ($row) {
                $showUrl = route('order.show', $row->id);
                $url = $row->source_url;
                return '
                    <div class="d-flex justify-content-center gap-1">
                        <a href="' . $showUrl . '" class="btn btn-sm btn-light"><i class="ti ti-eye"></i></a>
                        <a href="'. $url .'" target="_blank" class="btn btn-sm btn-light">
                            <i class="ti ti-external-link"></i>
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item create-event-btn"
                                    href="#"
                                    data-order-id="' .$row->order_id. '"
                                    data-order-item-id="' .$row->id. '"
                                    data-min="' .$row->min. '"
                                    data-max="' .$row->max. '"
                                    data-list-price="' .$row->list_price. '">
                                    Create Event
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="#">Mark as Fixed</a></li>
                                <li>
                                    <a href="#" 
                                    class="dropdown-item edit-order-item"
                                    data-id="' . $row->id . '"
                                    data-name="' . e($row->name) . '"
                                    data-asin="' . e($row->asin) . '"
                                    data-msku="' . e($row->msku) . '"
                                    data-unit_purchased="' . e($row->unit_purchased) . '"
                                    data-list_price="' . e($row->list_price) . '"
                                    data-category="' . e($row->category) . '"
                                    data-supplier="' . e($row->supplier) . '"
                                    data-cost="' . e($row->buy_cost) . '"
                                    data-selling_price="' . e($row->selling_price) . '"
                                    data-net_profit="' . e($row->net_profit) . '"
                                    data-roi="' . e($row->roi) . '"
                                    data-min="' . e($row->min) . '"
                                    data-max="' . e($row->max) . '"
                                    data-bsr="' . e($row->bsr) . '"
                                    data-source_url="' . e($row->source_url) . '"
                                    data-promo="' . e($row->promo) . '"
                                    data-coupon="' . e($row->coupon_code) . '"
                                    data-date="' . e($row->created_at) . '"
                                    data-product_notes="' . e($row->order_note) . '"
                                    data-buyer_notes="' . e($row->product_buyer_notes) . '">
                                        Edit Item
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>';
            })
            ->rawColumns(['checkbox', 'supplier', 'name', 'status', 'source', 'order_item_count', 'image', 'actions'])
            ->make(true);
    }

    public function ItemsExport()
    {
        $items = LineItem::whereNotNull('order_id')->with('order')
            ->get();

        $filename = 'order-items-report-' . now()->format('Y-m-d_H-i') . '-' . substr(uniqid(), -5) . '.csv';
        $path = storage_path('app/reports/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $file = fopen($path, 'w');

        // CSV headers
        $headers = [
            'Order Date','Order #','Email','Title','ASIN','UPC Code','Brand','MSKU','Cost Per Unit','SKU Total Cost',
            'Subtotal','Order Total','Card Used','Destination','Supplier','Supplier URL','Order Status','Units Purchased',
            'Units Received','Units Shipped','Unit Errors','Units Fixed','Order Note','Product Note','List Price',
            'Min List Price','Max List Price','Buyer Note','Email','Created','ASIN Link','Supplier Link'
        ];
        fputcsv($file, $headers);

        foreach ($items as $item) {
            $row = [
                isset($item->order->date) ? Carbon::parse($item->order->date)->format('m/d/Y') : null,
                $item->order_id ?? null,
                $item->email ?? null,
                $item->name ?? null,
                $item->asin ?? null,
                $item->upc ?? null,
                $item->brand ?? null,
                $item->msku ?? null,
                $item->buy_cost ?? null,
                $item->sku_total ?? null,
                $item->subtotal ?? null,
                $item->total ?? null,
                $item->card_used ?? null,
                $item->destination ?? null,
                $item->supplier ?? null,
                $item->source_url ?? null,
                $item->order->status ?? null,
                $item->total_units_purchased ?? null,
                $item->total_units_received ?? null,
                $item->total_units_shipped ?? null,
                $item->unit_errors ?? null,
                $item->units_fixed ?? null,
                $item->order_note ?? null,
                $item->product_buyer_notes ?? null,
                $item->list_price ?? null,
                $item->min ?? null,
                $item->max ?? null,
                $item->product_buyer_notes ?? null,
                $item->email ?? null,
                isset($item->created_at) ? Carbon::parse($item->created_at)->format('m/d/Y') : null,
                $item->asin ? 'https://www.amazon.com/dp/' . $item->asin : null,
                $item->source_url ?? null,
            ];

            fputcsv($file, $row);
        }

        fclose($file);

        // Create notification
        $notification = Notification::create([
            'title' => 'Order Items Report Ready',
            'message' => 'Your report is ready.',
            'file_url' => route('download.report', $filename),
            'file_name' => $filename,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order Items report generated successfully!',
            'notification' => $notification
        ]);
    }

    public function buyCostCalculator($id)
    {
        $order = Order::where('id', $id)->with('LineItems')->first();
        return view('orders.buy-cost-calculator', compact('order'));
    }

    public function updateItem(Request $request)
    {
        $item = LineItem::find($request->id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found']);
        }

        $item->update([
            'name' => $request->name,
            'asin' => $request->asin,
            'category' => $request->category,
            'msku' => $request->msku,
            'unit_purchased' => $request->unit_purchased,
            'buy_cost' => $request->buy_cost,
            'selling_price' => $request->selling_price,
            'net_profit' => $request->net_profit,
            'roi' => $request->roi,
            'bsr' => $request->bsr_ninety,
            'list_price' => $request->list_price,
            'min' => $request->min,
            'max' => $request->max,
            'supplier' => $request->supplier,
            'source_url' => $request->source_url,
            'brand' => $request->brand,
            'promo' => $request->promo,
            'coupon_code' => $request->coupon_code,
            'order_note' => $request->product_note,
            'product_buyer_notes' => $request->buyer_note,
        ]);

        return response()->json(['success' => true, 'message' => 'Item updated successfully']);
    }

    public function bulkUpdateStatus(Request $request)
    {
        Order::whereIn('id', $request->ids)->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
    {
        try {
            $orderIds = $request->ids;

            if ($request->move_to_buylist) {
                // Move all line items for these orders to Buylist
                $orders = Order::with('LineItems')->whereIn('id', $orderIds)->get();

                foreach ($orders as $order) {
                    foreach ($order->LineItems as $item) {
                        $item->update([
                            'order_id' => null,
                            'is_buylist' => 1,
                        ]);
                    }
                }

                // Delete only the orders themselves
                Order::whereIn('id', $orderIds)->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Orders deleted and items moved to Buylist successfully.'
                ]);
            } else {
                // Delete orders and their items completely
                $orders = Order::with('LineItems')->whereIn('id', $orderIds)->get();

                foreach ($orders as $order) {
                    $order->LineItems()->delete();
                    $order->delete();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Selected orders and their items deleted successfully.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function singleDelete(Request $request)
    {
        try {
            $order = Order::findOrFail($request->id);

            if ($request->move_to_buylist) {
                // Move all line items to Buylist instead of deleting
                foreach ($order->LineItems as $item) {
                    $item->update([
                        'order_id' => null,
                        'is_buylist' => 1,
                    ]);
                }

                // Delete the order record only
                $order->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Order deleted and items moved to Buylist successfully.'
                ]);
            } else {
                // Delete related line items first
                $order->LineItems()->delete();

                // Delete the order
                $order->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Order and its items deleted successfully.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function duplicate(Request $request)
    {
        try {
            $order = Order::findOrFail($request->id);

            $newOrder = $order->replicate();
            $newOrder->order_id = $order->order_id . ' (copy)';
            $newOrder->created_at = now();
            $newOrder->updated_at = now();
            $newOrder->save();

            foreach ($order->LineItems as $item) {
                $newItem = $item->replicate();
                $newItem->order_id = $newOrder->id; 
                $newItem->created_at = now();
                $newItem->updated_at = now();
                $newItem->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Order and line items duplicated successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if (!\Auth::user()->can('view_orders')) {
        //     abort(403);
        // }
        $order = Order::create([
            'status' => 'draft',
            'date' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'orderId' => $order->id,
        ]);
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
        $shippings = Shipping::all();
        $order = Order::where('id', $id)->first();
        return view('orders.show', compact('order', 'shippings'));
    }

    public function getOrderItems($orderId)
    {
        $order = Order::find($orderId);
        $items = LineItem::where('order_id', $orderId)->get();

        return DataTables::of($items)
            ->addColumn('checkbox', fn($row) =>
                '<input type="checkbox" class="form-check-input item-checkbox" data-id="' . $row->id . '" data-buylist_id="' . ($row->buylist_id ?? '') . '">'
            )
            ->addColumn('image', fn($row) => '<img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="60">')
            ->editColumn('name', function ($row) {
                $fullName = e($row->name);
                return "<div class='text-truncate-multiline' data-bs-toggle='tooltip' title='{$fullName}'>{$fullName}</div>";
            })
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

            // ✅ ORDER FIELDS
            ->addColumn('order_id', fn($row) => $order->order_id)
            ->addColumn('order_date', function ($row) use ($order) {
                return $order->date
                    ? \Carbon\Carbon::parse($order->date)->format('m/d/Y')
                    : '-';
            })

            ->addColumn('parent_order_note', fn($row) =>
                e($order->note ?? '-')
            )

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
            ->addColumn('order_note', fn($row) => e($row->order_note ?? '-'))
            ->addColumn('buyer_note', fn($row) => e($row->product_buyer_notes ?? '-'))
            ->addColumn('actions', function ($row) {
                return '
                    <div class="d-flex justify-content-center gap-1">
                        <a href="#" class="btn btn-sm btn-light btn-event-item" 
                        data-order-id="' . $row->order_id . '" 
                        data-order-item-id="' . $row->id . '">
                            <i class="ti ti-eye"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-light create-event-btn" data-bs-toggle="modal" data-bs-target="#createEventModal" data-order-id="'.$row->order_id.'"
                            data-order-item-id="'.$row->id.'" data-min="'.$row->min.'" data-max="'.$row->max.'" data-list-price="'.$row->list_price.'">
                            <i class="ti ti-plus"></i>
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="#" 
                                    class="dropdown-item edit-smart-item"
                                    data-id="' . $row->id . '"
                                    data-name="' . e($row->name) . '"
                                    data-asin="' . e($row->asin) . '"
                                    data-msku="' . e($row->msku) . '"
                                    data-unit_purchased="' . e($row->unit_purchased) . '"
                                    data-list_price="' . e($row->list_price) . '"
                                    data-category="' . e($row->category) . '"
                                    data-supplier="' . e($row->supplier) . '"
                                    data-cost="' . e($row->buy_cost) . '"
                                    data-selling_price="' . e($row->selling_price) . '"
                                    data-net_profit="' . e($row->net_profit) . '"
                                    data-roi="' . e($row->roi) . '"
                                    data-min="' . e($row->min) . '"
                                    data-max="' . e($row->max) . '"
                                    data-bsr="' . e($row->bsr) . '"
                                    data-source_url="' . e($row->source_url) . '"
                                    data-promo="' . e($row->promo) . '"
                                    data-coupon="' . e($row->coupon_code) . '"
                                    data-date="' . e($row->created_at) . '"
                                    data-product_notes="' . e($row->order_note) . '"
                                    data-buyer_notes="' . e($row->product_buyer_notes) . '">
                                        Edit Item
                                    </a>
                                </li>
                                <li><a class="dropdown-item order-item-duplicate" data-id="' . $row->id . '" href="#">Duplicate Item</a></li>
                                <li>
                                    <a class="dropdown-item text-danger delete-order-item"
                                    href="#"
                                    data-id="' . $row->id . '"
                                    data-buylist_id="' . ($row->buylist_id ?? '') . '">
                                    Delete Item
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>';
            })
            ->setRowAttr([
                'data-item-id' => function($row) {
                    return $row->id;
                }
            ])
            ->addColumn('raw', fn($row) => [
                'id' => $row->id,
                'product_id' => $row->product_id,
                'name' => $row->name,
                'asin_input' => $row->asin,
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
                'order_note' => $row->order_note,
                'buyer_note' => $row->product_buyer_notes,
            ])
            ->rawColumns(['checkbox', 'name', 'image', 'order_id', 'order_date', 'parent_order_note', 'asin', 'orlef', 'actions'])
            ->make(true);
    }

    public function duplicateItem($id)
    {
        $item = LIneItem::find($id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }
        $newItem = $item->replicate();
        $newItem->created_at = now();
        $newItem->updated_at = now();
        $newItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Item duplicated successfully'
        ]);
    }

    public function deleteItem($id, Request $request)
    {
        $item = LineItem::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        // ✅ If "Move Back to Buylist" checkbox checked
        if ($request->move_back == 1) {

            // ✅ buylist_id missing → cannot move
            if (!$item->buylist_id) {
                return response()->json([
                    'message' => 'Buylist ID missing — cannot move to buylist'
                ], 400);
            }

            // ✅ Move back to buylist
            $item->is_buylist = 1;
            $item->save();

            return response()->json([
                'message' => 'Item moved back to buylist successfully'
            ]);
        }

        // ✅ Normal delete
        $item->delete();

        return response()->json([
            'message' => 'Item deleted successfully'
        ]);
    }

    public function bulkDeleteItems(Request $request)
    {
        $items = $request->items;  // array of {id, buylist_id}
        $moveBack = $request->move_back;

        foreach ($items as $item) {
            $record = LineItem::find($item['id']);

            if (!$record) continue;

            // ✅ Move back to buylist
            if ($moveBack == 1) {

                // buylist_id missing → error (should not happen because JS checks)
                if (!$item['buylist_id']) {
                    return response()->json([
                        'message' => "Some items missing buylist_id — cannot move"
                    ], 400);
                }

                $record->is_buylist = 1;
                $record->save();
            }
            else {
                // ✅ Normal delete
                $record->delete();
            }
        }

        return response()->json([
            'message' => $moveBack
                ? "Items successfully moved back to buylist"
                : "Items deleted successfully"
        ]);
    }

    public function shipEventStore(Request $request)
    {
        ShipEvent::create([
            'order_id' => $request->order_id,
            'order_item_id' => $request->order_item_id,
            'shipping_batch' => $request->shipping_batch,
            'items' => $request->items,
            'upc_matches_flag' => in_array('upc_matches', $request->qc_check ?? []) ? 1 : 0,
            'title_matches_flag' => in_array('title_matches', $request->qc_check ?? []) ? 1 : 0,
            'image_matches_flag' => in_array('image_matches', $request->qc_check ?? []) ? 1 : 0,
            'description_matches_flag' => in_array('description_matches', $request->qc_check ?? []) ? 1 : 0,

            'expire_date' => $request->expire_date,
            'product_upc' => $request->product_upc,
            'msku_orderride' => $request->msku,
            'min_orverride' => $request->min_list_price,
            'list_price_orverride' => $request->list_price,
            'max_orverride' => $request->max_list_price,
            'shipping_notes' => $request->shipping_notes,
        ]);

        return response()->json(['success' => true]);
    }

    public function logEventStore(Request $request)
    {
        EventLog::create([
            'order_id' => $request->order_id,
            'order_item_id' => $request->order_item_id,
            'issue_type' => $request->eventType,
            'item_quantity' => $request->item_quantity,
            'refund_expected' => $request->refund_expected ?? 0,
            'refund_actual' => $request->refund_actual ?? 0,
            'tracking_number' => $request->tracking_number,
            'cancelled' => $request->cancelled ?? 0,
            'cc_charged' => $request->cc_charged ?? 0,
            'refunded' => $request->refunded ?? 0,
            'received' => $request->received ?? 0,
            'supplier_notes' => $request->supplier_notes,
            'issue_notes' => $request->issue_notes,
        ]);

        return response()->json(['success' => true]);
    }

    public function getEvents($id)
    {
        // Load Event Logs
        $events = EventLog::where('order_id', $id)
            ->with('LineItem')
            ->latest()
            ->get()
            ->map(function ($e) {
                return [
                    'id'          => $e->id,            // ✅ add id
                    'source'      => 'event_log',       // ✅ identify source
                    'type'        => $e->issue_type ?? 'Event Log',
                    'asin'        => $e->LineItem->asin ?? null,
                    'qty'         => $e->item_quantity ?? null,
                    'created_at'  => $e->created_at,
                    'updated_at'  => $e->updated_at,
                ];
            });

        // Load Ship Events
        $shippingEvents = ShipEvent::where('order_id', $id)
            ->with('shippingbatch', 'orderItem')
            ->latest()
            ->get()
            ->map(function ($s) {
                return [
                    'id'          => $s->id,            // ✅ add id
                    'source'      => 'ship_event',       // ✅ identify source
                    'type'        => 'listing',
                    'asin'        => $s->orderItem->asin ?? null,
                    'qty'         => $s->items ?? null,
                    'created_at'  => $s->created_at,
                    'updated_at'  => $s->updated_at,
                ];
            });

        // ✅ Convert to base collection to avoid getKey() error
        $events = collect($events);
        $shippingEvents = collect($shippingEvents);

        // ✅ Now safe
        $allEvents = $events->merge($shippingEvents)
            ->sortByDesc('created_at')
        ->values();
        // Merge
        // $allEvents = $events->merge($shippingEvents);
        // $allEvents = $allEvents->sortByDesc('created_at')->values();

        return response()->json(['data' => $allEvents]);
    }

    public function destroyEvent($id)
    {
        EventLog::findOrFail($id)->delete();
        return response()->json(['status' => true]);
    }

    public function destroyShipEvent($id)
    {
        ShipEvent::findOrFail($id)->delete();
        return response()->json(['status' => true]);
    }

    public function markFixed(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->status = 'received in full';
        $order->save();

        return response()->json(['success' => true]);
    }

    public function getEventsForItem($orderId)
    {
        $items = LineItem::where('order_id', $orderId)->pluck('id');

        $listing = ShipEvent::whereIn('order_item_id', $items)
            ->with('shippingbatch')
            ->orderBy('created_at', 'desc')
            ->get();

        $errors = EventLog::whereIn('order_item_id', $items)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'listing' => $listing,
            'errors'  => $errors
        ]);
    }

    public function getEventEdit($eventType, $id)
    {
        if ($eventType === 'listing') {
            $event = ShipEvent::with('shippingbatch')->findOrFail($id);

            return response()->json([
                'type' => 'listing',
                'data' => $event
            ]);
        }

        // Otherwise EventLog
        $event = EventLog::findOrFail($id);

        return response()->json([
            'type' => $event->issue_type,
            'data' => $event
        ]);
    }

    public function updateEvent(Request $request, $id)
    {
        // dd($request->all());
        $type = $request->event_type;
        if ($type === 'listing') {
            $event = ShipEvent::findOrFail($id);

            $event->update([
                'shipping_batch' => $request->shipping_batch,
                'items' => $request->items,
                'expire_date' => $request->expire_date,
                'product_upc' => $request->product_upc,
                'msku_orderride' => $request->msku,
                'min_orverride' => $request->min_list_price,
                'list_price_orverride' => $request->list_price,
                'max_orverride' => $request->max_list_price,
                'shipping_notes' => $request->shipping_notes,
                'upc_matches_flag' => in_array('upc_matches', $request->edit_qc_check ?? []),
                'title_matches_flag' => in_array('title_matches', $request->edit_qc_check ?? []),
                'image_matches_flag' => in_array('image_matches', $request->edit_qc_check ?? []),
                'description_matches_flag' => in_array('description_matches', $request->edit_qc_check ?? []),
            ]);
        } elseif ($type === 'replace') {
            $log = EventLog::findOrFail($id);
            $log->update([
                'item_quantity'   => $request->item_quantity_replace,
                'tracking_number' => $request->tracking_number_replace,
                'supplier_notes'  => $request->supplier_notes_replace,
                'issue_notes'     => $request->issue_notes_replace,
                'received'        => $request->received_replace ?? 0,
            ]);
        } elseif ($type === 'return') {
            $log = EventLog::findOrFail($id);
            $log->update([
                'item_quantity'   => $request->item_quantity_return,
                'refund_expected' => $request->refund_expected_return ?? 0,
                'refund_actual'   => $request->refund_actual_return ?? 0,
                'tracking_number' => $request->tracking_number_return,
                'supplier_notes'  => $request->supplier_notes_return,
                'issue_notes'     => $request->issue_notes_return,
                'refunded'        => $request->refunded_return ?? 0,
            ]);
        } elseif ($type === 'received') {
            $log = EventLog::findOrFail($id);
            $log->update([
                'item_quantity'   => $request->item_quantity_received,
                'refund_expected' => $request->refund_expected_received ?? 0,
                'refund_actual'   => $request->refund_actual_received ?? 0,
                'tracking_number' => $request->tracking_number_received,
                'supplier_notes'  => $request->supplier_notes_received,
                'issue_notes'     => $request->issue_notes_received,
                'cancelled'       => $request->cancelled_received ?? 0,
                'cc_charged'      => $request->cc_charged_received ?? 0,
                'refunded'        => $request->refunded_received ?? 0,
            ]);
        }

        return response()->json(['success' => true]);
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
        $order = Order::findOrFail($id);
        $order->order_id = $request->order_id;
        $order->date = Carbon::parse($request->date)->format('Y-m-d H:i:s');
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully!',
        ]);
    }

    public function updateInfo(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $order->update([
            'source' => $request->source,
            'email' => $request->email,
            'destination' => $request->destination,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order info updated successfully!',
            'data' => $order
        ]);
    }

    public function updatePayment(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->card_used = $request->card_used;
        $order->total = $request->total;
        $order->cash_back_source = $request->cash_back_source;
        $order->cash_back_percentage = $request->cash_back_percentage;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Payment details updated successfully.']);
    }

    public function updateNote(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->note = $request->note;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order note updated successfully.']);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found.']);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Order status updated successfully.']);
    }

    public function updateFull(Request $request, $orderId)
    {
        // dd($request->all());
        $order = Order::findOrFail($orderId);
        $data = $request->order;

        $formattedDate = \Carbon\Carbon::parse($data['date_ordered'])->format('Y-m-d 00:00:00');

        // 🟢 Update main order
        $order->update([
            'order_id' => $data['order_id'],
            'source' => $data['source'],
            'destination' => $data['destination'],
            'email' => $data['email_used'],
            'pre_tax_discount' => $data['pre_tax_discount'],
            'post_tax_discount' => $data['post_tax_discount'],
            'shipping_cost' => $data['shipping_total'],
            'sales_tax' => $data['sales_tax'],
            'is_sale_tax_shipping' => $data['is_sale_tax_shipping'],
            'sales_tax_rate' => $data['sales_tax_rate'],
            'subtotal' => $data['subtotal'],
            'total' => $data['total'],
            'note' => $data['note'],
            'card_used' => $data['card_used'],
            // 'amount_charged' => $data['amount_charged'],
            'cash_back_source' => $data['cash_back_source'],
            'cash_back_percentage' => $data['cash_back_percentage'],
            'status' => $data['status'],
            'date' => $formattedDate,
        ]);

        // 🟢 Update line items
        foreach ($request->line_items as $item) {
            if (!empty($item['id'])) {
                $lineItem = $order->LineItems()->where('id', $item['id'])->first();

                if ($lineItem) {
                    $lineItem->update([
                        'unit_purchased' => $item['unit_purchased'],
                        'buy_cost' => $item['buy_cost'],
                        'sku_total' => $item['sku_total'],
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }

    public function deleteLineItem(Request $request)
    {
        $lineItem = LineItem::find($request->line_item_id);
        if (!$lineItem) {
            return response()->json(['success' => false, 'message' => 'Line item not found.']);
        }

        if ($request->is_buylist) {
            // Move to buylist
            $lineItem->update([
                'order_id' => null,
                'is_buylist' => 1,
            ]);

            return response()->json(['success' => true, 'message' => 'Item moved to Buylist successfully.']);
        } else {
            // Permanently delete
            $lineItem->delete();

            return response()->json(['success' => true, 'message' => 'Item deleted successfully.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
