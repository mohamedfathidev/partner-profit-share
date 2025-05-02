@extends('layouts.master')

@section('title', ' التقرير الشهر عن الأرباح')

@section('css')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            /* Right to left */
            background-color: #f4f6f9;
            /* Light background for overall feel */
            color: #333;
        }

        .pdf-report {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            font-size: 16px;
            /* Slightly larger font for better readability */
            background-color: #fff;
            /* White background for the report section */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .pdf-report .header {
            text-align: center;
            margin-bottom: 30px;
            /* More space below the header */
        }

        .pdf-report .logo {
            width: 120px;
            /* Slightly larger logo */
            margin-bottom: 15px;
        }

        .pdf-report .title {
            font-size: 24px;
            /* Larger title */
            font-weight: bold;
            color: #28a745;
            /* Attractive green color for the title */
            margin-bottom: 5px;
        }

        .pdf-report>div:nth-child(2) {
            /* Style the date line */
            color: #6c757d;
            font-size: 14px;
        }

        .pdf-report table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            /* Subtle shadow for the table */
        }

        .pdf-report th,
        .pdf-report td {
            border: 1px solid #ddd;
            /* Lighter border */
            padding: 12px;
            /* More padding */
            text-align: center;
        }

        .pdf-report th {
            background-color: #007bff;
            /* Attractive blue for table headers */
            color: #fff;
            font-weight: bold;
        }

        .pdf-report tbody tr:nth-child(even) {
            background-color: #f9f9f9;
            /* Light gray for even rows */
        }

        .pdf-report .total {
            background-color: #28a745;
            /* Green for the total row */
            color: #fff;
            font-weight: bold;
        }

        .pdf-report .total td {
            font-weight: bold;
        }

        .pdf-report .footer {
            margin-top: 50px;
            font-size: 14px;
            color: #6c757d;
            text-align: center;
        }

        .pdf-report .actions {
            margin-top: 30px;
            text-align: center;
        }

        .filter-label {
            color: #007bff;
            /* Primary blue color */
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            /* More space below the label */
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

        .btn-outline-success,
        .btn-outline-secondary,
        .btn-outline-dark {
            padding: 10px 18px;
            border-radius: 4px;
            font-size: 16px;
            margin-left: 5px;
            margin-right: 5px;
        }
    </style>
@endsection

@section('page-header')
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0" style="color: #3498db; font-weight: bold;"> تقارير الأرباح </h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                    <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
                    <li class="breadcrumb-item active" style="color: #2c3e50;">تقارير الأرباح</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')


    <form action="{{ route('report.general.month.generate') }}" method="Post" class="row mb-4">
        @csrf
        <div class="col-md-4">
            <label class="filter-label">الشهر </label>
            <select class="form-control" name="year">
                @for ($i = 2025; $i <= now()->year ;$i++)
                <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-4">
            <label class="filter-label">الشهر </label>
            <select class="form-control" name="month">
                <option value="{{ now()->month }}">-- الشهر الحالي --</option>                <option value="1">يناير</option>
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
        <div class="col-md-4">
            <label class="filter-label">&nbsp;</label>
            <button type="submit" class="btn btn-primary btn-block">تحميل التقرير</button>
        </div>
    </form>



@endsection

@section('js-code')
@endsection
