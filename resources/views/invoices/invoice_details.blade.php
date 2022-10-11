@extends('layouts.master')
@section('title')
    {{$invoices[0]->invoice_num}} تفاصيل الفاتورة
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/تفاصيل الفاتورة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @include('messages')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style3">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        معلومات الفاتورة

                    </div>
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-3">
                                <div class="tab-menu-heading">
                                    <div class="tabs-menu ">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs">
                                            <li class=""><a href="#tab11" class="active" data-toggle="tab"> معلومات الفاتورة</a></li>
                                            <li><a href="#tab12" data-toggle="tab">حالات الدفع</a></li>
                                            <li><a href="#tab13" data-toggle="tab"> المرفقات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab11">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th class="wd-5p border-bottom-0">#</th>
                                                        <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                                        <th class="wd-15p border-bottom-0">المنتج</th>
                                                        <th class="wd-15p border-bottom-0"> القسم</th>
                                                        <th class="wd-15p border-bottom-0">الحالة الحالية</th>
                                                        <th class="wd-15p border-bottom-0">مبلغ التحصيل</th>
                                                        <th class="wd-15p border-bottom-0">مبلغ العمولة</th>
                                                        <th class="wd-15p border-bottom-0">الاجمالي</th>
                                                        <th class="wd-20p border-bottom-0">تاريخ الفاتورة</th>


                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($invoices as $invoice)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$invoice->invoice_num}}</td>
                                                            <td>{{$invoice->product}}</td>
                                                            <td>{{$invoice->section->name}}</td>

                                                            @if($invoice->value_status ==1)
                                                                <td><span class="badge badge-success">{{$invoice->status}}</span></td>
                                                            @elseif($invoice->value_status ==2)
                                                                <td><span class="badge badge-danger">{{$invoice->status}}</span></td>
                                                            @else
                                                                <td><span class="badge badge-warning">{{$invoice->status}}</span></td>
                                                            @endif

                                                            <td>{{$invoice->amount_collection}}</td>
                                                            <td>{{$invoice->amount_commission}}</td>
                                                            <td>{{$invoice->total}}</td>
                                                            <td>{{$invoice->invoice_date}}</td>


                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab12">
                                            <div class="table-responsive">
                                                <table class="table text-md-nowrap" id="example1">
                                                    <thead>
                                                    <tr>
                                                        <th class="wd-15p border-bottom-0">#</th>
                                                        <th class="wd-15p border-bottom-0">حالة الفاتورة</th>
                                                        <th class="wd-15p border-bottom-0">تاريخ الدفع</th>
                                                        <th class="wd-20p border-bottom-0">قام بالاضافة</th>
                                                        <th class="wd-15p border-bottom-0">الملاحظات</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($invoice_details as $details)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            @if($details->value_status ==1)
                                                                <td><span class="badge badge-success">{{$details->status}}</span></td>
                                                            @elseif($details->value_status ==2)
                                                                <td><span class="badge badge-danger">{{$details->status}}</span></td>
                                                            @else
                                                                <td><span class="badge badge-warning">{{$details->status}}</span></td>
                                                            @endif
                                                            <td>{{$details->Payment_Date}}</td>
                                                            <td>{{$details->user}}</td>
                                                            <td>{{$details->note==true ? $invoice->note : 'لا يوجد وصف للفاتورة'}}</td>


                                                        </tr>
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab13">

                                            @can('اضافة مرفق')
                                            <div class="card-body">
                                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                <h5 class="card-title">اضافة مرفقات</h5>
                                                <form method="post" action="{{route('InvoiceAttachment.store')}}"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile"
                                                               name="file_name" required>
                                                        <input type="hidden" id="customFile" name="invoice_number"
                                                               value="{{ $invoices[0]->invoice_num }}">
                                                        <input type="hidden" id="invoice_id" name="invoice_id"
                                                               value="{{ $invoices[0]->id }}">
                                                        <label class="custom-file-label" for="customFile">حدد
                                                            المرفق</label>
                                                    </div><br><br>
                                                    <button type="submit" class="btn btn-primary"
                                                            name="uploadedFile">تاكيد</button>
                                                </form>
                                            </div>
                                            @endcan


                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th class="wd-5p border-bottom-0">#</th>
                                                        <th class="wd-15p border-bottom-0">اسم المرفق</th>
                                                        <th class="wd-15p border-bottom-0">قام بالاضافة</th>
                                                        <th class="wd-15p border-bottom-0">تاريخ الاضافة</th>
                                                        <th class="wd-25p border-bottom-0"> تنزيل</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($invoice_attachements as $attach)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$attach->file_name}}</td>
                                                            <td>{{$attach->user}}</td>
                                                            <td>{{$attach->created_at}}</td>
                                                            <td>
                                                                <a href="{{asset('attachments/'.$attach->invoice_number.'/'.$attach->file_name)}}" class="btn btn-outline-success btn-sm">عرض<i class="fa fa-eye mr-1"></i></a>
                                                                <a href="{{route('download_file',[$attach->invoice_number,$attach->file_name])}}" class="btn btn-outline-primary btn-sm">تنزيل<i class="fa fa-download mr-1"></i></a>

                                                                @can('حذف المرفق')
                                                                <a href="#exampleModal" data-toggle="modal" class="btn btn-outline-danger btn-sm">حذف<i class="fa fa-trash mr-1"></i></a>
                                                                @endcan
                                                            </td>

                                                        </tr>


                                                        <!--modal delete -->
                                                        <div class="modal" id="modaldemo1">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content modal-content-demo">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title">حذف المرفق</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                                                                                      type="button"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <form action="{{route('delete_file',[$attach->invoice_number,$attach->file_name,$attach->id])}}" method="post">

                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                                                            <input type="text"class="form-control" name="file_name"value="{{$attach->file_name}}" readonly>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                                                            <button type="submit" class="btn btn-danger">تاكيد</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>


                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title">حذف المرفق</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                                                                                       type="button"><span aria-hidden="true">&times;</span></button>
                                                                    </div>
                                                                    <form action="{{route('delete_file',[$attach->invoice_number,$attach->file_name,$attach->id])}}" method="post">

                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                                                            <input type="text"class="form-control" name="file_name"value="{{$attach->file_name}}" readonly>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                                                            <button type="submit" class="btn btn-danger">تاكيد</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

@endsection
