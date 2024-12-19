<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\ClientLeadger;
use App\Models\Report;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Str;


class ExportLedgerCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $from;
    protected $to;
    protected $clid;
    protected $uid;


    /**
     * Create a new job instance.
     */
    public function __construct($from, $to, $clid, $uid)
    {
        $this->from = $from;
        $this->to = $to;
        $this->clid = $clid;
        $this->uid = $uid;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Query invoices based on the date range
        $ledgers = ClientLeadger::fetchByClidByDate($this->clid, $this->from, $this->to);
        $name = Client::getName($this->clid);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "Client Ledger Report Of $name" )
        ->mergeCells('A1:H1')
        ->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A1:H1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

        $sheet->setCellValue('A2', " From Date: $this->from" )
        ->mergeCells('A2:D2')
        ->getStyle('A2')->getFont()->setBold(true);

        $sheet->setCellValue('E2', " To Date: $this->to" )
        ->mergeCells('E2:H2')
        ->getStyle('E2')->getFont()->setBold(true);

        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:D2')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
        $sheet->getStyle('E2:H2')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);


        $sheet->getStyle('A3:H3')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->setCellValue('A3', 'Date')
              ->setCellValue('B3', 'Narration')
              ->setCellValue('C3', 'Reference')
              ->setCellValue('D3', 'Credit')
              ->setCellValue('E3', 'Payment')
              ->setCellValue('F3', 'Type')
              ->setCellValue('G3', 'Transaction ID')
              ->setCellValue('H3', 'Balance');

        $rowNumber = 4;
        foreach ($ledgers as $ledger) {
            $sheet->setCellValue('A' . $rowNumber, $ledger->date)
                  ->setCellValue('B' . $rowNumber, $ledger->remarks)
                  ->setCellValue('C' . $rowNumber, $ledger->refno)
                  ->setCellValue('D' . $rowNumber, $ledger->credit ? '₹'.$ledger->credit : '')
                  ->setCellValue('E' . $rowNumber, $ledger->debit ? '₹'.$ledger->debit : '')
                  ->setCellValue('F' . $rowNumber, $ledger->mode)
                  ->setCellValue('G' . $rowNumber, $ledger->tid)
                  ->setCellValue('H' . $rowNumber, '₹'.$ledger->current_amount);
            $rowNumber++;
        }
        $lastRow = $rowNumber - 1; // Last row with data
        $sheet->getStyle('A3:H' . $lastRow)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);



        $fileName = "Ledger_Report_{$name}_{$this->from}_to_{$this->to}_" . Str::random(5) . ".xlsx";
        $filePath = storage_path("app/public/{$fileName}");

        $writer = new Xlsx($spreadsheet);
        Report::deleteFile( $this->uid);
        Report::createReport($fileName, 'Xlsx',  $this->uid, $fileName  );

        $writer->save($filePath);
    }
}
