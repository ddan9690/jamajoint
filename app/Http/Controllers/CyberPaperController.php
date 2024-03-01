<?php

namespace App\Http\Controllers;

use App\Models\CyberPaper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CyberPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $cyberpapers = CyberPaper::orderBy('created_at', 'desc')->get();
    return view('backend.cyberpapers.index', compact('cyberpapers'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.cyberpapers.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,xlsx|max:2048',
        ]);


        $file = $request->file('file');

        // Generate a unique file name
        $fileName = Str::slug($request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Store the file in the 'public' disk under the 'uploads/cyber_papers' directory
        $filePath = $file->storeAs('uploads/cyber_papers', $fileName, 'public');

        $cyberPaper = new CyberPaper([
            'name' => $request->name,
            'user_id' => auth()->user()->id,
            'slug' => Str::slug($request->name),
            'file' => $filePath, // Store the file path in the 'file_path' column
        ]);

        $cyberPaper->save();

        return redirect()->route('cyberpapers.index')->with('success', 'Cyber Paper created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(CyberPaper $cyberPaper)
    {
        //
    }

    public function download($id)
{
    $cyberPaper = CyberPaper::findOrFail($id);

    // Get the full file path
    $filePath = storage_path('app/public/' . $cyberPaper->file);

    // Check if the file exists
    if (!file_exists($filePath)) {
        abort(404);
    }

    // Define the headers for the response
    $headers = [
        'Content-Type' => 'application/pdf', // Adjust the content type as needed
    ];

    // Set the file name for download
    $fileName = pathinfo($filePath)['basename'];

    // Use Laravel's response()->download() method to send the file as a download
    return response()->download($filePath, $fileName, $headers);
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CyberPaper $cyberPaper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CyberPaper $cyberPaper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

     public function destroy(CyberPaper $cyberPaper)
     {
         try {
             // Delete the associated file from storage
             Storage::disk('public')->delete("uploads/cyber_papers/{$cyberPaper->file}");

             // Delete the cyber paper from the database
             $cyberPaper->delete();

             return redirect()->route('cyberpapers.index')->with('success', 'Cyber Paper deleted successfully');
         } catch (\Exception $e) {
             return redirect()->route('cyberpapers.index')->with('error', 'Failed to delete the cyber paper');
         }
     }


}
