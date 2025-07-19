@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
@endsection

@section('title')
    الإعدادات 
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <p class="mb-0" style="font-weight:bold; font-size:26px;"> الإعدادات</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">الإعدادات</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                    <br>
                    <div class="table-responsive">
                        <table id="partners-table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>الاسم</th>
                                    <th> الإعداد</th>
                                    <th> القيمة</th>
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

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
@endpush

@push('js-code')
<script>
    $(document).ready(function() {
        window.partnerTable = $('#partners-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('settings.load') }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'key',
                    name: 'key'
                },
                {
                    data: 'value',
                    name: 'value'
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
        });
    });
</script>
@endpush

@push('js-code')

@endpush
