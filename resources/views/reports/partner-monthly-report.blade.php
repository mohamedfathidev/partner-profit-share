@extends('layouts.master')

@section('title', 'تقرير أرباح شريك')

@section('css')
    <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            background-color: #f4f6f9;
            color: #333;
        }

        .pdf-report {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            font-size: 16px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .filter-label {
            color: #007bff;
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
@endsection

@section('page-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0" style="color: #3498db; font-weight: bold;"> تقرير أرباح شريك </h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
                    <li class="breadcrumb-item active" style="color: #2c3e50;">تقرير شريك</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <form action="{{ route('report.partner.month.generate') }}" method="POST" class="row mb-4"x>
        @csrf
        <div class="col-md-4">
            <label class="filter-label">الشريك</label>
            <select class="form-control" id="partner-select" name="partner_id">
                <option value="">-- اختر الشريك --</option>
                @foreach ($partners as $partner)
                    <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                @endforeach
            </select>
            @error('partner_id')
            <p class="alert alert-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-4">
            <label class="filter-label">السنة</label>
            <select class="form-control" name="year">
                @for ($i = 2022; $i <= now()->year; $i++)
                    <option value="{{ $i }}" {{ $i == now()->year ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="col-md-4">
            <label class="filter-label">الشهر</label>
            <select class="form-control" name="month">
                <option value="{{ now()->month }}">-- {{ \Carbon\Carbon::now()->locale('ar')->translatedFormat('F') }}  --</option>
                <option value="1">يناير</option>
                <option value="2">فبراير</option>
                <option value="3">مارس</option>
                <option value="4">أبريل</option>
                <option value="5">مايو</option>
                <option value="6">يونيو</option>
                <option value="7">يوليو</option>
                <option value="8">أغسطس</option>
                <option value="9">سبتمبر</option>
                <option value="10">أكتوبر</option>
                <option value="11">نوفمبر</option>
                <option value="12">ديسمبر</option>
            </select>
        </div>

        <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-primary btn-block">تحميل تقرير الشريك</button>
        </div>
    </form>

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