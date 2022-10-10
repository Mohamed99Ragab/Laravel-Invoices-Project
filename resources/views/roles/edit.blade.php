@extends('layouts.master')
@section('title')
    تعديل صلاحية
@endsection
@section('css')
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل صلاحية</span>
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
                    <a class="btn btn-success" href="{{ route('roles.index') }}">رجوع</a>
                </div>
                <div class="card-body">
                    {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>اسم الصلاحية:</strong>
                                {!! Form::text('name', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <!-- col -->
                                <div class="col-lg-4">
                                    <ul id="treeview1">
                                        <li><a href="#">الصلاحيات</a>
                                            <ul>
                                                <li>
                                                    @foreach($permission as $value)
                                                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                                            {{ $value->name }}</label>
                                                        <br />
                                                    @endforeach
                                                </li>

                                            </ul>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">تحديث</button>
                        </div>
                    </div>
                    {!! Form::close() !!}

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
    <script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection
