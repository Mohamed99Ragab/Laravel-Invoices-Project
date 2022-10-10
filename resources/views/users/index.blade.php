@extends('layouts.master')
@section('title')
    ادارة المستخدمين
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
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session()->has('success_update'))
        <script>
            window.onload = function() {
                notif({
                    msg: 'تم تحديث بيانات المستخدم بنجاح',
                    type: "primary"
                })
            }
        </script>
    @endif

    @if (session()->has('success_delete'))
        <script>
            window.onload = function() {
                notif({
                    msg: 'تم  حذف المستخدم بنجاح',
                    type: "error"
                })
            }
        </script>
    @endif

    @if (session()->has('success_create'))
        <script>
            window.onload = function() {
                notif({
                    msg: 'تم  اضافة المستخدم بنجاح',
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

                    @can('اضافة مستخدم')
                    <a class="btn btn-outline-primary" href="{{ route('users.create') }}"> اضافة مستخدم جديد</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-5p border-bottom-0">صورة المستخدم</th>
                                <th class="wd-15p border-bottom-0">اسم المستخدم</th>
                                <th class="wd-20p border-bottom-0">الايميل</th>
                                <th class="wd-20p border-bottom-0">الحالة</th>
                                <th class="wd-15p border-bottom-0">الصلاحية</th>
                                <th class="wd-25p border-bottom-0">العمليات</th>

                            </tr>
                            </thead>
                            <tbody>
                            @can('صلاحية العرض للمسؤل')
                            @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if(!empty($user->photo))
                                            <img SRC="{{asset('attachments/users/'.$user->photo)}}"style="max-width: 50px;border-radius: 5px;">
                                        @else
                                            <img src="{{asset('assets/img/avatar.png')}}"style="max-width: 50px;border-radius: 5px;">
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->status == 'مفعل')
                                            <span class="label text-success d-flex">
                                                <div class="dot-label bg-success ml-1"></div>{{ $user->status }}
                                            </span>
                                        @else
                                            <span class="label text-danger d-flex">
                                                <div class="dot-label bg-danger ml-1"></div>{{ $user->status }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>


                                    <td>
                                       @can('تعديل مستخدم')
                                          <form action="{{route('EditUser')}}"method="post"style="display: inline">
                                              @csrf
                                              <input type="hidden"value="{{$user->id}}"name="id">
                                              <button type="submit" class="btn btn-primary btn-sm">تعديل</button>

                                          </form>
                                        @endcan

                                        @can('حذف مستخدم')
                                        <form action="{{route('users.destroy',$user->id)}}" method="post" style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>

                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            @endcan


                            @can('صلاحية العرض للمستخدم العادي')
                                <tr>
                                    <td>1</td>
                                    <td>
                                        @if(!empty($user_open->photo))
                                            <img SRC="{{asset('attachments/users/'.$user_open->photo)}}"style="max-width: 50px;border-radius: 5px;">
                                        @else
                                            <img src="{{asset('assets/img/avatar.png')}}"style="max-width: 50px;border-radius: 5px;">
                                        @endif
                                    </td>
                                    <td>{{ $user_open->name }}</td>
                                    <td>{{ $user_open->email }}</td>
                                    <td>
                                        @if ($user_open->status == 'مفعل')
                                            <span class="label text-success d-flex">
                                            <div class="dot-label bg-success ml-1"></div>{{ $user_open->status }}
                                        </span>
                                        @else
                                            <span class="label text-danger d-flex">
                                            <div class="dot-label bg-danger ml-1"></div>{{ $user_open->status }}
                                        </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if(!empty($user_open->getRoleNames()))
                                            @foreach($user_open->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>


                                    <td>
                                        @can('تعديل مستخدم')
                                            <form action="{{route('EditUser')}}"method="post">
                                                @csrf
                                                <input type="hidden"value="{{$user_open->id}}"name="id">
                                                <button type="submit" class="btn btn-primary btn-sm">تعديل</button>

                                            </form>
                                        @endcan

                                        @can('حذف مستخدم')
                                            <form action="{{route('users.destroy',$user_open->id)}}" method="post" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>

                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endcan

                            </tbody>
                        </table>
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

    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>


@endsection
