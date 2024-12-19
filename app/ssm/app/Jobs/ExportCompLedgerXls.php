<?php

namespace App\Jobs;

use App\Models\Appinfo;
use App\Models\CoLedger;
use App\Models\Report;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Str;

class ExportCompLedgerXls implements ShouldQueue
{
    use Queueable;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $from;
    protected $to;
    protected $uid;
    protected $selectedCompany;

    public function __construct($from, $to, $selectedCompany,$uid)
    {
        $this->from = $from;
        $this->to = $to;
        $this->selectedCompany = $selectedCompany;
        $this->uid = $uid;
    }


    public function handle(): void
    {
        $ledgers = CoLedger::fetchByCompidByDate($this->selectedCompany, $this->from, $this->to);
        $name = Appinfo::getName($this->selectedCompany);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "Company Ledger Report Of $name" )
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
              ->setCellValue('C3', 'Narration')
              ->setCellValue('D3', 'Reference')
              ->setCellValue('E3', 'Credit')
              ->setCellValue('F3', 'Payment')
              ->setCellValue('G3', 'Type')
              ->setCellValue('G3', 'Transaction ID')
              ->setCellValue('I3', 'Balance');

        $rowNumber = 4;
        foreach ($ledgers as $ledger) {
            $sheet->setCellValue('A' . $rowNumber, $ledger->date)
                  ->setCellValue('B' . $rowNumber, $ledger->clname)
                  ->setCellValue('C' . ($rowNumber ), $ledger->remarks)
                ->setCellValue('D' . ($rowNumber ), $ledger->refno)
                ->setCellValue('E' . ($rowNumber ), $ledger->credit ? '₹'.$ledger->credit : '')
                ->setCellValue('F' . ($rowNumber ), $ledger->debit ? '₹'.$ledger->debit : '')
                ->setCellValue('G' . ($rowNumber ), $ledger->mode)
                ->setCellValue('H' . ($rowNumber ), $ledger->tid)
                ->setCellValue('I' . ($rowNumber ), '₹'.$ledger->current_amount);
            $rowNumber++;
        }
        $lastRow = $rowNumber - 1; // Last row with data
        $sheet->getStyle('A3:I' . $lastRow)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);



        $fileName = "Ledger_Report_{$name}_{$this->from}_to_{$this->to}_" . Str::random(5) . ".xlsx";
        $filePath = storage_path("app/public/{$fileName}");

        $writer = new Xlsx($spreadsheet);
        Report::deleteFile( $this->uid);
        Report::createReport($fileName, 'Xlsx',  $this->uid, $fileName  );

        $writer->save($filePath);
    }
}
