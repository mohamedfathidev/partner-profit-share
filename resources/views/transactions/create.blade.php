@extends('layouts.master')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/redmond/jquery-ui.css">
@endsection

@section('title')
    إضافة معاملة
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> إضافة معاملة</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">إضافة معاملة</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <h2 style="
            color: #ff9800; /* A more modern warning color (orange) */
            font-size: 1.8em; /* Bigger font size */
            font-weight: 600; /* Semi-bold for a modern feel */
            margin-bottom: 15px; /* Add some spacing below */
            padding-left: 25px; /* Indentation for bullet point effect */
            position: relative; /* For pseudo-element positioning */
            list-style-type: none; /* Remove default list styling if any */
        ">
            <span style="
                content: '\2022'; /* Unicode for bullet point */
                color: #ff9800;
                font-size: 1.4em; /* Adjust bullet size */
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
            "></span>
            لا تحاول إدخال معاملات لشهر تم توزيع أرباحه
        </h2>
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <form action="{{ route('transactions.store') }}"  method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleFormControlInput1">المبلغ</label>
                            <input type="text" name="amount" class="form-control" id="exampleFormControlInput1"
                                value="{{ old('amount') }}">
                            @error('amount')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">التاريخ</label>
                            <input type="text" name="date" class="form-control" id="date"
                                value="{{ old('date') }}">
                            @error('date')
                                <p class="alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">اختار الشريك</label>
                                <select class="form-control" id="partner-select" name="partner_id"
                                    id="exampleFormControlSelect2" style="height: 50px; font-size: 14px;">
                                    <option disabled selected>اختار الشريك</option>
                                    @foreach ($partners as $id => $partner)
                                        <option value="{{ $id }}">{{ $partner }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">اختار نوع المعاملة</label>
                                <select class="form-control" name="type" id="exampleFormControlSelect2"
                                    style="height: 50px; font-size: 14px;">
                                    <option disabled selected>اختار نوع المعاملة</option>
                                    <option value="withdrawal">سحب</option>
                                    <option value="deposite">إيداع</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">ملاحظة</label>
                                <textarea class="form-control" name="note" rows="3">{{ old('note') }}</textarea>
                            </div>


                            <div>
                                <input type="submit" value="حفظ" class="btn btn-warning">
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- row closed -->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endpush

@push('js-code')
<script>
    $(document).ready(function() {
        $('#partner-select').select2();
    });
</script>

<script>
    $(document).ready(function() {
        $('#date').datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>
@endpush
