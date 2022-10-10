@extends('layouts.master')
@section('title')
    الفواتير المرشفة
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
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ارشيف الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @include('messages')


    @if (session()->has('archive_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم نقل الفاتورة الي الارشيف",
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

    @if (session()->has('invoice_delete'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
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
                                            <a class="dropdown-item" name="restore" href="#restore_invoice" data-toggle="modal" data-invoice_id="{{$invoice->id}}"><i class="fa fa-trash-restore text-success ml-1"></i> استعادة الفاتورة</a>
                                            <a class="dropdown-item" data-invoice_id="{{$invoice->id}}" href="#delete_invoice" data-toggle="modal"  name="deleted"><i class="fa fa-trash text-danger ml-1"></i>حذف</a>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- استعادة الفاتورة -->
        <div class="modal fade" id="restore_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">استعادة الفاتورة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <form action="{{ route('invoicesArchive.update', 'test') }}" method="post">
                        @method('PUT')
                        @csrf
                    </div>
                    <div class="modal-body">
                        هل انت متاكد من عملية استعادة الفاتورة ؟
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-success">تاكيد</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- استعادة الفاتورة -->

        <!-- حذف الفاتورة -->
        <div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <form action="{{ route('invoicesArchive.destroy', 'test') }}" method="post">
                        @method('DELETE')
                        @csrf
                    </div>
                    <div class="modal-body">
                        هل انت متاكد من عملية الحذف ؟
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                    </form>
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
            $('a[name="restore"]').click(function(event) {
                var Invoice_Id = $(this).attr('data-invoice_id');
                var Modal = $('#restore_invoice');
                Modal.find('.modal-body #invoice_id').val(Invoice_Id);
                Modal.modal();
            });

        });
    </script>





@endsection
