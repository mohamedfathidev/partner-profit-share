@extends('layouts.master')

@section('title')
    ترحيل وبداية سنة جديدة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0">ترحيل وبداية سنة جديدة</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="default-color">الرئيسية</a></li>
                    <li class="breadcrumb-item active">ترحيل وبداية سنة جديدة</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body text-center">
                    <form action="{{ route('migrate') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg mb-4">ترحيل و بداية سنة جديد</button>
                    </form>
                    <div class="alert alert-warning mt-4 text-right" style="font-size: 1.1rem;">
                        <ul class="mb-0 pr-3" style="list-style: disc inside;">
                            <li>لا تقم بالترحيل قبل التأكد من أن أرباح الشهر الحالي قد تم توزيعها بالكامل.</li>
                            <li>لا تقم بإضافة أرباح شهر جديد قبل إتمام عملية الترحيل.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js-code')
@endpush 