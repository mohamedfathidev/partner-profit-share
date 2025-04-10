<!DOCTYPE html>

<html lang="ar" dir="rtl">
<head>
    <title>User Report</title>
    <style>
        body {
            font-family: 'dejavusans'; /* Make sure the font supports Arabic */
            direction: rtl; /* Right-to-left text */
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; direction: rtl;">
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="margin: 0;">{{ $title }}</h2>
    <p style="margin: 0;">التاريخ: {{ $date }}</p>
</div>

<div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
    <h4 style="margin: 0;">التقرير الشهري</h4>
    <h4 style="margin: 0;">إجمالي الأرباح: {{ $totalProfit }}</h4>
    <h4 style="margin: 0;">عدد الشركاء النشطين: {{ $activePartners }}</h4>
</div>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
    <tr style="background-color: #f2f2f2;">
        <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">ID</th>
        <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">الاسم</th>
        <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">المبلغ الكلي</th>
        <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">تاريخ</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($partners as $partner)
        <tr>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">{{ $partner->id }}</td>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">{{ $partner->name }}</td>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">{{ $partner->balance }}</td>
            <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">{{ Carbon\Carbon::parse($partner->created_at)->locale('ar')->translatedFormat("j F Y") }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
