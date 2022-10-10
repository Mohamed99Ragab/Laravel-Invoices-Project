<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ArchiveInvoicesController extends Controller
{

    public function index()
    {

        $invoices = Invoice::onlyTrashed()->get();

        return view('invoices.invoices_archive',compact('invoices'));
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
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {
        $id = $request->invoice_id;

        Invoice::withTrashed()->where('id',$id)->restore();
        session()->flash('invoice_restore');
        return redirect('invoices');

    }


    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
       $invoice = Invoice::withTrashed()->where('id',$id)->first();
       $invoice->forceDelete();

        session()->flash('invoice_delete');
        return back();

    }
}
