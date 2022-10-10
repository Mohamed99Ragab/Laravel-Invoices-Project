<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Mail\addInvoiceMail;
use App\Models\Invoice;
use App\Models\invoice_attachement;
use App\Models\invoice_details;
use App\Models\Section;
use App\Models\User;
use App\Notifications\Add_Invoice;
use http\Exception\BadConversionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
    }


    public function index()
    {

        $invoices = Invoice::all();

        return view('invoices.index',compact('invoices'));
    }


    public function create()
    {

        $sections = Section::all();

        return view('invoices.create',compact('sections'));
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            //insert in table invoices
            $invoice = Invoice::create([
                'invoice_num'=>$request->invoice_number,
                'invoice_date'=>$request->invoice_Date,
                'due_date'=>$request->Due_date,
                'product'=>$request->product,
                'section_id'=>$request->Section,
                'amount_collection'=>$request->Amount_collection,
                'amount_commission'=>$request->Amount_Commission,
                'discount'=>$request->Discount,
                'rate_vat'=>$request->Rate_VAT,
                'value_vat'=>$request->Value_VAT,
                'total'=>$request->Total,
                'status'=>'غير مدفوعة',
                'value_status'=>2,
                'note'=>$request->note,
                'user'=>Auth::user()->name
            ]);

            //insert in table invoice_details
            $invoice_id = $invoice->id;

            invoice_details::create([
                'invoice_id'=>$invoice_id,
                'invoice_numbeer'=>$request->invoice_number,
                'product'=>$request->product,
                'section'=>$request->Section,
                'status'=>'غير مدفوعة',
                'value_status'=>2,
                'note'=>$request->note,
                'user'=>Auth::user()->name
            ]);

        if($request->hasFile('pic')){
            //insert in table invoice_attachments
            $attechment = new invoice_attachement();
            $attechment->invoice_id = $invoice_id;
            $attechment->invoice_number = $request->invoice_number;
            $attechment->file_name = $request->file('pic')->getClientOriginalName();
            $attechment->user = Auth::user()->name;
            $attechment->save();

            //upload pic on server
            $attach_name = $request->file('pic')->getClientOriginalName();

            // this is way to upload file
            //$request->file('pic')->move(public_path('Invoices_attachments/'.$request->invoice_number),$attach_name);

            // this is other way to upload file
             $request->file('pic')->storeAs($request->invoice_number,$attach_name,'public');


        }
            DB::commit();


//            mail::to(Auth::user())->send(new addInvoiceMail($invoice_id));

            $user = User::get();
            $invoice = Invoice::latest()->first();
            Notification::send($user, new Add_Invoice($invoice));

            session()->flash('success','تم اضافة الفاتورة بنجاح');
            return redirect()->back();

        }
        catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error'=>$e->getMessage()]);
        }
    }


    public function show($id)
    {
        $invoice = Invoice::findorFail($id);
        $sections = Section::all();

        return view('invoices.status_update',compact('invoice','sections'));
    }


    public function edit($id)
    {
        $invoice = Invoice::findorFail($id);
        $sections = Section::all();

        return view('invoices.edit',compact('invoice','sections'));
    }


    public function update(Request $request)
    {
        $invoice = Invoice::findorFail($request->inovice_id);
        $invoice->update([
            'invoice_num'=>$request->invoice_number,
            'invoice_date'=>$request->invoice_Date,
            'due_date'=>$request->Due_date,
            'product'=>$request->product,
            'section_id'=>$request->Section,
            'amount_collection'=>$request->Amount_collection,
            'amount_commission'=>$request->Amount_Commission,
            'discount'=>$request->Discount,
            'rate_vat'=>$request->Rate_VAT,
            'value_vat'=>$request->Value_VAT,
            'total'=>$request->Total,
            'status'=>'غير مدفوعة',
            'value_status'=>2,
            'note'=>$request->note,
            'user'=>Auth::user()->name
        ]);

        session()->flash('success','تم تعديل الفاتورة بنجاح');
        return redirect()->route('invoices.index');


    }


    public function destroy(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $invoice = Invoice::findorFail($invoice_id);
        $attachments = invoice_attachement::where('invoice_id','=',$invoice_id)->first();

        if(!$request->archive_page==2){
            if(!empty($attachments->invoice_number)){
                Storage::disk('public')->deleteDirectory($attachments->invoice_number);
            }
            $invoice->forceDelete();

            session()->flash('delete_invoice');
            return back();

        }
        else{
            $invoice->Delete();

            session()->flash('archive_invoice');
            return redirect('invoicesArchive');



        }


    }



    public function statusUpdate(Request $request){
        $inovice_id = $request->inovice_id;

        $invoices = Invoice::findorFail($inovice_id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'value_status' => 1,
                'status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoice_details::create([
                'invoice_id' => $inovice_id,
                'invoice_numbeer' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => Auth::user()->name,
            ]);
        }

        else {
            $invoices->update([
                'value_status' => 3,
                'status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoice_details::create([
                'invoice_id' => $inovice_id,
                'invoice_numbeer' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => Auth::user()->name,
            ]);
        }
        session()->flash('Status_Update');
        return redirect('invoices/');

    }


    public function invoices_paid(){

            $invoices = Invoice::where('value_status','=',1)->get();

            return view('invoices.invoices_paid',compact('invoices'));
    }

    public function invoices_unpaid(){

        $invoices = Invoice::where('value_status','=',2)->get();

        return view('invoices.invoices_unpaid',compact('invoices'));
    }
    public function invoices_partial(){

        $invoices = Invoice::where('value_status','=',3)->get();

        return view('invoices.invoices_partial',compact('invoices'));
    }


    public function print_invoice($id){
        $invoice = Invoice::findorFail($id);

        return view('invoices.print_invoice',compact('invoice'));
    }



    public function getProduct($id){
      $products =  DB::table('products')->where('section_id','=',$id)->pluck('name','id');
        return $products;
    }


    public function exportInvoices(){
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
    }


    public function Mark_as_read(){
      $notifications_unread = Auth::user()->unreadNotifications();
        if($notifications_unread){
            Auth::user()->unreadNotifications->markAsRead();
            return back();
        }
    }


}
