@extends('layouts.master')
@section('css')
    @section('title')
        التقرير السنوي للأرباح
    @stop
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0"> التقرير السنوي للأرباح </h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="#" class="default-color">الرئيسية</a></li>
                    <li class="breadcrumb-item active">التقرير السنوي</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-md-3">
            <label>السنة</label>
            <select class="form-control">
                <option value="2024">2024</option>
                <option value="2025">2025</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>الشريك (اختياري)</label>
            <select class="form-control">
                <option value="">-- الكل --</option>
                <option value="1">نور أحمد</option>
                <option value="2">محمد سامي</option>
                <!-- باقي الشركاء -->
            </select>
        </div>
        <div class="col-md-3">
            <label>&nbsp;</label>
            <button class="btn btn-primary btn-block">عرض التقرير</button>
        </div>
    </div>

    <!-- Report Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <h5 class="mb-3">تقرير الأرباح السنوي - 2024</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>اسم الشريك</th>
                                <th>إجمالي الرصيد القابل للربح</th>
                                <th>متوسط نسبة المشاركة</th>
                                <th>إجمالي الأرباح</th>
                                <th>الرصيد النهائي</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>نور أحمد</td>
                                <td>23000 جنيه</td>
                                <td>18%</td>
                                <td>8700 جنيه</td>
                                <td>25000 جنيه</td>
                            </tr>
                            <tr>
                                <td>محمد سامي</td>
                                <td>102000 جنيه</td>
                                <td>82%</td>
                                <td>39600 جنيه</td>
                                <td>110000 جنيه</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-outline-success mt-3">🔄 إعادة احتساب الأرباح السنوية</button>
                    <button class="btn btn-outline-secondary mt-3">🖨️ طباعة</button>
                    <button class="btn btn-outline-dark mt-3">📁 تصدير CSV</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- JS scripts for future enhancements -->
@endsection
