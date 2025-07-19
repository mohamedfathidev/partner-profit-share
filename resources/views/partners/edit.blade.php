@extends('layouts.master')
@section('css')

@endsection

@section('title')
    تعديل شريك
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> تعديل شريك</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">تعديل شريك</li>
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
                    <form action="{{ route('partners.update', $details->id) }}" method="post">
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
                          <label for="exampleFormControlInput1">المبلغ</label>
                          <input type="number" name="initial_balance" class="form-control" id="exampleFormControlInput1" value="{{ $details->initial_balance }}">
                          @error('init_balance')
                            <p class="alert alert-danger">{{ $message }}</p>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="exampleFormControlInput1">العنوان</label>
                          <input type="text" name="address" class="form-control" id="exampleFormControlInput1" value="{{ $details->address }}">
                          @error('address')
                            <p class="alert alert-danger">{{ $message }}</p>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="exampleFormControlInput1">الهاتف</label>
                          <input type="text" name="phone" class="form-control" id="exampleFormControlInput1" value="{{ $details->phone }}">
                          @error('phone')
                            <p class="alert alert-danger">{{ $message }}</p>
                          @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect2">اختار  حالة الشريك</label>
                            <select class="form-control" name="active" id="exampleFormControlSelect2"
                                    style="height: 50px; font-size: 14px;">
                                <option disabled selected>اختار حالة الشريك</option>
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
