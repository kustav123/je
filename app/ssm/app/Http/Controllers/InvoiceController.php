<?php

namespace App\Http\Controllers;

use App\Models\Appinfo;
use App\Models\Client;
use App\Models\AuditLogModel;
use App\Models\ClientLeadger;
use App\Models\CoLedger;
use App\Models\Nextval;
use App\Models\delivery_challan_main;
use App\Models\DeliveryChallanData;
use App\Models\Hsn;
use App\Models\InvoiceItemsModel;
use App\Models\InvoiceModel;
use App\Models\Jobcomments;
use App\Models\Jobs;
use App\Models\NumberToWordModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    private function getChallanDetails($challanId)
    {
        return delivery_challan_main::select([
            DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as formatted_created_at')
        ])->where('id', $challanId)->first();
    }

    private function setInvoiceData($data)
    {
        // Insert into invoice table
        // Update invoice = 1 in delivery_challan_data table
        try {
            DB::transaction(function () use ($data) {
                $invoice = $data['invoice'];
                $challan = $data['challan'];
                $invtype = $data['invtype'];

                $clientName = (array_key_exists('name', $data['client'])) ? $data['client']['name'] : '';

                $amount = $data['amount'];
                $inid =  $invoice['id'];
                InvoiceModel::create([
                    'uid' => $invoice['id'],
                    'challan_id' => $challan['id'],
                    'company_id' => $data['companyId'],
                    'type' => $data['type'],
                    'invtype' => $data['invtype'],
                    'data_dispach' => $data['dispatchedthrough'],
                    'data_suploc' => $data['placeofsupply'],
                    'data_order_no' => $data['orderno'],
                    'data_orderdate' => $data['orderdate'],
                    'clname' => $clientName,
                    'client_id' => $data['clientId'],
                    'total_igst' => $invtype == 'gst' ? $amount['totalIgst'] : null,
                    'total_cgst' => $invtype == 'gst' ? $amount['totalCgst'] : null,
                    'total_sgst' => $invtype == 'gst' ? $amount['totalSgst'] : null,
                    'total_amount_excluding_gst' => $invtype == 'gst' ? $amount['totalExcludingGst'] : null,
                    'total_amount_including_gst' => $amount['totalIncludingGst'],
                    'dueamount' => $amount['totalIncludingGst'],
                    'status' => 'Due',
                    'amount_in_word' => $data['amountInWord'],
                    'data_company' => json_encode($data['company']),
                    'data_challan' => json_encode($data['challan']),
                    'data_client' => json_encode($data['client']),
                    'data_amount' => json_encode($data['amount']),
                    'data_invoice_items' => json_encode($data['invoiceData']),
                    'created_at' => date("Y-m-d H:i:s"),

                ]);
                $ref = ($invtype == 'gst') ? 'GST Invoice' : 'Non GST Invoice';

                // print_r($clientName);
                // die;

                //hard code:: alaways updatedue first before leadger update
                Appinfo::updatedue($data['companyId'], $amount['totalIncludingGst'], 'due');
                CoLedger::addent($data['companyId'], $data['clientId'], $clientName, 'due', date("Y-m-d"), $amount['totalIncludingGst'],  'Invoice Created', $invoice['id'], $ref, $challan['id']);

                //hard code:: alaways updatedue first before leadger update
                Client::updatedue($data['clientId'], $amount['totalIncludingGst'], 'due');
                ClientLeadger::addent($data['clientId'], 'due', date("Y-m-d"), $amount['totalIncludingGst'],  'Invoice Created', $invoice['id'], $ref, $challan['id'], $data['companyId']);

                foreach ($data['invoiceData'] as $key => $value) {
                    InvoiceItemsModel::create([
                        'invoice_id' => $invoice['id'],
                        'job_id' => $value['jobId'],
                        'item' => $value['item'],
                        'make' => $value['make'],
                        'model' => $value['model'],
                        'snno' => $value['snno'],
                        'hsnId' => $invtype == 'gst' ? $value['hsnId'] : null,
                        'hsn' => $invtype == 'gst' ? $value['hsn'] : null,
                        'narretion' => $value['narretion'],
                        'rate' => $value['rate'],
                        'cgst' => $invtype == 'gst' ? $value['cgst'] : null,
                        'sgst' => $invtype == 'gst' ? $value['sgst'] : null,
                        'igst' => $invtype == 'gst' ? $value['igst'] : null,
                        'igst_percentage' => $invtype == 'gst' ? $value['igstPercentage'] : null,
                        'total' => $value['total'],
                        'created_at' => date("Y-m-d H:i:s"),
                    ]);

                    DeliveryChallanData::where([
                        'dcId' => $challan['id'],
                        'jobId' => $value['jobId']
                    ])->update([
                        'invoice' => '1'
                    ]);

                    Jobs::where('id', $value['jobId'])->update([
                        'status' => 'Invoice Generated',
                        'billed' => 1
                    ]);
                    Jobcomments::create([
                        'jbid' => $value['jobId'],
                        'usid' => Auth::user()->id,
                        'type' => 'App',
                        'message' => "Invoice Generated $inid",
                    ]);
                }
                delivery_challan_main::where([
                    'id' => $challan['id']
                ])->update([
                    'invoiceid' => DB::raw("
                        CASE
                            WHEN invoiceid = '' OR invoiceid IS NULL THEN '$inid'
                            ELSE CONCAT(invoiceid, ', $inid')
                        END
                    ")
                ]);
                $remainingInvoices = DeliveryChallanData::where([
                    'dcId' => $challan['id'],
                    'invoice' => '0',
                    'status' => 'Repaired'
                ])->count();
                if ($remainingInvoices == 0) {
                    delivery_challan_main::where(['id' => $challan['id']])->update([
                        'invoice' => '1'
                    ]);
                    DeliveryChallanData::where(['dcid' => $challan['id']])->update([
                        'invoice' => '1'
                    ]);
                }

                InvoiceModel::increaseInvoiceIdNumber($data['companyId'], $data['type'], $data['invtype']);
                AuditLogModel::addAudit(Auth::user()->id,
                'Invoice',
                "Invoice {$invoice['id']} Created for {$clientName}"
                );
            });
            return true;
        } catch (\Exception $e) {
            Log::error('Error in generating invoice: ' . $e->getMessage());
            DB::rollback();
            return false;
        }
    }

    private function generatePassedDataArray($invoiceData, $amount, $clientId, $clientData, $companyId, $appIndoData, $challan, $invoice, $type, $orderno, $orderdate, $dispatchedthrough, $placeofsupply, $invtype)
    {
        return  [
            'invoiceData' => $invoiceData,
            'amount' => $amount,
            'amountInWord' => NumberToWordModel::getIndianCurrency($amount['totalIncludingGst']),
            'clientId' => $clientId,
            'client' => $clientData,
            'companyId' => $companyId,
            'type' => $type,
            'company' => $appIndoData,
            'challan' => $challan,
            'invoice' => $invoice,
            'invtype' => $invtype,
            'orderno' => $orderno,
            'orderdate' => $orderdate,
            'dispatchedthrough' => $dispatchedthrough,
            'placeofsupply' => $placeofsupply,
        ];
    }

    public function generateInvoice(Request $request)
    {
        $invoiceData = $request->invoiceData;
        $amount = $request->amount;
        $clientId = $request->clientId;
        $companyId = $request->companyId;
        $challanId = $request->challanId;
        $type = $request->type;
        $orderno = $request->orderno;
        $orderdate = $request->orderdate;
        $dispatchedthrough = $request->dispatchedthrough;
        $placeofsupply = $request->placeofsupply;
        $invtype = $request->invtype;
        $clientData = [
            'name' => $request->name,
            'address' => $request->address,
            'mobile' => $request->mobileNumber,
            'email' => $request->email,
            'gst' => $request->gst_no,
            'state' => $request->state
        ];

        $appInfo = new AppinfoController();
        $appIndoData = $appInfo->byid($companyId);

        $challanData = $this->getChallanDetails($challanId);

        $challan = [
            'id' => $challanId,
            'date' => $challanData['formatted_created_at']
        ];

        $invoice = [
            //Hard coded logic Adjust for other company

            'id' => InvoiceModel::gstSrVgenerateInvoiceId($companyId, $type, $invtype),
            'date' => date("d-M-Y")
        ];

        $passedData = $this->generatePassedDataArray($invoiceData, $amount, $clientId, $clientData, $companyId, $appIndoData, $challan, $invoice, $type, $orderno, $orderdate, $dispatchedthrough, $placeofsupply, $invtype);

        // Database insertion code---

        if (!$this->setInvoiceData($passedData)) {
            return response()->json([
                'success' => false,
                'html' => ""
            ]);
        }

        $returnHTML = view('template.invoice')->with($passedData)->render();

        return response()->json([
            'success' => true,
            'html' => $returnHTML
        ]);
    }

    public function listgstsrvinv(Request $request)
    {
        $itype = $request->invtype;
        $type = ($itype === 'gst')
            ? ['gst']
            : (($itype === 'nongst')
                ? ['nongst']
                : ['gst', 'nongst']);

        $uid = $request->clid;
        $data = InvoiceModel::select([
            'uid',
            DB::raw('DATE_FORMAT(created_at, "%d %b %Y") as formatted_created_at'),
            'payslipid',
            'status',
            'total_amount_including_gst',
            'dueamount',
            'paidamount',
            'type',
            'invtype',
        ])->where('client_id', $uid)
            ->whereIn('invtype', $type)
            ->orderBy('created_at', 'desc')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return view('admin.cldtl.actioninv', compact('row'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function notpaidinv(Request $request)
    {
         // ******
        // If there is any changes updagte same on notpaidinv function on model file 
        $clid = $request->clid;
        $coid = $request->coid;

        // $lockKey = 'lockinv:' . $clid;
        // $lockValue = Auth::user()->name;

        // if (Cache::has($lockKey)) {
        //     $lockedBy = Cache::get($lockKey);
        //     return response()->json([
        //         'error' => "Error, client is locked for payment by {$lockedBy}"
        //     ], 403);
        // }

        // Cache::put($lockKey, $lockValue, now()->addMinutes(1));
        $data = InvoiceModel::select([
            'uid',
            DB::raw('DATE_FORMAT(created_at, "%d %b %Y") as formatted_created_at'),
            'total_amount_including_gst',
            'dueamount'
        ])->where('client_id', $clid)
        ->where('status', '!=', 'Paid')
        ->where('company_id', $coid)
            ->get();

        return response()->json($data);
    }

    public function invgstprn(Request $request)
    {
        $invid = $request->invid;
        $data = InvoiceModel::where('uid', $invid)->get();
        // Log::info('Fetched Invoice Data:', ['data' => $data->toArray()]);
        $invoice = $data->first();

        $invoiceData = json_decode($invoice->data_invoice_items, true);
        $amount = json_decode($invoice->data_amount, true);
        $clientId = $invoice->client_id;
        $clientData = json_decode($invoice->data_client, true);
        $companyId = $invoice->company_id;
        $type = $invoice->type;
        $invtype = $invoice->invtype;
        $appIndoData = json_decode($invoice->data_company, true);
        $challan = json_decode($invoice->data_challan, true);
        $orderno = $invoice->data_order_no;
        $orderdate = Carbon::parse($invoice->data_orderdate)->format('d-m-Y');
        $dispatchedthrough = $invoice->data_dispach;
        $placeofsupply = $invoice->data_suploc;
        $invoice = [
            'id' => $invid,
            'date' => Carbon::parse($invoice->created_at)->format('d-m-Y'),
        ];

        $passedData = $this->generatePassedDataArray($invoiceData, $amount, $clientId, $clientData, $companyId, $appIndoData, $challan, $invoice, $type, $orderno, $orderdate, $dispatchedthrough, $placeofsupply, $invtype);

        $returnHTML = view('template.invoice')->with($passedData)->render();
        return response()->json([
            'success' => true,
            'html' => $returnHTML
        ]);
    }

    public function getInvoiceData(Request $request){
        $purpose = $request->input('purpose');
        $invoiceId = $request->input('invoiceId');

        // Settings
        $maxPermissableJobCountForPLUS = 3;
        $maxPermissableJobCountForMINUS = 1;

        // Get count of how many jobs in this selected invoiceId
        $inInvoiceJobsCount = InvoiceItemsModel::where('invoice_id', $invoiceId)->count();

        // Get HSN data for price calculation
        $hsn = Hsn::select('id', 'name', 'cgst', 'sgst')->where('status', 1)->get();

        $invoiceModel = new InvoiceModel();

        if($purpose === 'PLUS'){

            if($inInvoiceJobsCount >= $maxPermissableJobCountForPLUS){
                return response()->json([
                    'success'=> false,
                    'message' => "can't add jobs, max supported $maxPermissableJobCountForPLUS",
                ]);
            }

            $allocatedJobs = $invoiceModel->getAllocatedJobs($invoiceId);
                      
            $unallocatedJobs = $invoiceModel->getUnallocatedJobs($invoiceId);
            
            return response()->json([
                'success'=> true,
                'message' => "Success",
                'hsn' => $hsn,
                'allocatedJobs' => $allocatedJobs,
                'unallocatedJobs' => $unallocatedJobs
            ]);
        }else if($purpose === 'MINUS'){

            if($inInvoiceJobsCount <= $maxPermissableJobCountForMINUS){
                return response()->json([
                    'success'=> false,
                    'message' => "can't substract jobs, only $maxPermissableJobCountForMINUS job left",
                ]);
            }

            // Get Invoices with Same Delivery Challan ID Status invoice = 1
        }
    }
    public function delInvoice(Request $request)
    // remove all from inv iteam then maun inv , update statud in DC item , update statu
    // in job , - from client due and comp due, put on both ledger , update old ent of ledger
    // update on next val

    {
        $inv = $request ->id;
        $jobs = InvoiceItemsModel::where('invoice_id', $inv)->pluck('job_id');
        $invoice = InvoiceModel::where('uid', $inv)->select('total_amount_including_gst', 'client_id', 
        'challan_id','company_id','invtype','type', 'status')->first();

           
        $status = $invoice->status;
// Log::info($invoice->status);

        if ($status !== 'Due') {
                return  response()->json([
                    'message' => 'Deletion not allowed. Please remove the payment entry first.'
                ], 403);
        } else {
         try {    
              
            DB::transaction(function () use ($invoice, $jobs,$inv) {
                $amount = $invoice->total_amount_including_gst;
                $clid = $invoice->client_id;
                $dcid = $invoice->challan_id;
                $company = $invoice->company_id;
                $invtype = $invoice->invtype;
                $ref = ($invtype == 'gst') ? 'GST Invoice' : 'Non GST Invoice';

                $type = $invoice->type;
                $clientName = Client::find($clid)->name;
                InvoiceItemsModel::where('invoice_id', $inv)->delete();
                InvoiceModel::where('uid', $inv)->delete();
                foreach ($jobs as $job) {
                    Jobcomments::create([
                        'jbid' => $job,
                        'message' => "Deleted from Invoice $inv",
                        'usid' => Auth::id(),
                        'type' => 'App',
                    ]);
                    Jobs::where('id', $job)->update([
                        'status' => 'Delivery Challan Generated',
                        'billed' => NULL
                    ]);
                    DeliveryChallanData::where([
                        'dcId' => $dcid,
                        'jobId' => $job
                    ])->update([
                        'invoice' => '0'
                    ]);
                }
               
                delivery_challan_main::where(['id' => $dcid])->update([
                        'invoice' => NULL
                ]);
                    
                CoLedger::where('refno', $inv)->update([
                    'remarks' => "Invoice (Deleted)"
                ]);
                ClientLeadger::where('refno', $inv)->update([
                    'remarks' => "Invoice (Deleted)"
                ]);
                Appinfo::updatedue($company, $amount, 'pay');
                CoLedger::addent($company, $clid, $clientName, 'pay', date("Y-m-d"), $amount,  'Invoice Deleted ', $inv, $ref, '---');

                Client::updatedue($clid, $amount, 'pay');
                ClientLeadger::addent($clid, 'pay', date("Y-m-d"), $amount,  'Invoice Deleted', $inv, $ref, '---', $company);

                

                //update swq

                //logic from invoice model :: 
                if ($company == 1) {

                    if ($invtype == 'gst') {
                        if ($type == 'S') {
                            // Logic for when $compid == 1 and $type == 'S'
                            $sequenceType = "igfes";
                        } elseif ($type == 'P') {
                            // Logic for when $compid == 1 and $type == 'P'
                            $sequenceType = "igfep";
                        }
                    } else {
                        if ($type == 'S') {
                            // Logic for when $compid == 1 and $type == 'S'
                            $sequenceType = "ingfes";
                        } elseif ($type == 'P') {
                            // Logic for when $compid == 1 and $type == 'P'
                            $sequenceType = "ingfep";
                        }
                    }
                } else {
                    if ($invtype == 'gst') {

                        if ($type == 'S') {
                            // Logic for when $compid != 1 and $type == 'S'
                            $sequenceType = "igfls";
                        } elseif ($type == 'P') {
                            // Logic for when $compid != 1 and $type == 'P'
                            $sequenceType = "igflp";
                        }
                    } else {

                        if ($type == 'S') {
                            // Logic for when $compid != 1 and $type == 'S'
                            $sequenceType = "ingfls";
                        } elseif ($type == 'P') {
                            // Logic for when $compid != 1 and $type == 'P'
                            $sequenceType = "ingflp";
                        }
                    }
                }
                $parts = explode('/', $inv);
                $lastPart = end($parts);

                AuditLogModel::addAudit(Auth::user()->id,
                'Invoice',
                "Invoice {$inv} Removed for {$clientName}"
                );

                Nextval::where('type', $sequenceType)->update(['sno' => $lastPart]);
             });
                } catch (\Exception $e) {
                    Log::error('Error in removeing invoice: ' . $e->getMessage());
                    DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => 'Error in removing invoice: ' . $e->getMessage()
                    ], 500);                }
        }
   

        
        // Log::info('Invoice Jobs:', ['jobs' => $jobs]);
        // Log::info('Invoice Total Amount (Including GST):', ['amount' => $amount]);
        
      
    }
}
