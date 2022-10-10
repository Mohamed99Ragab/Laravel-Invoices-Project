<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachementController extends Controller
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
        $request->validate([
            'file_name'=>'mimes:pdf,png,jpg'
        ]);

        try{

          $Invoice_attach = new invoice_attachement();
          $file_name = $request->file('file_name')->getClientOriginalName();

          //insert file in table attachment
          $Invoice_attach->file_name = $file_name;
          $Invoice_attach->invoice_number = $request->invoice_number;
          $Invoice_attach->invoice_id = $request->invoice_id;
          $Invoice_attach->user = Auth::user()->name;
          $Invoice_attach->save();

          //move file

            $request->file('file_name')->storeAs($request->invoice_number.'/',$file_name,'public');



          session()->flash('success','تم اضافة المرفق بنجاح');
          return back();

        }
        catch(\Exception $e){
            return redirect()->back()->withErrors(['error'=>$e->getMessage()]);
        }

    }


    public function show(invoice_attachement $invoice_attachement)
    {
        //
    }


    public function edit(invoice_attachement $invoice_attachement)
    {
        //
    }


    public function update(Request $request, invoice_attachement $invoice_attachement)
    {
        //
    }


    public function destroy(invoice_attachement $invoice_attachement)
    {
        //
    }


// function to open file
//    public function open_file($invoice_number,$file_name){
//
//        $file =  Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
//        return response()->file($file);
//    }


    public function download_file($invoice_number,$file_name){

      return Storage::disk('public')->download($invoice_number.'/'.$file_name);
    }

   public function delete_file($invoice_number,$file_name,$id){

        invoice_attachement::destroy($id);

        Storage::disk('public')->delete($invoice_number.'/'.$file_name);

        session()->flash('success','تم حذف المرفق بنجاح');
        return back();

   }

}
