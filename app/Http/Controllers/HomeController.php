<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','status']);
    }


    public function index()
    {
        $count_all= Invoice::count();
        $count_invoices1 = Invoice::where('value_status', 1)->count();



        $count_all= Invoice::count();
        $count_invoices2 = Invoice::where('value_status', 2)->count();



        $count_all= Invoice::count();
        $count_invoices3 = Invoice::where('value_status', 3)->count();




        return view('dashboard',compact('count_invoices1','count_invoices2','count_invoices3'));
    }
}
