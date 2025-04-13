@extends('layouts.master')
@section('css')

@endsection

@section('title')
    الملف الشخصي للشريك {{ $manager->name }}
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
                        <h4>{{ $manager->name }}</h4>
                    </div>
                </div>
            </div>
        </div>
            <p style="font-size:35px;color:darkkhaki">الأرباح</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">

                                <br>
                                <div class="table-responsive">
                                    <table id="show-profit-table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>التاريخ</th>
                                            <th>الربح</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($manager->profitShares as $profit)
                                            <tr>
                                                <th>
                                                    {{ $profit->id }}
                                                </th>
                                                <th>
                                                    {{ \Carbon\Carbon::parse($profit->date)->locale('ar')->translatedFormat('F Y') }}
                                                </th>
                                                <th>
                                                    {{ $profit->profit_share }}
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

@endsection

@push('js-code')
    <script>
        $(document).ready( function () {
            $('#show-profit-table').DataTable({
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
