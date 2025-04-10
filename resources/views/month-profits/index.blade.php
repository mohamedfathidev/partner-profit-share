@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/redmond/jquery-ui.css">
@endsection

@section('title')
        قائمة الأرباح الشهرية
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <p class="mb-0" style="font-weight:bold; font-size:26px;">قائمة الأرباح الشهرية</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="default-color">الرئيسية</a></li>
                    <li class="breadcrumb-item active">الأرباح الشهرية</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="container-fluid">
        <a href="{{ route('month-profits.create') }}" class="btn btn-warning">إضافة ربح شهري+ </a>

        <!-- بطاقة البحث -->
        <div class="card card-statistics">
            <div class="card-body">

                <div class="row justify-content-center">
                    <!-- نطاق التاريخ -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">نطاق التاريخ</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" id="fromDate"  name="from_date" placeholder="من" autocomplete="off">
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" id="toDate"  name="to_date" placeholder="إلى" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- زر البحث وإعادة التعيين -->
                <div class="text-center mt-3">
                    <button type="submit" id="filter" class="btn btn-primary btn-lg">بحث</button>
                    <a href="{{ route('month-profits.index') }}" class="btn btn-secondary btn-lg">إعادة تعيين</a>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-30">
                <div class="card card-statistics h-100">
                    <div class="card-body">
                        <br>
                        <div class="table-responsive">
                            <table id="month-profits-table" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>التاريخ</th>
                                    <th>إجمالي الربح الشهري</th>
                                    <th>البضاعة الهالكة</th>
                                    <th>الاجراءات</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- row closed -->
@endsection
@push('js-code')
    <script>
        $(document).ready(function() {
            window.monthProfitTable = $('#month-profits-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:'{{ route('month-profits.load') }}',
                    data: function(data) {
                        data.from_date = $('#fromDate').val() ? moment($('#fromDate').val()).format('YYYY-MM-DD') : null;
                        console.log(data.from_date);
                        console.log("Testing......");
                        data.to_date = $('#toDate').val() ? moment($('#toDate').val()).format('YYYY-MM-DD') : null;
                        console.log(data.to_date);
                    }
                },
                columns: [{
                    data: 'id',
                    name: 'id'
                },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'total_profit',
                        name: 'total_profit'
                    },
                    {
                        data: 'unused_goods',
                        name: 'unused_goods'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ],
                lengthMenu: [
                    [5, 10, 15, 50, "All"]
                ], // Dropdown options
                pageLength: 15, // Default rows per page
                order: [
                    [0, 'desc']
                ],
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(:first-child):not(:last-child)'
                    }
                },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });

            $('#filter').click(function (){
                monthProfitTable.ajax.reload();
            });
        });
    </script>

    <script>
        $(document).ready( function () {
            $('#fromDate').datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0,
                onSelect: function (selectedDate) {
                    $('#toDate').datepicker("option", "minDate", selectedDate);
                }
            })
            $('#toDate').datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0,
                onSelect: function (selectedDate) {
                    $("#fromDate").datepicker("option", "maxDate", selectedDate);
                }
            })

        });
    </script>
@endpush


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

@endpush

@push('js-code')
    @vite('resources/js/delete-button.js')
@endpush

