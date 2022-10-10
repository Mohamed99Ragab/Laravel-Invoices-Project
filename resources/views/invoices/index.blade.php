@extends('layouts.master')
@section('title')
    الفواتير
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @include('messages')


    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    @if (session()->has('Status_Update'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم تحديث حالة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif

    @if (session()->has('invoice_restore'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم استعادة الفاتورة بنجاح",
                    type: "success"
                })
            }
        </script>
    @endif



    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">

                        <div class="row">

                            @can('اضافة فاتورة')
                            <a href="{{route('invoices.create')}}" class="btn btn-outline-primary ml-1"><i class="fa fa-plus"></i> اضافة فاتورة</a>
                            @endcan

                            @can('تصدير EXCEL')
                            <a href="{{route('exportInvoices')}}" class="btn btn-success"><i class="fa fa-file-export"></i>  تصدير اكسيل</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                <th class="wd-20p border-bottom-0">تاريخ الفاتورة</th>
                                <th class="wd-15p border-bottom-0">تاريخ الاستحقاق</th>
                                <th class="wd-10p border-bottom-0">القسم</th>
                                <th class="wd-25p border-bottom-0">المنتج</th>
                                <th class="wd-15p border-bottom-0">الخصم</th>
                                <th class="wd-10p border-bottom-0">نسبة الضريبة</th>
                                <th class="wd-25p border-bottom-0">قيمة الضريبة</th>
                                <th class="wd-15p border-bottom-0">الاجمالي</th>
                                <th class="wd-10p border-bottom-0">الحالة</th>
                                <th class="wd-25p border-bottom-0">ملاحظات</th>
                                <th class="wd-25p border-bottom-0">العمليات</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><a href="{{route('InvoiceDetails.show',$invoice->id )}}">{{$invoice->invoice_num}}</a></td>
                                <td>{{$invoice->invoice_date}}</td>
                                <td>{{$invoice->due_date}}</td>
                                <td>{{$invoice->section->name}}</td>
                                <td>{{$invoice->product}}</td>
                                <td>{{$invoice->discount}}</td>
                                <td>{{$invoice->rate_vat}}</td>
                                <td>{{$invoice->value_vat}}</td>
                                <td>{{$invoice->total}}</td>
                                @if($invoice->value_status ==1)
                                <td><span class="badge badge-success">{{$invoice->status}}</span></td>
                                @elseif($invoice->value_status ==2)
                                    <td><span class="badge badge-danger">{{$invoice->status}}</span></td>
                                @else
                                    <td><span class="badge badge-warning">{{$invoice->status}}</span></td>
                                @endif
                                <td>{{$invoice->note==true? $invoice->note : 'لا توجد ملاحظات'}}</td>
                                <td>
                                    <!-- Example single danger button -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            العمليات   <i class="fa fa-angle-down mr-1"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @can('تعديل الفاتورة')
                                            <a class="dropdown-item" href="{{route('invoices.edit',$invoice->id)}}"><i class="fa fa-edit text-primary ml-1"></i>تعديل</a>
                                            @endcan

                                            @can('حذف الفاتورة')
                                            <a class="dropdown-item" data-invoice_id="{{$invoice->id}}" href="#delete_invoice" data-toggle="modal"  name="deleted"><i class="fa fa-trash text-danger ml-1"></i>حذف</a>
                                            @endcan

                                             @can('تغير حالة الدفع')
                                            <a class="dropdown-item" href="{{route('invoices.show',$invoice->id)}}"><i class="fa fa-wallet text-success ml-1"></i>تحديث حالة الدفع</a>
                                            @endcan

                                            @can('ارشفة الفاتورة')
                                            <a class="dropdown-item"name="archive" href="#archive_invoice" data-toggle="modal" data-invoice_id="{{$invoice->id}}"><i class="fa fa-archive text-warning ml-1"></i>نقل الي الارشيف</a>
                                            @endcan

                                             @can('طباعةالفاتورة')
                                            <a class="dropdown-item" href="printInvoice/{{$invoice->id}}"><i class="fa fa-print text-secondary ml-1"></i>طباعة فاتورة</a>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                        @include('invoices.delete')
                    </div>
                </div>
            </div>
        </div>

        <!-- ارشيف الفاتورة -->
        <div class="modal fade" id="archive_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ارشيف الفاتورة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                        @method('DELETE')
                        @csrf
                    </div>
                    <div class="modal-body">
                        هل انت متاكد من عملية الارشفة ؟
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                        <input type="hidden" name="archive_page" value="2">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-success">تاكيد</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ارشيف الفاتورة -->


    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <!-- Internal Data tables -->
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
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>


    <script>
        $(document).ready(function() {
            $('a[name="deleted"]').click(function(event) {
                var Invoice_Id = $(this).attr('data-invoice_id');
                var Modal = $('#delete_invoice');
                Modal.find('.modal-body #invoice_id').val(Invoice_Id);
                Modal.modal();
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('a[name="archive"]').click(function(event) {
                var Invoice_Id = $(this).attr('data-invoice_id');
                var Modal = $('#archive_invoice');
                Modal.find('.modal-body #invoice_id').val(Invoice_Id);
                Modal.modal();
            });

        });
    </script>

@endsection
