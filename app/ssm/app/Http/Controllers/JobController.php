<?php

namespace App\Http\Controllers;

use App\Models\backupEditedJOb;
use App\Models\Jobcomments;
use App\Models\AuditLogModel;

use App\Models\Jobs;
use App\Models\Jobsitem;
use App\Models\Modellist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class JobController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
                if(Auth::user()->role == 'ST'){
                $data = DB::table('job')
                ->join('client', 'job.clid', '=', 'client.id')
                ->join('job_item', 'job.id', '=', 'job_item.jobid')
                ->leftJoin('appuser', function ($join) {
                    $join->on('job.assigned', '=', 'appuser.id')
                        ->whereNotNull('job.assigned'); // Conditionally join only when assigned is not null
                })
                ->select('job.id as Job', 'client.name', 'job.status', 'job.echarge', DB::raw('IFNULL(appuser.name, "") as uname'), 'job_item.item',
                DB::raw('DATE_FORMAT(job.created_at, "%d-%m-%Y") as created_date')
                )
                -> where ('job.chalan', NULL)
                -> where ('job.assigned' , Auth::user()->id )
                ->get();
                }else{
                    $data = DB::table('job')
                    ->join('client', 'job.clid', '=', 'client.id')
                    ->join('job_item', 'job.id', '=', 'job_item.jobid')
                    ->leftJoin('appuser', function ($join) {
                        $join->on('job.assigned', '=', 'appuser.id')
                            ->whereNotNull('job.assigned'); // Conditionally join only when assigned is not null
                    })
                    ->select('job.id as Job', 'client.name', 'job.status', 'job.echarge', DB::raw('IFNULL(appuser.name, "") as uname'), 'job_item.item')

                    ->get();
                }



            // Log::info('Fetched data: ', ['data' => $data]);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('jobs.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $centeredText = 'List of assigned jobs';

        return view('jobs.jobmanage',
        [
            'centeredText' => $centeredText,


        ]
    );

    }


    public function adminJobOpen(Request $request)
    {
        if ($request->ajax()) {


                $data = DB::table('job')
                ->join('client', 'job.clid', '=', 'client.id')
                ->join('job_item', 'job.id', '=', 'job_item.jobid')
                ->leftJoin('appuser', function ($join) {
                    $join->on('job.assigned', '=', 'appuser.id')
                        ->whereNotNull('job.assigned');
                })
                ->select('job.id as Job', 'client.name', 'job.status', 'job.echarge',
                 DB::raw('IFNULL(appuser.name, "") as uname'), 'job_item.item', 'job_item.make',  'job_item.model',  'job_item.snno',
                 DB::raw('DATE_FORMAT(job.created_at, "%d-%m-%Y") as created_date')
                 )
                 ->where('job.status', '=', 'Open') // Exclude records where job.status is 'Close'
                 ->orderBy('job.id')
                 ->get();
            // Log::info('Fetched data: ', ['data' => $data]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('jobs.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        if(Auth::user()->role == 'AD'){
            $centeredText = 'List of open jobs ';

        return view('jobs.adminjobmanage',[
            "type" => 'open',
            'centeredText' => $centeredText,

        ]);
     }else {
        return response('Not allowed', 403);

        }

    }

    public function adminJobRunning(Request $request)
    {
        if ($request->ajax()) {

                $data = DB::table('job')
                ->join('client', 'job.clid', '=', 'client.id')
                ->join('job_item', 'job.id', '=', 'job_item.jobid')
                ->leftJoin('appuser', function ($join) {
                    $join->on('job.assigned', '=', 'appuser.id')
                        ->whereNotNull('job.assigned');
                })
                ->select('job.id as Job', 'client.name', 'job.status', 'job.echarge',
                DB::raw('IFNULL(appuser.name, "") as uname'), 'job_item.item',  'job_item.make',  'job_item.model',  'job_item.snno',
                DB::raw('DATE_FORMAT(job.created_at, "%d-%m-%Y") as created_date')
                )
                ->whereNotIn('job.status', ['Open', 'Delivered'])
                ->orderBy('job.UPDATED_AT', 'desc')

                ->get();

            // Log::info('Fetched data: ', ['data' => $data]);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('jobs.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        if(Auth::user()->role == 'AD'){
            $centeredText = 'List of running jobs ';

        return view('jobs.adminjobmanage',[
            "type" => 'running',
            'centeredText' => $centeredText,

        ]);
    }else {
            return response('Not allowed', 403);

            }

    }

    public function adminJobClosed(Request $request)
    {
        if ($request->ajax()) {

                $data = DB::table('job')
                ->join('client', 'job.clid', '=', 'client.id')
                ->join('job_item', 'job.id', '=', 'job_item.jobid')
                ->leftJoin('appuser', function ($join) {
                    $join->on('job.assigned', '=', 'appuser.id')
                        ->whereNotNull('job.assigned');
                })
                ->select('job.id as Job', 'client.name', 'job.status', 'job.echarge',
                DB::raw('IFNULL(appuser.name, "") as uname'), 'job_item.item', 'job_item.make',  'job_item.model',  'job_item.snno',
                DB::raw('DATE_FORMAT(job.created_at, "%d-%m-%Y") as created_date')
                )
                ->where('job.status', 'Delivered')
                ->orderBy('job.UPDATED_AT', 'desc')

                ->get();

            // Log::info('Fetched data: nn', ['data' => $data]);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('jobs.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        if(Auth::user()->role == 'AD'){
            $centeredText = 'List of closed jobs';

        return view('jobs.adminjobmanage',[
            "type" => 'closed',
            'centeredText' => $centeredText


        ]);  }else {
            return response('Not allowed', 403);

            }

    }




    public function addnew(Request $request)
    {
        $request->validate([
            'clid' => 'required',
            'select_company' => 'required'
        ]);

        $msg = "";
        $purpose = $request->purpose;

        if ($purpose == 'insert') {

            if ($request->select_company == 1) {
                $sequence = DB::table('secuence')
                    ->select('sno', 'head')
                    ->where('type', 'jobfe')
                    ->lockForUpdate()
                    ->first();
            } elseif ($request->select_company == 2) {
                $sequence = DB::table('secuence')
                    ->select('sno', 'head')
                    ->where('type', 'jobfl')
                    ->lockForUpdate()
                    ->first();
            }


            if ($request->newmodel == 1) {
                Modellist::addModel($request->make,$request->model, $request->item);

            }
            // Calculate new job ID
            $head = $sequence->head;
            $newJobId = $sequence->sno + 1;
            $newJobId = str_pad($newJobId, 5, '0', STR_PAD_LEFT);
            $newJobId = $head . '/' . $newJobId;

            $accessary = implode(', ', $request->accessary);
            $complain = implode(', ', $request->complain);

            DB::transaction(function () use ($request, $newJobId, $accessary, $complain) {
                Jobs::create([
                    'id' => $newJobId,
                    'clid' => $request->clid,
                    'status' => "Open",
                    'echarge' => $request->rest,
                    'remarks' => $request->job_remarks,
                    'comp' => $request->select_company,
                    'name' => $request-> name,
                    'mobile' => $request-> mobile_number,
                    'address' => $request-> address,
                    'gst' => $request-> gst_no,
                    'email' => $request-> email
                ]);

                Jobsitem::create([
                    'jobid' => $newJobId,
                    'item' => $request->item,
                    'make' => $request->make,
                    'model' => $request->model,
                    'snno' => $request->snno,
                    'proprty' => $request->property,
                    'accessary' => $accessary,
                    'complain' => $complain,
                ]);

                Jobcomments::create([
                    'jbid' => $newJobId,
                    'usid' => Auth::user()->id,
                    'type' => 'App',
                    'message' => 'Job Created',
                ]);

                DB::table('secuence')
                    ->where('type', 'job')
                    ->increment('sno');


                    if ($request->select_company == 1) {
                        DB::table('secuence')
                        ->where('type', 'jobfe')
                        ->increment('sno');
                    } elseif ($request->select_company == 2) {
                        DB::table('secuence')
                        ->where('type', 'jobfl')
                        ->increment('sno');
                    }
                AuditLogModel::addAudit(Auth::user()->id,
                    'Job',
                    "New Job added  {$newJobId} for {$request->clid}"
                );

            });

            $createdDate = now()->format('d-m-Y');

            $appinfo = new AppinfoController();
            $getcomp = $appinfo->byid($request->select_company);

            Cache::forget('open_jobs');
            Cache::forget('assigned_jobs');
            Cache::forget('hold');
            Cache::forget('pending');
            Cache::forget('readyfordel');

            return response()->json([
                'Jobid' => $newJobId,
                'Name' => $request->name,
                'Address' => $request->address,
                'GSTNo' => $request->gst_no,
                'Email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'Item' => $request->item,
                'Make' => $request->make,
                'Model' => $request->model,
                'SNo' => $request->snno,
                'Property' => $request->property,
                'Complain' => $complain,
                'Accessary' => $accessary,
                'Job_Remarks' => $request->job_remarks,
                'Estimation' => $request->rest,
                'CompName' => $getcomp->cname,
                'CompLogo' => $getcomp->logo,
                'CompAddress' => $getcomp->address,
                'CompGST' => $getcomp->gstno,
                'Compemail' => $getcomp->email,
                'Compcont1' => $getcomp->cont1,
                'Compcont2' => $getcomp->cont2,
                'CreatedDate' => $createdDate,
            ]);
        }
    }



    public function addnewPage(Request $request)

    {

        $appinfo = new AppinfoController();
        $listcomp = $appinfo ->getlist();

        $queue = DB::table('job')
        ->where('status', 'Open')
        ->count();
        $newqueue = $queue + 1;


            $fesequence = DB::table('secuence')
                ->select('sno', 'head')
                ->where('type', 'jobfe')
                ->lockForUpdate()
                ->first();

            $flsequence = DB::table('secuence')
                ->select('sno', 'head')
                ->where('type', 'jobfl')
                ->lockForUpdate()
                ->first();


        //  Log::info('fesequence', ['fesequence' => $fesequence]);
        // Pad the sno value to ensure it's 5 digits long
                // Update the sequence in the database
        $centeredText = 'Create New Job ';

       return view("jobs.addJob", [

        'newqueue' => $newqueue,
        'listcomp' => $listcomp,
        'centeredText' => $centeredText,
        'feseq' => $fesequence,
        'flseq' => $flsequence


    ]);
    }
    public function GetJobDetails(Request $request)
    {

        // Log::info('Incoming request', ['job_id' => $request->jobid]);

        $jobdtl = DB::table('job_comment')
        ->join('appuser', 'job_comment.usid', '=', 'appuser.id')
        ->select(DB::raw("jbid,DATE_FORMAT(job_comment.created_at, '%Y-%m-%d %H:%i') as created_at"), 'appuser.name', 'job_comment.type', 'job_comment.message')
        ->where('jbid', $request->jobid)
        ->orderBy('job_comment.id','asc')
        ->get();

        // Log::info('Incoming request', ['job_id' => $request->jobid]);

        // Log::info('jobdtl', ['jobdtl' => $jobdtl]);
        return response()->json($jobdtl);
    }

    public function UpdateComment(Request $request)
    {

        Jobcomments::create([
            'jbid' => $request -> jobid,
            'usid' => Auth::user()->id,
            'type' => 'User',
            'message' => $request-> comment

        ]) ;
        return response()->json([
            'success' => true,

        ]);

    }

    public function UpdateJob(Request $request)
    {


         $request->validate([
            'jobid' => 'required',

            ]);



            if ($request->status === 'Assign' && $request->assigned_to) {
                // Update Jobs table

                DB::transaction(function () use ($request) {
                    Jobs::where('id', $request->jobid)->update([
                        'assigned' => $request->assigned_to,
                        'status' => 'Assigned'
                    ]);

                    // Create Jobcomments record
                    Jobcomments::create([
                        'jbid' => $request->jobid,
                        'usid' => Auth::user()->id,
                        'type' => 'User',
                        'message' => 'Job Assigned to ' . $request->assigned_to,
                    ]);
                    Jobcomments::create([
                        'jbid' => $request->jobid,
                        'usid' => Auth::user()->id,
                        'type' => 'User',
                        'message' =>  $request->comment,
                    ]);
                    Cache::forget('open_jobs');
                    Cache::forget('assigned_jobs');
                    Cache::forget('hold');
                    Cache::forget('pending');
                    Cache::forget('readyfordel');
                });
                } elseif ($request->status === 'Ready for delivery') {
                    // Update Jobs table for 'Ready for delivery' status
                    DB::transaction(function () use ($request) {
                        Jobs::where('id', $request->jobid)->update([
                            'assigned' => NULL,
                            'status' => 'Ready for delivery',
                            'chalan' => NULL,
                        ]);

                        // Create Jobcomments record
                        Jobcomments::create([
                            'jbid' => $request->jobid,
                            'usid' => Auth::user()->id,
                            'type' => 'User',
                            'message' => 'Job Ready for delivery',
                        ]);
                        Jobcomments::create([
                            'jbid' => $request->jobid,
                            'usid' => Auth::user()->id,
                            'type' => 'Challan',
                            'message' =>  $request->comment,
                        ]);
                        Cache::forget('open_jobs');
                        Cache::forget('assigned_jobs');
                        Cache::forget('hold');
                        Cache::forget('pending');
                        Cache::forget('readyfordel');
                    });


                } else {
                    DB::transaction(function () use ($request) {
                        Jobs::where('id', $request->jobid)->update([
                            'status' => $request->status
                        ]);

                        Jobcomments::create([
                            'jbid' => $request->jobid,
                            'usid' => Auth::user()->id,
                            'type' => 'User',
                            'message' => 'Changed Status to ' . $request->status,
                        ]);
                        Jobcomments::create([
                            'jbid' => $request->jobid,
                            'usid' => Auth::user()->id,
                            'type' => 'User',
                            'message' =>  $request->comment,
                        ]);
                        Cache::forget('open_jobs');
                        Cache::forget('assigned_jobs');
                        Cache::forget('hold');
                        Cache::forget('pending');
                        Cache::forget('readyfordel');
                    });
                  
                    }
                    AuditLogModel::addAudit(Auth::user()->id,
                    'Job',
                    "Job Status updated for {$request->jobid} to {$request->status}"
                );

    }
public function Jobcard(Request $request)
    {
        // Log::info('Incoming request', ['job_id' => $request->jobid]);

        $jobcard = DB::table('job')
        ->join('job_item', 'job.id', '=', 'job_item.jobid')
        ->join('appinfo', 'job.comp', '=', 'appinfo.id')
        ->select(
            'job.id as job_id',
            'job.echarge as job_echarge',
            'job.name as client_name',
            'job.address as client_address',
            'job.gst as client_gst',
            'job.email as client_email',
            'job.mobile as client_mobile',
            'job_item.item as job_item',
            'job_item.make as job_make',
            'job_item.model as job_model',
            'job_item.snno as job_snno',
            'job_item.proprty as job_property',
            'job_item.complain as job_complain',
            'job_item.accessary as job_accessary',
            'job_item.remarks as job_remarks',
            'appinfo.name as appinfo_name',
            'appinfo.logo as appinfo_logo',
            'appinfo.address as appinfo_address',
            'appinfo.gstno as appinfo_gstno',
            'appinfo.email as appinfo_email',
            'appinfo.cont1 as appinfo_cont1',
            'appinfo.cont2 as appinfo_cont2',
            DB::raw('DATE_FORMAT(job.created_at, "%d-%m-%Y") as created_date')
            )
        ->where('job.id', $request->jobid)
        ->first();
        // Log::info($jobcard);

    // Return the response
    if ($jobcard) {
        return response()->json([
            'Jobid' => $jobcard->job_id,
            'date' => $jobcard->created_date,
            'Name' => $jobcard->client_name,
            'Address' => $jobcard->client_address,
            'GSTNo' => $jobcard->client_gst,
            'Email' => $jobcard->client_email,
            'mobile_number' => $jobcard->client_mobile,
            'Item' => $jobcard->job_item,
            'Make' => $jobcard->job_make,
            'Model' => $jobcard->job_model,
            'SNo' => $jobcard->job_snno,
            'Property' => $jobcard->job_property,
            'Complain' => $jobcard->job_complain,
            'Accessary' => $jobcard->job_accessary,
            'Job_Remarks' => $jobcard->job_remarks,
            'Estimation' => $jobcard->job_echarge,
            'CompName' => $jobcard->appinfo_name,
            'CompLogo' => $jobcard->appinfo_logo,
            'CompAddress' => $jobcard->appinfo_address,
            'CompGST' => $jobcard->appinfo_gstno,
            'Compemail' => $jobcard->appinfo_email,
            'Compcont1' => $jobcard->appinfo_cont1,
            'Compcont2' => $jobcard->appinfo_cont2
        ]);
    } else {
        return response()->json([
            'message' => 'Job not found'
        ], 404);


    }

}

public function CombimeJobcard(Request $request){
    $jobIds = $request->input('ids');

    $firstJobId = $jobIds[0];

    $CommonjobDetails = Jobs::select(
        'job.name',
        'job.address',
        'job.mobile',

        'job.email',
        'job.clid',
        DB::raw('DATE_FORMAT(job.created_at, "%d-%m-%Y") as created_date'),
        'appinfo.name as appinfo_name',
        'appinfo.logo as appinfo_logo',
        'appinfo.address as appinfo_address',
        'appinfo.gstno as appinfo_gstno',
        'appinfo.email as appinfo_email',
        'appinfo.cont1 as appinfo_cont1',
        'appinfo.cont2 as appinfo_cont2'
     )
    ->join('appinfo', 'job.comp', '=', 'appinfo.id')
    ->where('job.id', $firstJobId)
    ->first();


    $jobDetails = [];
    foreach ($jobIds as $jobId) {
        // Fetch all job items for the current job ID
        $jobItems = Jobsitem::where('jobid', $jobId)->get();

        // Check if there are any job items
        if ($jobItems->isNotEmpty()) {
            // Loop through each job item and fetch the related job details
            foreach ($jobItems as $jobItem) {
                // Append job item details and related job info to the result array
                $jobDetails[] = [
                    'jobItem' => $jobItem,
                ];
            }
        }
    }
    $response = [
        'commonJobDetails' => $CommonjobDetails,
        'jobDetails' => $jobDetails
    ];

    // Return the combined response as JSON
    return response()->json($response);
}


public function editJob(Request $request){
    if ($request->isMethod('get')) {

        $appinfo = new AppinfoController();
        $listcomp = $appinfo ->getlist();

        $queue = DB::table('job')
        ->where('status', 'Open')
        ->count();
        $newqueue = $queue + 1;
        $jobId = $request->query('id');

        $job = Jobs::find($jobId);
        $jobItem = $job->jobItems->first();

        $id = $job->id;
        $clid = $job->clid;
        $status = $job->status;
        $echarge = $job->echarge;
        $assigned = $job->assigned;
        $remarks = $job->remarks;
        $comp = $job->comp;
        $created_at = $job->created_at;
        $name = $job->name;
        $mobile = $job->mobile;
        $email = $job->email;
        $address = $job->address;
        $gst = $job->gst;

        $jobItemId = $jobItem->id;
        $jobItemItem = $jobItem->item;
        $jobItemMake = $jobItem->make;
        $jobItemModel = $jobItem->model;
        $jobItemSnno = $jobItem->snno;
        $jobItemProperty = $jobItem->proprty;
        $jobItemAccessary = $jobItem->accessary;
        $jobItemComplain = $jobItem->complain;
        $jobItemRemarks = $jobItem->remarks;

        $centeredText = 'Edit Job ';


        // Pass each variable to the view
        return view('jobs.editJob', [
            'id' => $id,
            'clid' => $clid,
            'status' => $status,
            'echarge' => $echarge,
            'assigned' => $assigned,
            'remarks' => $remarks,
            'comp' => $comp,
            'created_at' => $created_at,
            'name' => $name,
            'mobile' => $mobile,
            'email' => $email,
            'address' => $address,
            'gst' => $gst,
            'jobItemId' => $jobItemId,
            'jobItemItem' => $jobItemItem,
            'jobItemMake' => $jobItemMake,
            'jobItemModel' => $jobItemModel,
            'jobItemSnno' => $jobItemSnno,
            'jobItemProperty' => $jobItemProperty,
            'jobItemAccessary' => $jobItemAccessary,
            'jobItemComplain' => $jobItemComplain,
            'jobItemRemarks' => $jobItemRemarks,
            'newqueue' => $newqueue,
            'listcomp' => $listcomp,
            'centeredText' => $centeredText,
        ]);
    }
        if ($request->isMethod('post')) {

                    $jobId = $request->input('jobid');
                    $jobItemId = $request->input('itid');

                    // Find the job by its ID
                    $job = Jobs::find($jobId);
                    $jobItem = JobsItem::find($jobItemId);


                    $accessary = implode(', ', $request->accessary);
                    $complain = implode(', ', $request->complain);

                    // Log::info($job);
                    $jobJson = $job->toJson();
                    $jobItemJson = $jobItem->toJson();
                    $backupModel = new backupEditedJOb();
                    $backupModel->id = $jobId;
                    $backupModel->userid = Auth::user()->id;
                    $backupModel->job = $jobJson;
                    $backupModel->jobitem = $jobItemJson;
                    $backupModel->save();


                    $job->clid = $request->input('clid');
                    $job->name = $request->input('name');
                    $job->mobile = $request->input('mobile_number');
                    $job->email = $request->input('email');
                    $job->gst = $request->input('gst_no');
                    $job->remarks = $request->input('job_remarks');
                    $job->echarge = $request->input('rest');
                    $job->address = $request->input('address');
                    $job->save();


                    $jobItem->item = $request->input('item');
                    $jobItem->make = $request->input('make');
                    $jobItem->model = $request->input('model');
                    $jobItem->snno = $request->input('snno');
                    $jobItem->proprty = $request->input('property');
                    $jobItem->accessary = implode(', ', $request->input('accessary', [])); // Convert array to comma-separated string
                    $jobItem->complain = implode(', ', $request->input('complain', [])); // Convert array to comma-separated string
                    $jobItem->remarks = $request->input('job_remarks');
                    $jobItem->save();

                Jobcomments::create([
                    'jbid' => $jobId,
                    'usid' => Auth::user()->id,
                    'type' => 'User',
                    'message' => 'Job Edited successfully',
                ]);

                AuditLogModel::addAudit(Auth::user()->id,
                'Job',
                "Job Edited for {$jobId}"
            );


                $createdDate = now()->format('d-m-Y');

                $appinfo = new AppinfoController();
                $getcomp = $appinfo->byid($request->select_company);

                return response()->json([
                    'Jobid' => $jobId,
                    'Name' => $request->name,
                    'Address' => $request->address,
                    'GSTNo' => $request->gst_no,
                    'Email' => $request->email,
                    'mobile_number' => $request->mobile_number,
                    'Item' => $request->item,
                    'Make' => $request->make,
                    'Model' => $request->model,
                    'SNo' => $request->snno,
                    'Property' => $request->property,
                    'Complain' => $complain,
                    'Accessary' => $accessary,
                    'Job_Remarks' => $request->job_remarks,
                    'Estimation' => $request->rest,
                    'CompName' => $getcomp->cname,
                    'CompLogo' => $getcomp->logo,
                    'CompAddress' => $getcomp->address,
                    'CompGST' => $getcomp->gstno,
                    'Compemail' => $getcomp->email,
                    'Compcont1' => $getcomp->cont1,
                    'Compcont2' => $getcomp->cont2,
                    'CreatedDate' => $createdDate,
                ]);

        }



}

public function listJobbyCl(Request $request) {
     $clid = $request->query('clid');

     $jobsQuery = Jobs::where('clid', $clid)
     ->join('job_item', 'job.id', '=', 'job_item.jobid')

     ->leftJoin('appuser', function ($join) {
         $join->on('job.assigned', '=', 'appuser.id')
              ->whereNotNull('job.assigned');
     })
     ->select(
         'job.id as id',
         'job.status',
         'job.echarge',
         'job_item.make',  'job_item.model',  'job_item.snno',
         DB::raw('IFNULL(appuser.name, "") as assigned'),
         'job_item.item',
         DB::raw('DATE_FORMAT(job.created_at, "%d-%m-%Y") as created_date')
     );
        return DataTables::of($jobsQuery)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.cldtl.actionjob', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);

}

}
