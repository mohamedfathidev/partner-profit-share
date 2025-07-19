<?php

namespace App\Services;

use PDF;

class PdfService
{
    public function generatePdf(string $view, array $data, string $header = "التقرير")
    {
        $pdf = PDF::loadView($view, [
            "partners" => $data['partners'],
            "totalBalance" => $data['totalArray']['totalBalance'],
            "totalWithdrawals" => $data['totalArray']['totalWithdrawals'],
            "totalDeposits" => $data['totalArray']['totalDeposits'],
            "totalTransactions" => $data['totalArray']['totalTransactions'],
            "totalProfitShares" => $data['totalArray']['totalProfitShares'],
            "startOfMonth" => $data['startOfMonth'] ?? null,
            "fromDate" => $data['fromDate'] ?? null,
            "toDate" => $data['toDate'] ?? null,
        ]);

        // إضافة Watermark
        $pdf->getMpdf()->SetWatermarkText('ABN-MANSOUR');
        $pdf->getMpdf()->showWatermarkText = true;
        $pdf->getMpdf()->watermarkTextAlpha = 0.1; // شفافية العلامة المائية

        $pdf->getMpdf()->SetHTMLHeader('
            <div style="text-align: center; font-family: Cairo; font-size: 12px; color: #666;">
                "$header" - ABN-MANSOUR
            </div>
        ');

        // إضافة الفوتر مع رقم الصفحة
        $pdf->getMpdf()->SetHTMLFooter('
            <div style="display: flex; justify-content: space-between; align-items: center; font-family: Cairo; font-size: 10px; color: #666;">
                    <div>Developed By Mohamed Fathi | 01020131424</div>
                    <div style="font-weight: bold;text-decoration: underline">صفحة {PAGENO}</div>
            </div>
        ');

        return $pdf->stream($header . now()->format('Y-m-d') . '.pdf');
    }


    public function generatePartnerPdf(string $view, $data, string $header = "التقرير")
    {
        $pdf = PDF::loadView($view, [
            "partner" => $data['partner'],
            "startOfMonth" => $data['startOfMonth'] ?? null,
            "endOfMonth" => $data['endOfMonth'] ?? null,
            "fromDate" => $data['fromDate'] ?? null,
            "toDate" => $data['toDate'] ?? null,
        ]);

        // إضافة Watermark
        $pdf->getMpdf()->SetWatermarkText('ABN-MANSOUR');
        $pdf->getMpdf()->showWatermarkText = true;
        $pdf->getMpdf()->watermarkTextAlpha = 0.1; // شفافية العلامة المائية

        $pdf->getMpdf()->SetHTMLHeader('
            <div style="text-align: center; font-family: Cairo; font-size: 12px; color: #666;">
                "$header" - ABN-MANSOUR
            </div>
        ');

        // إضافة الفوتر مع رقم الصفحة
        $pdf->getMpdf()->SetHTMLFooter('
            <div style="display: flex; justify-content: space-between; align-items: center; font-family: Cairo; font-size: 10px; color: #666;">
                    <div>Developed By Mohamed Fathi | 01020131424</div>
                    <div style="font-weight: bold;text-decoration: underline">صفحة {PAGENO}</div>
            </div>
        ');

        return $pdf->stream($header . now()->format('Y-m-d') . '.pdf');
    }

}
