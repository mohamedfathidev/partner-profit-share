@extends('layouts.master')
@section('css')

@endsection

@section('title')
        تعديل مدير
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0"> تعديل مدير</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="default-color">الرئيسية</a></li>
                    <li class="breadcrumb-item active">تعديل مدير</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-30">
                <div class="card card-statistics h-100">
                    <div class="card-body">
                        <form action="{{ route('managers.update', $details->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="exampleFormControlInput1">الاسم</label>
                                <input type="text" name="name" class="form-control" id="exampleFormControlInput1" value="{{  $details->name }}">
                                @error('name')
                                <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">النسبة</label>
                                <input type="text" name="percentage" class="form-control" id="exampleFormControlInput1" value="{{ $details->percentage }}">
                                @error('percentage')
                                <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">اختار  حالة المدير</label>
                                <select class="form-control" name="active" id="exampleFormControlSelect2"
                                        style="height: 50px; font-size: 14px;">
                                    <option disabled selected>اختار حالة المدير</option>
                                    <option value="1" @selected( $details->active == 1 )>نشط</option>
                                    <option value="0" @selected( $details->active == 0 )>غير نشط</option>
                                </select>
                            </div>
                            <div>
                                <input type="submit" value="تعديل" class="btn btn-warning">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- row closed -->
@endsection

@push('js-code')

@endpush
