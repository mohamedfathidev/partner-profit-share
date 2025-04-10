@extends('layouts.master')
@section('css')

@endsection

@section('title')
        الملف الشخصي للمدير {{ $partner->name }}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <p class="mb-0" style="font-weight:bold; font-size:26px;">الملف الشخصي للمدير</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="default-color">الرئيسية</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('managers.index') }}">المديرين</a></li>
                    <li class="breadcrumb-item ">الملف الشخصي للمدير</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row gutters-sm">
        <div class="col-12">
            <div class="col-12">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{ asset('assets/images/person.png') }}" alt="الشريك" class="rounded-circle"
                         width="150">
                    <div class="mt-3">
                        <h4>{{ $partner->name }}</h4>
                        <p class="text-secondary mb-1">{{$partner->phone}}</p>
                        <p class="text-muted font-size-sm">{{$partner->address}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12" style="margin-top:10px;">
            <p style="font-size:35px;color:darkkhaki">المعاملات</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">

                                <br>
                                <div class="table-responsive">
                                    <table id="show-partner-trans-table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>الشهر</th>
                                            <th>مبلغ المعاملة</th>
                                            <th>نوع المعاملة</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($partnerTransactions->transactions as $partnerTransaction)
                                            <tr>
                                                <th>{{ $partnerTransaction->id }}</th>
                                                <th>{{ \Carbon\Carbon::parse($partnerTransaction->date)->locale('ar')->translatedFormat('F Y') }}</th>
                                                <th>{{ $partnerTransaction->amount }}</th>
                                                <th>
                                                    <div style="text-align: center;">
                                                        @if ($partnerTransaction->type == 'withdrawal')
                                                            <p class="text-bold text-danger" style="font-size:18px">سحب</p>
                                                        @else
                                                            <p class="text-bold text-success" style="font-size:18px">إيداع</p>
                                                        @endif
                                                    </div>
                                                </th>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12" style="margin-top:10px;">
            <p style="font-size:35px;color:darkkhaki">الأرباح</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">

                                <br>
                                <div class="table-responsive">
                                    <table id="show-partner-table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>الشهر</th>
                                            <th>الربح</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@push('js-code')
    <script>
        $(document).ready( function () {
            window.showPartner = $('#show-partner-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('partners.load') }}',
                columns:[{
                    data: 'id',
                    name: 'id'
                },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'balance',
                        name: 'balance'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ],
                lengthMenu: [
                    [5, 10, 15, 50, -1],
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
                        columns: ':not(:last-child)'
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
        });

    </script>


    <script>
        $(document).ready( function () {
            $('#show-partner-trans-table').DataTable({
                processing: true,
                dom:'Bfrtip',
                buttons:[{
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(:first-child)'
                    }
                }]
            });
        });

    </script>
@endpush
