<?php

namespace App\Http\Controllers;

use App\Models\OrderFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $file = $request->file('file');

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ]);
        }

        // Get original extension
        $extension = $file->getClientOriginalExtension();

        // Use title as filename
        $title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->title); // sanitize title
        $filename = $title . '.' . $extension;

        // Store file in storage/app/order_attachments/{order_id}/
        $path = $file->storeAs('order_attachments/' . $request->order_id, $filename);

        // Create database record
        $attachment = OrderFile::create([
            'order_id' => $request->order_id,
            'name' => $request->title,
            'path' => $path,
            'note' => $request->note,
            'uploaded_by' => Auth::user()->name ?? 'Admin',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attachment saved successfully!',
            'attachment' => $attachment
        ]);
    }

    public function list($orderId)
    {
        $attachments = OrderFile::where('order_id', $orderId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($att) {
                return [
                    'id' => $att->id,
                    'name' => $att->name,
                    'path' => $att->path,
                    'note' => $att->note,
                    'created_at' => $att->created_at->format('d/m/y'),
                ];
            });

        return response()->json($attachments);
    }

    public function download($id)
    {
        $attachment = OrderFile::findOrFail($id);

        // Full path in storage/app
        $filePath = storage_path('app/' . $attachment->path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $attachment->name);
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
        $attachment = OrderFile::findOrFail($id);

        // Delete the file from storage
        if (Storage::exists('public/' . $attachment->path)) {
            Storage::delete('public/' . $attachment->path);
        }

        // Delete the DB record
        $attachment->delete();

        return response()->json(['success' => true, 'message' => 'Attachment deleted']);
    }
}
