@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
@endsection

@section('title')
    سجل الشركاء
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <p class="mb-0" style="font-weight:bold; font-size:26px;">سجل الشركاء</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="default-color">الرئيسية</a></li>
                <li class="breadcrumb-item active">سجل الشركاء</li>
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
                        <table class="table table-striped table-bordered" style="width:100%" id="partners-history-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>اسم الشريك</th>
                                    <th>السنة المالية</th>
                                    <th>المبلغ الإبتدائي للسنة</th>
                                    <th>مجموع الإيداعات</th>
                                    <th>مجموع السحوبات</th>
                                    <th> مبلغ السنة المالية الجديدة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($partnersHistory as $history)
                                    <tr>
                                        <td>{{ $history->id }}</td>
                                        <td>{{ $history->partner->name ?? '-' }}</td>
                                        <td>{{ $history->year ?? '-' }}</td>
                                        <td>{{ $history->initial_yearly_balance ?? '-' }}</td>
                                        <td>{{ $history->total_deposits ?? '-' }}</td>
                                        <td>{{ $history->total_withdrawals ?? '-' }}</td>
                                        <td>{{ $history->balance_after ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">لا يوجد بيانات</td>
                                    </tr>
                                @endforelse
                            </tbody>
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
        window.partnerTable = $('#partners-history-table').DataTable({
            pageLength: 15, // Default rows per page
            order: [
                [0, 'desc']
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        columns: [1, 2, 4]
                    }
                },
            ]
        });
    });
</script>
@endpush

