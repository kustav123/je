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
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Str;

class ExportCompInvXls implements ShouldQueue
{
    use Queueable;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $from;
    protected $to;
    protected $uid;
    protected $selectedCompany;
    protected $type;
    protected $status;
    protected $method;

    public function __construct($from, $to, $selectedCompany,$uid, $status,$type, $method)
    {

        $this->from = $from;
        $this->to = $to;
        $this->selectedCompany = $selectedCompany;
        $this->uid = $uid;
        $this->type = $type;
        $this->status = $status;
        $this->method = $method;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $invoices = InvoiceModel::fetchByCompByDate($this->selectedCompany, $this->from, $this->to, $this->type, $this->status, $this->method);
        $name = Appinfo::getName($this->selectedCompany);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "Company Invoice Report Of $name" )
        ->mergeCells('A1:I1')
        ->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A1:I1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->setCellValue('A2', " From Date: $this->from" )
        ->mergeCells('A2:D2')
        ->getStyle('A2')->getFont()->setBold(true);

        $sheet->setCellValue('E2', " To Date: $this->to" )
        ->mergeCells('E2:I2')
        ->getStyle('E2')->getFont()->setBold(true);

        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:D2')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('E2:I2')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('A3:I3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->setCellValue('A3', 'Date')
              ->setCellValue('B3', 'Client Name')
              ->setCellValue('C3', 'Invoice ID')
              ->setCellValue('D3', 'Challan ID')
              ->setCellValue('E3', 'Payslip ID')
              ->setCellValue('F3', 'Amount')
              ->setCellValue('F3', 'Due Amount')
              ->setCellValue('H3', 'Paid Amount')
              ->setCellValue('I3', 'Status');

              $rowNumber = 4;
              foreach ($invoices as $invoice) {
                $payslipid = substr($invoice->payslipid, 1);
                $sheet->setCellValue('A' . $rowNumber, $invoice->created_at->format('d-m-Y')) // Format date as d-m-Y
                        ->setCellValue('B' . $rowNumber, $invoice->clname)
                        ->setCellValue('C' . $rowNumber, $invoice->uid)
                        ->setCellValue('D' . $rowNumber, $invoice->challan_id)
                        ->setCellValue('E' . $rowNumber, $payslipid)
                        ->setCellValue('F' . $rowNumber, $invoice->total_amount_including_gst ? '₹'.$invoice->total_amount_including_gst : '')
                        ->setCellValue('G' . $rowNumber, $invoice->dueamount ? '₹'.$invoice->paidamount : '')
                        ->setCellValue('H' . $rowNumber, $invoice->dueamount ? '₹'.$invoice->paidamount : '')
                        ->setCellValue('I' . $rowNumber, $invoice->status);

                  $rowNumber++;
              }
              $lastRow = $rowNumber - 1; // Last row with data
              $sheet->getStyle('A3:I' . $lastRow)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);



              $fileName = "Invoice_Report_{$name}_{$this->from}_to_{$this->to}_" . Str::random(5) . ".xlsx";
              $filePath = storage_path("app/public/{$fileName}");
              $writer = new Xlsx($spreadsheet);
              Report::deleteFile( $this->uid);
              Report::createReport($fileName, 'Xlsx',  $this->uid, $fileName  );

              $writer->save($filePath);


    }
}
