<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>فاتورة مبيعات</title>
    <style>
        @font-face {
            font-style: normal;
            font-weight: 400;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 100%;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #e74c3c;
            margin: 15px 0;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .info-box {
            width: 48%;
            padding: 15px;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            color: #555;
        }

        .info-value {
            color: #333;
        }

        .divider {
            border-top: 1px dashed #999;
            margin: 20px 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #2c3e50;
            color: white;
            padding: 12px;
            text-align: right;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: right;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .total-section {
            margin-top: 30px;
            text-align: left;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .total-label {
            font-weight: bold;
            color: #2c3e50;
        }

        .total-value {
            font-weight: bold;
            color: #e74c3c;
        }

        .grand-total {
            font-size: 20px;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px solid #2c3e50;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        .stamp {
            float: left;
            width: 150px;
            height: 150px;
            border: 2px dashed #999;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="company-name">معرض الإدارة للأدوات الكهربائية</div>
        <div>رقم السجل التجاري: 248</div>
        <div class="invoice-title">فاتورة مبيعات</div>
        <div class="info-row">
            <span class="info-label">رقم الفاتورة:</span>
            <span class="info-value">INV-{{ str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">تاريخ الفاتورة:</span>
            <span class="info-value">{{ now()->format('Y-m-d') }}</span>
        </div>
    </div>

    <div class="invoice-info">
        <div class="info-box">
            <div class="section-title">بيانات البائع</div>
            <div class="info-row">
                <span class="info-label">الاسم:</span>
                <span class="info-value">معرض الإدارة للأدوات الكهربائية</span>
            </div>
            <div class="info-row">
                <span class="info-label">الهاتف:</span>
                <span class="info-value">021885114 - 025468888</span>
            </div>
            <div class="info-row">
                <span class="info-label">العنوان:</span>
                <span class="info-value">شارع الملك فهد، الرياض</span>
            </div>
        </div>

        <div class="info-box">
            <div class="section-title">بيانات العميل</div>
            <div class="info-row">
                <span class="info-label">الاسم:</span>
                <span class="info-value">أحمد محمد</span>
            </div>
            <div class="info-row">
                <span class="info-label">الهاتف:</span>
                <span class="info-value">0501234567</span>
            </div>
            <div class="info-row">
                <span class="info-label">العنوان:</span>
                <span class="info-value">حي النخيل، الرياض</span>
            </div>
        </div>
    </div>

    <div class="divider"></div>

    <div class="section-title">تفاصيل الفاتورة</div>

    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>اسم المنتج</th>
            <th>الوصف</th>
            <th>الكمية</th>
            <th>سعر الوحدة</th>
            <th>الإجمالي</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>1</td>
            <td>كورونا كهربائية</td>
            <td>كورونا كهربائية خلفة</td>
            <td>1</td>
            <td>500.00 SAR</td>
            <td>500.00 SAR</td>
        </tr>
        <tr>
            <td>2</td>
            <td>كورونا</td>
            <td>كورونا كهربائية</td>
            <td>2</td>
            <td>18.00 SAR</td>
            <td>36.00 SAR</td>
        </tr>
        <tr>
            <td>3</td>
            <td>كورونا</td>
            <td>كورونا كهربائية</td>
            <td>1</td>
            <td>1000.00 SAR</td>
            <td>1000.00 SAR</td>
        </tr>
        <tr>
            <td>4</td>
            <td>كورونا</td>
            <td>كورونا كهربائية</td>
            <td>3</td>
            <td>100.00 SAR</td>
            <td>300.00 SAR</td>
        </tr>
        <tr>
            <td>5</td>
            <td>كورونا</td>
            <td>كورونا كهربائية</td>
            <td>2</td>
            <td>700.00 SAR</td>
            <td>1400.00 SAR</td>
        </tr>
        <tr>
            <td>6</td>
            <td>كورونا</td>
            <td>كورونا كهربائية</td>
            <td>1</td>
            <td>800.00 SAR</td>
            <td>800.00 SAR</td>
        </tr>
        <tr>
            <td>7</td>
            <td>كورونا</td>
            <td>كورونا كهربائية</td>
            <td>8</td>
            <td>800.00 SAR</td>
            <td>6400.00 SAR</td>
        </tr>
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span class="total-label">المجموع الجزئي:</span>
            <span class="total-value">10,436.00 SAR</span>
        </div>
        <div class="total-row">
            <span class="total-label">الضريبة (15%):</span>
            <span class="total-value">1,565.40 SAR</span>
        </div>
        <div class="total-row grand-total">
            <span class="total-label">المبلغ الإجمالي:</span>
            <span class="total-value">12,001.40 SAR</span>
        </div>
    </div>

    <div class="stamp">
        ختم وتوقيع
    </div>

    <div class="footer">
        <p>شكراً لتعاملكم مع معرض الإدارة للأدوات الكهربائية</p>
        <p>للاستفسار يرجى الاتصال على: 021885114 - 025468888</p>
        <p>هذه الفاتورة صادرة بتاريخ {{ now()->format('Y-m-d') }}</p>
    </div>
</div>
</body>
</html>
