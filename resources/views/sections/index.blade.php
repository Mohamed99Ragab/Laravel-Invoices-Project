@extends('layouts.master')
@section('title')
    الاقسام
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
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/الاقسام</span>
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
            <div class="card">
                <div class="card-header pb-0">
                    @can('اضافة قسم')
                    <a class="modal-effect btn btn-outline-primary" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة قسم</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">اسم القسم</th>
                                <th class="wd-20p border-bottom-0">الوصف</th>
                                <th class="wd-15p border-bottom-0">العمليات</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sections as $section)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$section->name}}</td>
                                <td>{{$section->description==true ? $section->description : 'لا يوجد وصف للقسم'}}</td>
                                <td>
                                    @can('تعديل قسم')
                                    <a href="#modalEdit" name="updated" data-toggle="modal" data_id = "{{$section->id}}" data_name="{{$section->name}}" data_description="{{$section->description}}"  class="btn btn-info btn-sm" title="edit"><i class="fa fa-edit"></i></a>
                                    @endcan

                                    @can('حذف قسم')
                                    <a href="#modalDelete"name="deleted" data-toggle="modal" data_se_id="{{$section->id}}" data_se_name="{{$section->name}}"  class="btn btn-danger btn-sm" title="delete"><i class="fa fa-trash"></i></a>
                                    @endcan
                                </td>

                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

            @include('sections.create')
            @include('sections.edit')
        @include('sections.delete')
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
    <!-- Internal Modal js-->
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

{{--    edit --}}
    <script>
        $(document).ready(function() {
            $('a[name="updated"]').click(function(event) {
                var sectionId = $(this).attr('data_id');
                var sectionName = $(this).attr('data_name');
                var sectionDescription = $(this).attr('data_description');
                var ModalEdit = $('#modalEdit');
                ModalEdit.find('.modal-body #id').val(sectionId);
                ModalEdit.find('.modal-body #name').val(sectionName);
                ModalEdit.find('.modal-body #description').val(sectionDescription);
                ModalEdit.modal();
            });

        });
    </script>


    {{--    delete --}}
    <script>
        $(document).ready(function() {
            $('a[name="deleted"]').click(function(event) {
                var sectionId = $(this).attr('data_se_id');
                var sectionName = $(this).attr('data_se_name');
                var ModalDelete = $('#modalDelete');
                ModalDelete.find('.modal-body #id').val(sectionId);
                ModalDelete.find('.modal-body #name').val(sectionName);
                ModalDelete.find('.modal-body #description').val(sectionDescription);
                ModalDelete.modal();
            });

        });
    </script>



@endsection
