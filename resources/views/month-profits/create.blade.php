@extends('layouts.master')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    /*<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/redmond/jquery-ui.css">*/

@endsection

@section('title')
        إضافة ربح شهري
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0"> إضافة ربح شهري</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="default-color">الرئيسية</a></li>
                    <li class="breadcrumb-item active">إضافة ربح شهري</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-30">
                <div class="card card-statistics h-100">
                    <div class="card-body">
                        <form action="{{ route('month-profits.store') }}" method="POST">
                            @csrf
                            <div class="form-group col-6">
                                <label for="exampleFormControlInput1">إجمالي الأرباح الشهرية</label>
                                <input type="text" name="total_profit" class="form-control" id="exampleFormControlInput1"
                                       value="{{ old('total_profit') }}" autocomplete="off">
                                @error('total_profit')
                                <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="exampleFormControlInput1">البضاعة المهدرة</label>
                                <input type="text" name="unused_goods" class="form-control" id="exampleFormControlInput1"
                                       value="{{ old('unused_goods') }}" autocomplete="off">
                                @error('unused_goods')
                                <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="exampleFormControlInput1">التاريخ</label>
                                <input type="text" name="date" class="form-control" id="date"
                                       value="{{ old('date') }}" autocomplete="off">
                                @error('date')
                                <p class="alert alert-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <input type="submit" value="إدخال" class="btn btn-warning">
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
        $('#date').datepicker({

        });
    });
</script>
@endpush
