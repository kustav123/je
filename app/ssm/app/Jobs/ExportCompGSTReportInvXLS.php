<?php

namespace App\Jobs;

use App\Models\Appinfo;
use App\Models\InvoiceModel;
use App\Models\Report;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ExportCompGSTReportInvXLS implements ShouldQueue
{
    use Queueable;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $from;
    protected $to;
    protected $uid;
    protected $selectedCompany;
    protected $type;
    public function __construct($from, $to, $selectedCompany,$uid,$type)
    {
        $this->from = $from;
        $this->to = $to;
        $this->selectedCompany = $selectedCompany;
        $this->uid = $uid;
        $this->type = $type;
       
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $invoices = InvoiceModel::fetchByCompByDateAcc($this->selectedCompany, $this->from, $this->to, $this->type);
        $name = Appinfo::getName($this->selectedCompany);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "Company Invoice Report Of $name" )
        ->mergeCells('A1:J1')
        ->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A1:J1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->setCellValue('A2', " From Date: $this->from" )
        ->mergeCells('A2:E2')
        ->getStyle('A2')->getFont()->setBold(true);

        $sheet->setCellValue('F2', " To Date: $this->to" )
        ->mergeCells('F2:J2')
        ->getStyle('F2')->getFont()->setBold(true);

        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:E2')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('F2:J2')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A3:J3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->setCellValue('A3', 'Date')
              ->setCellValue('B3', 'Client Name')
              ->setCellValue('C3', 'Client GST')
              ->setCellValue('D3', 'State')
              ->setCellValue('E3', 'Invoice ID')
              ->setCellValue('F3', 'Amount ₹')
              ->setCellValue('G3', 'CGST ₹')
              ->setCellValue('H3', 'SGST ₹')
              ->setCellValue('I3', 'ISGT ₹')
              ->setCellValue('J3', 'Total Amount ₹');

              $rowNumber = 4;
              foreach ($invoices as $invoice) {
                $payslipid = substr($invoice->payslipid, 1);
                $sheet->setCellValue('A' . $rowNumber, $invoice->created_at->format('d-m-Y')) // Format date as d-m-Y
                        ->setCellValue('B' . $rowNumber, $invoice->clname)
                        ->setCellValue('C' . $rowNumber,  $invoice->gst)
                        ->setCellValue('D' . $rowNumber,  $invoice->state)
                        ->setCellValue('E' . $rowNumber, $invoice->uid)
                        ->setCellValue('F' . $rowNumber, $invoice->total_amount_excluding_gst ? '₹' . $invoice->total_amount_excluding_gst : '')
                        ->setCellValue('G' . $rowNumber, $invoice->total_cgst ? '₹' . $invoice->total_cgst : '')
                        ->setCellValue('H' . $rowNumber, $invoice->total_sgst ? '₹' . $invoice->total_sgst : '')
                        ->setCellValue('I' . $rowNumber, $invoice->total_igst ? '₹' . $invoice->total_igst : '')
                        ->setCellValue('J' . $rowNumber, $invoice->total_amount_including_gst ? '₹'.$invoice->total_amount_including_gst : '');
                  $rowNumber++;
              }
              $lastRow = $rowNumber - 1; // Last row with data
              $sheet->getStyle('A3:J' . $lastRow)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
              $fileName = "Invoice_Statement_{$name}_{$this->from}_to_{$this->to}_" . Str::random(5) . ".xlsx";
              $filePath = storage_path("app/public/{$fileName}");
              $writer = new Xlsx($spreadsheet);
              Report::deleteFile( $this->uid);
              Report::createReport($fileName, 'Xlsx',  $this->uid, $fileName  );

              $writer->save($filePath);


    
    }
}
