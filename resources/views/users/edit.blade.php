@extends('layouts.master')
@section('title')
    تعديل مستخدمين
@endsection
@section('css')

@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/تعديل</span>
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
                    <a class="btn btn-success" href="{{ route('users.index') }}">رجوع</a>
                </div>
                <div class="card-body">
                    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id],'files'=>true]) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>اسم المستخدم:</strong>
                                {!! Form::text('name', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>الايميل الكتروني:</strong>
                                {!! Form::text('email', null, array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>كلمة المرور:</strong>
                                {!! Form::password('password', array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>تاكيد كلمة المرور:</strong>
                                {!! Form::password('confirm-password', array('placeholder' => '','class' => 'form-control')) !!}
                            </div>
                        </div>


                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <label class="form-label"> صورة الملف الشخصي</label>
                                <br>
                                @if(!empty($user->photo))
                                    <img SRC="{{asset('attachments/users/'.$user->photo)}}"style="max-width: 50px;border-radius: 5px;">
                                @else
                                    <img src="{{asset('assets/img/avatar.png')}}"style="max-width: 50px;border-radius: 5px;">
                                @endif
                                <br>
                                <input type="file"name="photo" class="form-control-file" id="exampleFormControlFile1">
                            </div>

                            <div class="col-xs-8 col-sm-8 col-md-8">
                                <label class="form-label">حالة المستخدم</label>
                                <select name="status" id="select-beast" class="form-control  nice-select  custom-select">
                                    <option value="مفعل">مفعل</option>
                                    <option value="غير مفعل">غير مفعل</option>
                                </select>
                            </div>


                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>الصلاحية:</strong>
                                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">حفظ</button>
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

@endsection
