<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\AuditLogModel;
use App\Models\Dchistory;
use App\Models\delivery_challan_main;
use App\Models\DeliveryChallanData;
use App\Models\Hsn;
use App\Models\Jobcomments;
use App\Models\Jobs;
use App\Models\Jobsitem;
use App\Models\Nextval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class DeliveryChallan extends Controller
{
    public function index()
    {
        $appinfo = new AppinfoController();
        $listcomp = $appinfo->getlist();

        $centeredText = 'Delevery Challan';

        return view('delivery-challan.index', ['listcomp' => $listcomp], compact('centeredText'));
    }

    public function getDeliveryableAllDataByClientId(Request $request)
    {
        $sql = "SELECT
            j.id AS jobId,
            j.echarge,
            ji.item,
            ji.make,
            ji.model,
            ji.proprty,
            ji.snno,
            ji.accessary,
            ji.complain,
            jc.message as remarks
        FROM job j
        LEFT JOIN job_item ji ON j.id = ji.jobid
        LEFT JOIN (
            SELECT jc1.*
            FROM job_comment jc1
            JOIN (
                SELECT jbid, MAX(created_at) AS max_created_at
                FROM job_comment
                WHERE type = 'Challan'
                GROUP BY jbid
            ) jc2 ON jc1.jbid = jc2.jbid AND jc1.created_at = jc2.max_created_at
            WHERE jc1.type = 'Challan'
        ) jc ON j.id = jc.jbid
        WHERE j.clid = '{$request->clientid}'
        AND j.status = 'Ready for delivery'
        AND j.chalan IS NULL;";

        $data = DB::select($sql);
        return response()->json([
            'status' => true,
            'message' => 'Data fetched successfully.',
            'data' => $data
        ]);
    }

    public function generateDeliveryChannal(Request $request)
    {
        $customerId = $request->customerId;
        $data = json_decode($request->selectedData, true);

        $sequence = DB::table('nextval')
            ->select('sno', 'head')
            ->where('type', 'dc')
            ->lockForUpdate()
            ->first();
        $head = $sequence->head;
        $newJobId = $sequence->sno;
        $newJobId = str_pad($newJobId, 3, '0', STR_PAD_LEFT);
        $newJobId = $head . '/' . $newJobId;

        DB::transaction(function () use ($request, $newJobId, $customerId, $data) {

            delivery_challan_main::create([
                'id' => $newJobId,
                'clid' => $customerId,
                'comp' => $request->selectedCompany,
                'name' => $request->name,
                'mobile' => $request->mobile_number,
                'address' => $request->address,
                'gst' => $request->gst_no,
                'email' => $request->email

            ]);
            foreach ($data as $key => $value) {
                if (isset($value['checked']) && $value['checked']) {
                    Jobs::where('id', $value['jobId'])->where('clid', $customerId)->update([
                        'status' => 'Delivery Challan Generated',
                        'chalan' => 1
                    ]);
                    Jobcomments::create([
                        'jbid' => $value['jobId'],
                        'usid' => Auth::user()->id,
                        'type' => 'App',
                        'message' => "Chalan Generated $newJobId",
                    ]);
                    $value['dcId'] = $newJobId;
                    DeliveryChallanData::create($value);
                }
            }

            DB::table('secuence')
                ->where('type', 'dc')
                ->increment('sno');

            $cursequence = DB::table('secuence')
                ->where('type', 'dc')
                ->value('sno'); // Using 'value' to get a single column's value
            $newSequence = $cursequence + 1;

            Nextval::where('type', 'dc')->update(['sno' => $newSequence]);
        });
        AuditLogModel::addAudit(Auth::user()->id,
            'Chalan Created',
            "Chalan {$newJobId} created for {$customerId}"
        );
        $appinfo = new AppinfoController();
        $getcomp = $appinfo->byid($request->selectedCompany);

        $companyDetails = [
            'CompName' => $getcomp->cname,
            'CompLogo' => $getcomp->logo,
            'CompAddress' => $getcomp->address,
            'CompGST' => $getcomp->gstno,
            'Compemail' => $getcomp->email,
            'Compcont1' => $getcomp->cont1,
            'Compcont2' => $getcomp->cont2,
        ];

        $resdata = DeliveryChallanData::select('*')
            ->where('dcId', $newJobId)
            ->get();

        $cldtl = [
            'Clname' => $request->name,
            'cadd' => $request->address,
            'CEmail' => $request->email,
            'cmob' => $request->mobile_number,
            'cgst' => $request->gst_no,

        ];
        return response()->json([
            'status' => true,
            'message' => 'successfully created',
            'companyDetails' => $companyDetails,
            'cldtl' => $cldtl,
            'data' => $resdata,
            'dcid' => $newJobId

        ]);
    }
    public function jobCountBychalan(Request $request)
    {

        $count = DeliveryChallanData::where('dcid', $request->dcid)->count();
        return response()->json([
            'count' => $count
        ]);
    }

    public function addJObtoChallen(Request $request)
    {
        $dcId = $request->dcid;
        $data = json_decode($request->selectedData, true);

        DB::transaction(function () use ($request, $dcId, $data) {

            foreach ($data as $key => $value) {
                if (isset($value['checked']) && $value['checked']) {
                    Jobs::where('id', $value['jobId'])->update([
                        'status' => 'Delivery Challan Generated',
                        'chalan' => 1
                    ]);
                    Jobcomments::create([
                        'jbid' => $value['jobId'],
                        'usid' => Auth::user()->id,
                        'type' => 'App',
                        'message' => "Chalan Generated $dcId",
                    ]);
                    Dchistory::create([
                        'dcid' => $dcId,
                        'usid' => Auth::user()->id,
                        'type' => 'user',
                        'message' => "{$value['jobId']} Added",
                    ]);
                    $value['dcId'] = $dcId;
                    DeliveryChallanData::create($value);
                    AuditLogModel::addAudit(Auth::user()->id,
                        'Chalan Updated',
                        "New Job added on  {$dcid} "
                    );
                }
            }
        });
    }

    public function rmJObFrmChallen(Request $request)
    {
        $dcId = $request->dcid;
        $jobIds = $request->input('jobIds');
        if (is_string($jobIds)) {
            $jobIds = json_decode($jobIds, true);
        }
        foreach ($jobIds as $jobId) {

            DeliveryChallanData::where('jobId', $jobId)->where('dcid', $dcId)
                ->delete();
            Jobcomments::create([
                'jbid' => $jobId,
                'usid' => Auth::user()->id,
                'type' => 'App',
                'message' => "Job removed from $dcId",
            ]);
            Jobs::where('id', $jobId)->update([
                'status' => 'Ready for delivery',
                'chalan' => NULL
            ]);
            Dchistory::create([
                'dcid' => $dcId,
                'usid' => Auth::user()->id,
                'type' => 'user',
                'message' => "$jobId  Deleted",
            ]);
            AuditLogModel::addAudit(Auth::user()->id,
                        'Chalan Updated',
                        "Job removed from  {$dcid} "
                    );
        }
    }
    public function delChallen(Request $request)
    {
        $dcId = $request->dcid;
        $jobs = DeliveryChallanData::where('dcid', $dcId)->pluck('JobID');

        // If you want to convert the result to an array, you can use the `toArray` method
        $jobsArray = $jobs->toArray();
        foreach ($jobsArray as $jobId) {
            Jobs::where('id', $jobId)->update([
                'status' => 'Ready for delivery',
                'chalan' => NULL
            ]);
            Jobcomments::create([
                'jbid' => $jobId,
                'usid' => Auth::user()->id,
                'type' => 'App',
                'message' => "Job removed from $dcId as deleted",
            ]);
        }

        DeliveryChallanData::where('dcId', $dcId)->delete();
        delivery_challan_main::where('id', $dcId)->delete();
        Dchistory::create([
            'dcid' => $dcId,
            'usid' => Auth::user()->id,
            'type' => 'user',
            'message' => "Chalan deleted",
        ]);
        $parts = explode('/', $dcId);
        $lastPart = end($parts);

        Nextval::where('type', 'dc')->update(['sno' => $lastPart]);
        AuditLogModel::addAudit(Auth::user()->id,
                        'Chalan Deleted',
                        " {$dcid} Deleted "
                    );
    }

    public function getDeliveryChannal(Request $request)
    {
        $clid = $request->query('clid');

        if ($request->ajax()) {

            $clid = $request->query('clid');

            $data = delivery_challan_main::select([
                'id',
                DB::raw('DATE_FORMAT(created_at, "%d %b %Y, %h:%i %p") as formatted_created_at'),
                'invoiceid as invoice'
            ])
                ->where('clid', $clid)
                ->orderBy('created_at', 'desc')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.cldtl.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $name = Client::getname($clid);

        $centeredText = "Client transaction history for $name";

        return view('admin.cldtl.list', ['clid' => $clid], compact('centeredText'));
    }

    public function ListDeliveryChannal(Request $request)
    {
        $clid = $request->query('clid');

        $data = delivery_challan_main::select([
            'id',
            DB::raw('DATE_FORMAT(created_at, "%d %b %Y") as formatted_created_at'),
            'invoice'
        ])
            ->where('clid', $clid)
            ->whereNull('invoice')
            ->whereHas('deliveryChallanData', function ($query) {
                $query->where('status', 'Repaired');
            })
            ->get();
        // Log::info('Request Data: ' . json_encode($data->all()));

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return view('invoice.srvGst.actionChal', compact('row'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function printDeliveryChannal(Request $request)
    {
        $dlid = $request->query('jobid');

        $cdata = delivery_challan_main::select('*', DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as formatted_created_at'))
            ->where('id', $dlid)
            ->first();

        $data = DeliveryChallanData::select('*')
            ->where('dcId', $dlid)
            ->get();

        $cldtl = [
            'Clname' => $cdata->name,
            'cadd' => $cdata->address,
            'CEmail' => $cdata->email,
            'cmob' => $cdata->mobile,
            'cgst' => $cdata->gst,
        ];

        $appinfo = new AppinfoController();
        $getcomp = $appinfo->byid($cdata->comp);

        $companyDetails = [
            'CompName' => $getcomp->cname,
            'CompLogo' => $getcomp->logo,
            'CompAddress' => $getcomp->address,
            'CompGST' => $getcomp->gstno,
            'Compemail' => $getcomp->email,
            'Compcont1' => $getcomp->cont1,
            'Compcont2' => $getcomp->cont2,
        ];

        // Log::info($data);
        // Log::info( print_r($companyDetails, true));
        // Log::info( print_r($cldtl, true));

        return response()->json([
            'status' => true,
            'message' => 'successfully created',
            'companyDetails' => $companyDetails,
            'cldtl' => $cldtl,
            'data' => $data,
            'dcid' => $dlid,
            'date' => $cdata->formatted_created_at
        ]);
    }

    public function getJobBych(Request $request)
    {

        $data = DeliveryChallanData::select(['jobId', 'item', 'make', 'model', 'proprty', 'snno', 'complain', 'accessary', 'status', 'echarge'])
            ->where('dcid', $request->dcid)
            ->where('invoice', 0)
            ->where('status', 'Repaired')
            ->get();

        $hsn = Hsn::select('id', 'name', 'cgst', 'sgst')->where('status', 1)->get();
        return response()->json([
            'status' => true,
            'message' => 'Data fetched successfully.',
            'data' => $data,
            'hsn' => $hsn,
        ]);
    }
    public function getJobBychForEdit(Request $request)
    {

        $data = DeliveryChallanData::select(['jobId', 'item', 'make', 'model', 'proprty', 'snno', 'complain', 'accessary', 'status', 'echarge'])
            ->where('dcid', $request->dcid)
            ->where('invoice', 0)
            // ->where('status' , 'Repaired')
            ->get();

        $hsn = Hsn::select('id', 'name', 'cgst', 'sgst')->where('status', 1)->get();
        return response()->json([
            'status' => true,
            'message' => 'Data fetched successfully.',
            'data' => $data,
            'hsn' => $hsn,
        ]);
    }
}
