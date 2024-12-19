<?php

namespace App\Jobs;

use App\Models\Appinfo;
use App\Models\InvoiceModel;
use App\Models\Report;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Str;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportCompGSTReportInvPDF implements ShouldQueue
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

        $html = "

        <style>
             @font-face {
                font-family: 'DejaVu Sans';
                src: url('https://cdn.jsdelivr.net/gh/dompdf/dompdf/lib/fonts/DejaVuSans-Bold.ttf');
                font-weight: bold;
                }
                body {
                    font-family: 'DejaVu Sans', sans-serif;
                    background-color: #e4fffd; /* Body background color */
                }
                h1, h3 {
                    text-align: center;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid #f57d81; /* Table border color */
                }
                th {
                    background-color: #ffd3a5; /* Table header fill color */
                    color: #022353; /* Table header text color */
                }
                td {
                    color: #817df5; /* Table row text color */
                    padding: 8px;
                    text-align: left;
                }
          </style>
         <div style='background-color: #8ff5b6; color: #b44a59; padding: 20px;'>
            <h1>GST Invoice Report of " . htmlspecialchars($name) . "</h1>
            <h3>From " . htmlspecialchars($this->from) . " to " . htmlspecialchars($this->to) . "</h3>
         </div>
      <table border='1' cellpadding='5' cellspacing='0' style='width: 100%;'>
          <thead>
               <tr>
                    <th>Date</th>
                    <th>Client Name</th>
                    <th>Client GST</th>
                    <th>State</th>
                    <th>Invoice ID</th>
                    <th>Amount ₹</th>
                    <th>CGST ₹</th>
                    <th>SGST ₹</th>
                    <th>ISGT ₹</th>
                    <th>Total Amount ₹</th>
                </tr>
             </thead>
             <tbody>";
             foreach ($invoices as $invoice) {
                $payslipid = substr($invoice->payslipid, 1);

                $html .= "
                <tr>
                    <td>" . $invoice->created_at->format('d-m-Y') . "</td>
                    <td>{$invoice->clname}</td>
                     <td>{$invoice->gst}</td>
                     <td>{$invoice->state}</td>
                    <td>{$invoice->uid}</td>
                    <td>" . ($invoice->total_amount_excluding_gst ? '₹' . $invoice->total_amount_excluding_gst : '') . "</td>
                    <td>" . ($invoice->total_cgst ? '₹' . $invoice->total_cgst : '') . "</td>
                    <td>" . ($invoice->total_sgst ? '₹' . $invoice->total_sgst : '') . "</td>
                    <td>" . ($invoice->total_igst ? '₹' . $invoice->total_igst : '') . "</td>
                    <td>" . ($invoice->total_amount_including_gst ? '₹' . $invoice->total_amount_including_gst : '') . "</td>
                </tr>";
            }
            $html .= "
            </tbody>
        </table>";
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $fileName = "Invoice_Statement_{$name}_{$this->from}_to_{$this->to}_" . Str::random(5) . ".pdf";
        $filePath = storage_path("app/public/{$fileName}");
        Report::deleteFile( $this->uid);
        Report::createReport($fileName, 'PDF',  $this->uid, $fileName  );
        file_put_contents($filePath, $dompdf->output());
    }
}
