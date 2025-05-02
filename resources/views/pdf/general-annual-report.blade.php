<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقارير الأرباح</title>
    <!-- إضافة أيقونة لتبويب الصفحة -->
    <link rel="icon" type="image/png" href="#">
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            background-color: #fff;
            color: #333;
            margin: 0;
            padding: 30px;
        }

        .pdf-report {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
            font-size: 14px;
            background-color: #fff;
            padding: 30px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .pdf-report .header {
            text-align: center;
            margin-bottom: 25px;
            position: relative;
        }

        .pdf-report .header::after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background-color: #333;
            margin: 10px auto;
        }

        .pdf-report .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .pdf-report .subtitle {
            font-size: 14px;
            color: #666;
        }

        .pdf-report .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            font-size: 12px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }

        .pdf-report .info p {
            margin: 0;
            color: #555;
        }

        .pdf-report table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        .pdf-report th,
        .pdf-report td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .pdf-report th {
            background-color: #333;
            color: #fff;
            font-weight: bold;
        }

        .pdf-report tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .pdf-report .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #666;
            border-top: 1px dashed #e0e0e0;
            padding-top: 15px;
        }

        .pdf-report .footer .totals {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .pdf-report .footer .developer {
            margin-top: 10px;
            font-size: 11px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="pdf-report">
        <div class="col-md-12">
            <div class="header">
                <h3 style="font-weight: bold; font-size: 28px; color: #333;">AL-MANSOUR</h3>
                <div class="title">تقرير توزيع الأرباح السنوي من الفترة {{ $fromDate->locale('ar')->translatedFormat('d F Y') }} إلي {{ $toDate->locale('ar')->translatedFormat('d F Y') }}

                </div>
            </div>

            <div class="info">
                <p>تاريخ الإصدار: {{ \Carbon\Carbon::parse(now())->locale('ar')->translatedFormat('d F Y') }}</p>
                <p>الفترة: {{ \Carbon\Carbon::parse(now())->locale('ar')->translatedFormat('F Y') }}</p>
                <p>عدد الشركاء: {{ $partners->count() }}</p>
                <p>إجمالي الأرباح: {{ $totalProfitShares }} جنيه</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>اسم الشريك</th>
                        <th> المبلغ الحالي (بعد السحوبات + الإيداعات) </th>
                        <th> إجمالي السحوبات</th>
                        <th> إجمالي الإيداعات</th>
                        <th>عدد المعاملات</th>
                        <th> الربح الشهري</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($partners as $partner)
                        <tr>
                            <td>
                                {{ $partner->name }}
                            </td>
                            <td>
                                {{ $partner->balance }}
                            </td>
                            <td>
                                {{ $partner->transactions->where('type', 'withdrawal')->sum('amount') }}
                            </td>
                            <td>
                                {{ $partner->transactions->where('type', 'deposite')->sum('amount') }}
                            </td>
                            <td>
                                {{ $partner->transactions->count() }}
                            </td>
                            <td>
                                {{ optional($partner->profitShares->first())->profit_share ?? 0 }}
                            </td>
                        </tr>
                    @endforeach


                </tbody>
                <tfoot>
                    <tr class="total">
                        <td>الإجمالي</td>
                        <td>{{ $totalBalance }}</td>
                        <td>{{ $totalWithdrawals }}</td>
                        <td>{{ $totalDeposits }}</td>
                        <td>{{ $totalTransactions }}</td>
                        <td>{{ $totalProfitShares }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="footer">
                <div class="totals">
                    <p>إجمالي الأرباح: {{ $totalProfitShares }} جنيه | إجمالي المصروفات: {{ $totalWithdrawals }} جنيه
                        | إجمالي الإيرادات: {{ $totalDeposits }} جنيه | عدد العمليات: {{ $totalTransactions }}</p>
                </div>
                <p>بيانات التواصل: -+2012456798- | الشرقية / كفر صقر / لكح</p>
                <p>التوقيع: مدير المشروع</p>
                <strong>محمد منصور</strong>

            </div>
        </div>
    </div>

</body>


</html>
