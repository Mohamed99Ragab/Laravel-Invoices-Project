<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\invoice_attachement;
use App\Models\invoice_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailsController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);

        $invoice_details = invoice_details::where('invoice_id','=',$id)->get();
        $invoice_attachements = invoice_attachement::where('invoice_id','=',$id)->get();
        $invoices = Invoice::where('id','=',$id)->get();

        return view('invoices.invoice_details',compact('invoice_details','invoice_attachements','invoices'));

    }


    public function edit(invoice_details $invoice_details)
    {
        //
    }


    public function update(Request $request, invoice_details $invoice_details)
    {
        //
    }


    public function destroy(invoice_details $invoice_details)
    {
        //
    }










}
