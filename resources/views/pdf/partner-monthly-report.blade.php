<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير شريك مفصل</title>
    <link rel="icon" type="image/png" href="#">
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
            background-color: #fff;
            padding: 30px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h3 {
            font-size: 20px;
            font-weight: bold;
        }

        .info-box {
            border: 2px solid #000;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .info-box p {
            margin: 8px 0;
        }

        .transactions-section {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        .footer-summary {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            padding: 10px;
        }

        .monthly-profit {
            text-align: left;
            font-size: 16px;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="pdf-report">
        <div class="header">
            <h3>تقرير مفصل عن شهر {{ $startOfMonth->locale('ar')->translatedFormat('F') }} شريك ({{ $partner->name }})</h3>
        </div>

        <div class="info-box">
            <p>تاريخ الإصدار: {{ \Carbon\Carbon::now()->locale('ar')->translatedFormat('d F Y') }}</p>
            <p>المبلغ الحالي خلال هذه الفترة: {{ $partner->currentBalanceUntilMonth($endOfMonth) }} جنيه</p>
            <p>المبلغ الإبتدائي: {{ $partner->initial_balance }} جنيه</p>
            <p>المبلغ الحالي بعد حساب الأرباح: {{ $partner->currentBalanceUntilMonth($endOfMonth) + optional($partner->profitShares->first())->profit_share ?? 0 }} جنيه</p>
            <p>المبلغ الحالي المطلق: {{ $partner->balance }} جنيه</p>
        </div>

        <div class="transactions-section">
            <h4>المعاملات</h4>
            <table>
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>نوع العملية</th>
                        <th>القيمة</th>
                        <th>ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($partner->transactions as $transaction)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') }}</td>
                            <td>{{ $transaction->type == 'withdrawal' ? 'سحب' : 'إيداع' }}</td>
                            <td>{{ $transaction->amount }}</td>
                            <td>{{ $transaction->note ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer-summary">
            <div>إجمالي السحوبات: {{ $partner->transactions->where('type', 'withdrawal')->sum('amount') }} جنيه</div>
            <div>إجمالي الإيداعات: {{ $partner->transactions->where('type', 'deposite')->sum('amount') }} جنيه</div>
            <div> عدد العمليات: {{ $partner->transactions->count() }} </div>
            <div>
                الربح الشهري: {{ optional($partner->profitShares->first())->profit_share ?? 0 }} جنيه
            </div>
        </div>

        <div style="margin-top: 20px; padding: 12px; background: #f9f9f9; border-right: 4px solid #1976d2; font-size: 15px; font-weight: bold; color: #333; border-radius: 6px;">
             الربح الشهري يتم حسابه بعد خصم 2.% قيمة الزكاة الشهرية من الربح الشهري الاساسي بإجمالي 2.5 % قيمة الزكاة السنوية
            <span style="display: block">----------------------------------</span>
             المبلغ قبل خصم الزكاة  هو {{ round(optional($partner->profitShares->first())->profit_share/(1-.002), 1) }}
        </div>
        
    </div>

    <div class="footer">
        <p>بيانات التواصل: -+2012456798- | الشرقية / كفر صقر / لكح</p>
        <p>التوقيع: مدير المشروع</p>
        <strong>محمد منصور</strong>

    </div>
</body>

</html>
