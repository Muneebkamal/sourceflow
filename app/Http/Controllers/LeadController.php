<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Source;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sources = Source::all();
        $templates = Template::all();
        return view('leads.index', compact('sources', 'templates'));
    }

    public function getData(Request $request)
    {
        $leads = Lead::query();

        if ($request->has('source_id') && $request->source_id) {
            $leads->where('source_id', $request->source_id);
        }

        if ($request->has('search_text') && $request->search_text) {
            $search = $request->search_text;
            $leads->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('asin', 'like', "%{$search}%")
                ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        return DataTables::of($leads)
            ->editColumn('name', function ($lead) {
                $fullName = e($lead->name);
                return "<div class='text-truncate-multiline' data-bs-toggle='tooltip' title='{$fullName}'>{$fullName}</div>";
            })
            ->editColumn('supplier', function ($lead) {
                if (empty($lead->supplier)) return '--';

                $supplier = e($lead->supplier);
                $url = $lead->source_url ?? '';

                if (!empty($url)) {
                    if (!\Illuminate\Support\Str::startsWith($url, ['http://', 'https://'])) {
                        $url = 'https://' . $url;
                    }

                    return "<a href='{$url}' target='_blank' class='text-primary text-decoration-none fw-semibold' data-bs-toggle='tooltip' title='{$url}'>{$supplier}</a>";
                }

                return $supplier;
            })
            ->editColumn('date', fn($lead) => Carbon::parse($lead->date)->format('m/d/y'))
            ->editColumn('cost', fn($b) => '$' . number_format((float)$b->cost, 2))
            ->editColumn('sell_price', fn($lead) => '$' . number_format((float)$lead->sell_price, 2))
            ->editColumn('net_profit', fn($lead) => '$' . number_format((float)$lead->net_profit, 2))
            ->editColumn('created_at', fn($lead) => Carbon::parse($lead->created_at)->format('m/d/y'))
            ->editColumn('updated_at', fn($lead) => Carbon::parse($lead->updated_at)->format('m/d/y'))
            ->addColumn('actions', function ($row) {
                return '
                    <div class="d-flex justify-content-center gap-1">
                        <a href="#" class="btn btn-sm btn-light"><i class="ti ti-eye"></i></a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item edit-lead" href="#" data-id="' . $row->id . '">Edit</a></li>
                                <li><a class="dropdown-item text-danger singleLeadDel" href="#" data-id="' . $row->id . '">Delete</a></li>
                            </ul>
                        </div>
                    </div>';
            })
            ->rawColumns(['name', 'supplier', 'actions'])
            ->make(true);
    }

    public function details($id)
    {
        $template = Template::findOrFail($id);

        // Decode the JSON column
        $mapping = json_decode($template->mapping_template, true);

        // Convert JSON to array of key-value pairs
        $details = [];
        foreach ($mapping as $column => $value) {
            $details[] = [
                'column' => $column,
                'value' => $value ?? '—'
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $details
        ]);
    }

    public function getTemplateMapping($id)
    {
        $template = Template::find($id);

        if (!$template) {
            return response()->json([
                'status'  => false,
                'message' => 'Template not found'
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'mapping' => json_decode($template->mapping_template, true)
        ]);
    }

    public function uploadFile(Request $request){
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        // Store the file
        $filePath = $request->file('file')->store('uploads');
        $fullFilePath = storage_path('app/' . $filePath);

        $file = fopen($fullFilePath, 'r');
        $headers = fgetcsv($file); // CSV headers
        $rows = [];

        while (($row = fgetcsv($file)) !== false) {
            $rows[] = array_combine($headers, $row); // key = column header
        }
        fclose($file);

        // Get database columns (filtered)
        $tableName = 'leads';
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        $excludedColumns = ['id', 'source_id', 'created_at', 'deleted_at', 'updated_at','bundle','createdBy','buyer_id','currency','is_hazmat','is_disputed','tags','msku','created_by'];
        $columns = array_values(array_diff($columns, $excludedColumns));

        return response()->json([
            'headers' => $headers,
            'columns' => $columns,
            'rows' => $rows, // <<< send all CSV data
            'file_path' => $fullFilePath,
        ]);
    }

    public function saveTemplate(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'db_columns' => 'required|array',
            'mapped_columns' => 'required|array',
        ]);

        // Check if template with same name exists
        $templateExists = Template::where('name', $request->name)->exists();
        if ($templateExists) {
            return response()->json(['exists' => true]);
        }

        // Save template
        $template = new Template();
        $template->name = $request->name;
        $template->db_columns = json_encode($request->db_columns);       // All DB columns (with nulls if not mapped)
        $template->mapping_template = json_encode($request->mapped_columns); // Only mapped columns
        $template->save();

        return response()->json([
            'exists' => false,
            'message' => 'Template saved successfully',
            'template' => [
                'id' => $template->id,
                'name' => $template->name
            ]
        ]);
    }

    public function importLeadsFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
            'template_id' => 'required|exists:templates,id',
        ]);

        $template = Template::find($request->template_id);
        $mappedColumns = json_decode($template->mapped_columns, true); // { db_column => csv_column }

        if (!$mappedColumns) {
            return response()->json([
                'status' => false,
                'message' => 'No mapped columns found in template.'
            ]);
        }

        $file = $request->file('file');
        $path = $file->getRealPath();
        
        $success = [];
        $failed = [];

        if (($handle = fopen($path, 'r')) !== false) {
            $headers = fgetcsv($handle); // read CSV header
            $headerIndex = array_flip($headers); // CSV column => index

            while (($row = fgetcsv($handle)) !== false) {
                $leadData = [];

                foreach ($mappedColumns as $dbColumn => $csvColumn) {
                    if (isset($headerIndex[$csvColumn])) {
                        $leadData[$dbColumn] = $row[$headerIndex[$csvColumn]] ?? null;
                    } else {
                        $leadData[$dbColumn] = null;
                    }
                }

                // Validation: asin and url required
                if (empty($leadData['asin']) || empty($leadData['url'])) {
                    $failedRow = $leadData;
                    $failedRow['error'] = 'ASIN or URL missing';
                    $failed[] = $failedRow;
                    continue;
                }

                $leadData['template_id'] = $template->id;
                Lead::create($leadData);
                $success[] = $leadData;
            }

            fclose($handle);
        }

        return response()->json([
            'status' => true,
            'message' => 'Leads processed successfully!',
            'success' => $success,
            'failed' => $failed,
            'success_count' => count($success),
            'failed_count' => count($failed),
        ]);
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

    public function showLead($id)
    {
        $lead = Lead::find($id);

        if (!$lead) {
            return response()->json(['success' => false, 'message' => 'Lead not found']);
        }

        return response()->json(['success' => true, 'data' => $lead]);
    }

    public function saveLead(Request $request)
    {
        try {
            $leadId = $request->lead_id; // hidden field for edit

            $data = [
                'source_id'   => $request->lead_source,
                'name'        => $request->name,
                'asin'        => $request->asin,
                'parent_asin' => $request->parent_asin,
                'category'    => $request->category,
                'cost'        => $request->cost ?? 0,
                'sell_price'  => $request->selling_price ?? 0,
                'net_profit'  => $request->net_profit ?? 0,
                'roi'         => $request->roi ?? 0,
                'supplier'    => $request->supplier,
                'url'         => $request->source_url,
                'bsr'         => $request->bsr_current ?? 0,
                'promo'       => $request->promo,
                'coupon'      => $request->coupon_code,
                'notes'       => $request->list_item_note,
            ];

            if ($leadId) {
                Lead::findOrFail($leadId)->update($data);
                $message = 'Lead updated successfully.';
            } else {
                Lead::create($data);
                $message = 'Lead created successfully.';
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function SourceStore(Request $request)
    {
        $source = Source::create([
            'list_name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lead source created successfully!',
            'data' => $source,
        ]);
    }

    public function bulkMove(Request $request)
    {
        try {
            Lead::whereIn('id', $request->lead_ids)
                ->update(['source_id' => $request->source_id]);

            return response()->json([
                'success' => true,
                'message' => 'Leads moved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to move leads: ' . $e->getMessage()
            ]);
        }
    }

    public function bulkPublishDate(Request $request)
    {
        try {
            // Convert datetime to date
            $dateOnly = date('Y-m-d', strtotime($request->publish_time));

            Lead::whereIn('id', $request->lead_ids)
            ->update(['date' => $dateOnly]);

            return response()->json([
                'success' => true,
                'message' => 'Publish date updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update publish date.',
            ]);
        }
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

    public function moveOrDeleteLead(Request $request)
    {
        try {
            $lead = Lead::findOrFail($request->lead_id);

            if ($request->move && $request->filled('source_id')) {
                $lead->source_id = $request->source_id;
                $lead->save();

                return response()->json(['success' => true, 'message' => 'Lead moved successfully.']);
            } else {
                $lead->delete();
                return response()->json(['success' => true, 'message' => 'Lead deleted successfully.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $leadIds = (array) $request->lead_ids;

            if (empty($leadIds)) {
                return response()->json(['success' => false, 'message' => 'No leads selected.']);
            }

            Lead::whereIn('id', $leadIds)->delete();

            return response()->json(['success' => true, 'message' => 'Selected leads deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function deleteSource(Request $request)
    {
        $source = Source::find($request->source_id);

        if (!$source) {
            return response()->json(['success' => false, 'message' => 'Source not found.']);
        }

        if ($request->move_leads && $request->target_source_id) {
            // Move leads to another source
            Lead::where('source_id', $source->id)
                ->update(['source_id' => $request->target_source_id]);
        } else {
            // Delete all leads of this source
            Lead::where('source_id', $source->id)->delete();
        }

        $source->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lead list source deleted successfully.'
        ]);
    }
}
