<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\InvoiceModel;
use App\Models\Report;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ExportClInvoicePdf implements ShouldQueue
{
    use Queueable;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $from;
    protected $to;
    protected $clid;
    protected $uid;
    
    protected $type;
    protected $status;
    protected $method;
    public function __construct($from, $to, $clid, $uid,$status,$type,$method)
    {
        $this->from = $from;
        $this->to = $to;
        $this->clid = $clid;
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
        $invoices = InvoiceModel::fetchByClidByDate($this->clid, $this->from, $this->to, $this->type, $this->status, $this->method);
        $name = Client::getName($this->clid);
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
            <h1>Client Invoice Report of " . htmlspecialchars($name) . "</h1>
            <h3>From " . htmlspecialchars($this->from) . " to " . htmlspecialchars($this->to) . "</h3>
         </div>
      <table border='1' cellpadding='5' cellspacing='0' style='width: 100%;'>
          <thead>
              <tr>
                  <th>Date</th>
                  <th>Invoice ID</th>
                  <th>Challan ID</th>
                  <th>Payslip ID</th>
                  <th>Amount</th>
                  <th>Due Amount </th>
                  <th>Paid Amount </th>
                  <th>Status</th>
              </tr>
             </thead>
             <tbody>";
             foreach ($invoices as $invoice) {
                $payslipid = substr($invoice->payslipid, 1);

                $html .= "
                <tr>
                    <td>" . $invoice->created_at->format('d-m-Y') . "</td>
                    <td>{$invoice->uid}</td>
                    <td>{$invoice->challan_id}</td>
                    <td> $payslipid</td>
                    <td>" . ($invoice->total_amount_including_gst ? '₹' . $invoice->total_amount_including_gst : '') . "</td>
                    <td>" . ($invoice->dueamount ? '₹' . $invoice->dueamount : '') . "</td>
                    <td>" . ($invoice->paidamount ? '₹' . $invoice->paidamount : '') . "</td>
                    <td>{$invoice->status}</td>
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
        $fileName = "GST_Invoice_Report_{$name}_{$this->from}_to_{$this->to}_" . Str::random(5) . ".pdf";
        $filePath = storage_path("app/public/{$fileName}");
        Report::deleteFile( $this->uid);
        Report::createReport($fileName, 'PDF',  $this->uid, $fileName  );
        file_put_contents($filePath, $dompdf->output());

    }
}
