@extends('layouts.master')
@section('css')

@endsection

@section('title')
    تعديل الإعداد {{ $details->name }}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0"> {{ $details->name}}تعديل الإعداد</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="default-color">الرئيسية</a></li>
                    <li class="breadcrumb-item active">تعديل الإعداد</li>
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
                        <form action="{{ route('settings.update', $details->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="exampleFormControlInput1">القيمة</label>
                                <input type="text" name="value" class="form-control" id=""
                                    value="{{ $details->value }}">
                                @error('name')
                                    <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
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
