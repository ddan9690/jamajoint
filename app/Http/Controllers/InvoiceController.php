<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\School;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $invoices = Invoice::orderBy('invoice_number', 'asc')->get();



        return view('backend.invoices.index', compact('invoices'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::orderBy('name', 'asc')->get(); // Order schools by name in ascending order
        $exams = Exam::orderBy('created_at', 'desc')->get(); // Order exams by date in descending order

        return view('backend.invoices.create', compact('schools', 'exams'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'school_id' => 'required',
            'exam_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        // Get the currently authenticated user's ID
        $user_id = Auth::id();

        // Find the last used invoice number from the database
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();

        if ($lastInvoice) {
            // Extract the numeric part of the invoice number and increment it
            $lastInvoiceNumber = $lastInvoice->invoice_number;
            $numericPart = (int)substr($lastInvoiceNumber, 4); // Assuming "CYB-XXXXX" pattern
            $nextNumericPart = $numericPart + 1;
            $invoiceNumber = "CYB-" . str_pad($nextNumericPart, 5, '0', STR_PAD_LEFT);
        } else {
            // If no previous invoices exist, start with "CYB-00001"
            $invoiceNumber = "CYB-00001";
        }

        // Create the new invoice
        $invoice = new Invoice();
        $invoice->invoice_number = $invoiceNumber;
        $invoice->school_id = $validatedData['school_id'];
        $invoice->exam_id = $validatedData['exam_id'];
        $invoice->user_id = $user_id;
        $invoice->amount = $validatedData['amount'];
        $invoice->save();

        // Redirect to the invoice index page with a success message
        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully');
    }



    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }


    public function destroy(Invoice $invoice)
    {

        $invoice->delete();


        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully');
    }
}
