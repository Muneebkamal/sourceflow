<?php

namespace App\Http\Controllers;

use App\Models\Buylist;
use App\Models\LineItem;
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

        $query = LineItem::where('is_buylist', '1')
            ->whereIn('buylist_id', $request->buylist_ids);

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
            ->addColumn('actions', function ($b) {
                return '
                    <div class="d-flex justify-content-center gap-1">
                        <button class="btn btn-sm btn-success"><i class="ti ti-currency-dollar"></i></button>
                        <button class="btn btn-sm btn-light"><i class="ti ti-external-link"></i></button>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy</a></li>
                                <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                            </ul>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['name', 'asin', 'image', 'variations', 'supplier', 'actions'])
            ->make(true);
    }

    public function getDataRejected(Request $request)
    {
        if (!$request->has('buylist_ids') || empty($request->buylist_ids)) {
            return DataTables::of(collect())->make(true);
        }

        $query = LineItem::with('createdBy')->where('is_buylist', '1')->where('is_rejected', '1')
            ->whereIn('buylist_id', $request->buylist_ids);

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
                return '
                    <div class="d-flex justify-content-center gap-1">
                        <button class="btn btn-sm btn-success"><i class="ti ti-currency-dollar"></i></button>
                        <button class="btn btn-sm btn-light"><i class="ti ti-external-link"></i></button>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="ti ti-copy me-2"></i>Copy</a></li>
                                <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                            </ul>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['name', 'asin', 'image', 'variations', 'supplier', 'actions'])
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
