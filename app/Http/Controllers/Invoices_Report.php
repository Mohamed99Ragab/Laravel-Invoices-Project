<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class Invoices_Report extends Controller
{
    public function index(){

        return view('reports.invoices_report');

    }

    public function Search_invoices(Request $request){

        $rdio = $request->rdio;


        // في حالة البحث بنوع الفاتورة

        if ($rdio == 1) {


            // في حالة عدم تحديد تاريخ
            if ($request->type && $request->start_at =='' && $request->end_at =='') {

                $invoices = Invoice::select('*')->where('status','=',$request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report',compact('type'))->withDetails($invoices);
            }

            // في حالة تحديد تاريخ استحقاق
            else {

                $request->validate([
                    'start_at' => 'date_format:Y-m-d|before_or_equal:end_at',
                    'end_at' => 'date_format:Y-m-d|after_or_equal:start_at'
                ]);


                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;

                $invoices = Invoice::whereBetween('invoice_date',[$start_at,$end_at])->where('status','=',$request->type)->get();
                return view('reports.invoices_report',compact('type','start_at','end_at'))->withDetails($invoices);

            }



        }

//====================================================================

        // في البحث برقم الفاتورة
        else {

            $invoices = Invoice::select('*')->where('invoice_num','=',$request->invoice_number)->get();
            return view('reports.invoices_report')->withDetails($invoices);

        }



    }
}
