<?php

namespace App\Http\Controllers;

use App\Jobs\ExportClInvoicePdf;
use App\Jobs\ExportClInvoiceXls;
use App\Jobs\ExportCompGSTReportInvPDF;
use App\Jobs\ExportCompGSTReportInvXLS;
use App\Jobs\ExportCompInvPdf;
use App\Jobs\ExportCompInvXls;
use App\Jobs\ExportCompLedgerPdf;
use App\Jobs\ExportCompLedgerXls;
use App\Jobs\ExportLedgerCsv;
use App\Jobs\ExportLedgerPdf;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{

    public function clindex()
    {

        $reports = Report::where( 'user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();
        $centeredText = 'Client Report';

        return view('report.clreport', [
            'centeredText' => $centeredText,
            'reports' => $reports,
        ]);


    }
    public function coindex()
    {

        $appinfo = new AppinfoController();
        $listcomp = $appinfo->getlist();
        $reports = Report::where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();
        $centeredText = 'Company Report';

        return view('report.coreport', [
            'centeredText' => $centeredText,
            'reports' => $reports,
            'listcomp' => $listcomp,

        ]);


    }

//client ledger both pdf excel
    public function submitExportLedBoth(Request $request)
    {
        $this->submitExportLedXls($request);

        $this->submitExportLedPdf($request);

        return response()->json([
            'message' => 'Both XLS and PDF export jobs have been submitted successfully. The links will be available in the table once processing is complete.',
        ]);

    }
//client ledger   excel

    public function submitExportLedXls(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'clid' => 'required',
            'uid' => Auth::user()->id
        ]);

        ExportLedgerCsv::dispatch($validated['from'], $validated['to'], $validated['clid'], Auth::user()->id);
        return response()->json([
            'message' => 'Job submitted successfully. The ledger export will be processed in the background and link will be in table. ',
        ]);
    }
//client ledger   pdf

    public function submitExportLedPdf(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'clid' => 'required',
            'uid' => Auth::user()->id

        ]);
        ExportLedgerPdf::dispatch($validated['from'], $validated['to'], $validated['clid'], Auth::user()->id);
        return response()->json([
            'message' => 'Job submitted successfully. The ledger export will be processed in the background  and link will be in table.',
        ]);
    }



//client inv both
    public function submitExportClInvBoth(Request $request){
        $this->submitExportClInvPdf($request);

        $this->submitExportClInvXls($request);

        return response()->json([
            'message' => 'Both XLS and PDF export jobs have been submitted successfully. The links will be available in the table once processing is complete.',
        ]);

    }
//client inv pdf

    public function submitExportClInvPdf(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'clid' => 'required',
            'uid' => Auth::user()->id,
            'status' => 'required',
            'type' => 'required',
            'method' => 'required',

        ]);

        ExportClInvoicePdf::dispatch($validated['from'], $validated['to'], $validated['clid'], Auth::user()->id, $validated['status'],$validated['type'],$validated['method']);

        return response()->json([
            'message' => 'Job submitted successfully. The invoice export will be processed in the background  and link will be in table.',
        ]);
    }
    //client inv excel

    public function submitExportClInvXls(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'clid' => 'required',
            'uid' => Auth::user()->id,
            'status' => 'required',
            'type' => 'required',
            'method' => 'required',

        ]);

        ExportClInvoiceXls::dispatch($validated['from'], $validated['to'], $validated['clid'], Auth::user()->id, $validated['status'],$validated['type'],$validated['method']);

        return response()->json([
            'message' => 'Job submitted successfully. The invoice export will be processed in the background  and link will be in table.',
        ]);
    }
///////////////////////////////////////////////////////////////
///compny ledger pdf

    public function CompExportLedPdf(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'selectedCompany' => 'required',
            'uid' => Auth::user()->id

        ]);

        ExportCompLedgerPdf::dispatch($validated['from'], $validated['to'], $validated['selectedCompany'], Auth::user()->id);

        return response()->json([
            'message' => 'Job submitted successfully. The ledger export will be processed in the background  and link will be in table.',
        ]);
    }
// compny led excel
public function CompExportLedXls(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'selectedCompany' => 'required',
            'uid' => Auth::user()->id

        ]);

        ExportCompLedgerXls::dispatch($validated['from'], $validated['to'], $validated['selectedCompany'], Auth::user()->id);

        return response()->json([
            'message' => 'Job submitted successfully. The ledger export will be processed in the background  and link will be in table.',
        ]);
    }

///compny inv excel

    public function CompExportInvXls(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'selectedCompany' => 'required',
            'uid' => Auth::user()->id,
            'status' => 'required',
            'type' => 'required',
            'method' => 'required',



        ]);
        // Log::info($validated['type']);

        ExportCompInvXls::dispatch($validated['from'], $validated['to'], $validated['selectedCompany'], Auth::user()->id,$validated['status'],$validated['type'],$validated['method']);

        return response()->json([
            'message' => 'Job submitted successfully. The ledger export will be processed in the background  and link will be in table.',
        ]);
    }


    //company Inv PDF
    public function CompExportInvPdf(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
            'selectedCompany' => 'required',
            'uid' => Auth::user()->id,
            'status' => 'required',
            'type' => 'required',
            'method' => 'required',
        ]);
        // Log::info($validated['type']);

        ExportCompInvPdf::dispatch($validated['from'], $validated['to'], $validated['selectedCompany'], Auth::user()->id,$validated['status'],$validated['type'],$validated['method']);

        return response()->json([
            'message' => 'Job submitted successfully. The ledger export will be processed in the background  and link will be in table.',
        ]);


    }
    public function submitExportCoInvBoth(Request $request)
    {
        $this->CompExportInvXls($request);

        $this->CompExportInvPdf($request);

        return response()->json([
            'message' => 'Both XLS and PDF export jobs have been submitted successfully. The links will be available in the table once processing is complete.',
        ]);

    }

    public function submitExportCoLedBoth(Request $request)
    {
        $this->CompExportLedPdf($request);

        $this->CompExportLedXls($request);

        return response()->json([
            'message' => 'Both XLS and PDF export jobs have been submitted successfully. The links will be available in the table once processing is complete.',
        ]);

    }



            //comp gst accont statemnet
     public function CompExportGstAccXls(Request $request)
        {
            $validated = $request->validate([
                'from' => 'required|date',
                'to' => 'required|date|after_or_equal:from',
                'selectedCompany' => 'required',
                'uid' => Auth::user()->id,
                'type' => 'required',

            ]);
            // Log::info($validated['type']);

            ExportCompGSTReportInvXLS::dispatch($validated['from'], $validated['to'], $validated['selectedCompany'], Auth::user()->id,$validated['type']);

            return response()->json([
                'message' => 'Job submitted successfully. The ledger export will be processed in the background  and link will be in table.',
            ]);
        }
        public function CompExportGstAccPdf(Request $request)
        {
            $validated = $request->validate([
                'from' => 'required|date',
                'to' => 'required|date|after_or_equal:from',
                'selectedCompany' => 'required',
                'uid' => Auth::user()->id,
                'type' => 'required',

            ]);
            // Log::info($validated['type']);

            ExportCompGSTReportInvPDF::dispatch($validated['from'], $validated['to'], $validated['selectedCompany'], Auth::user()->id,$validated['type']);

            return response()->json([
                'message' => 'Job submitted successfully. The ledger export will be processed in the background  and link will be in table.',
            ]);
        }

        public function CompExportGstAccBoth(Request $request)
        {
            $this->CompExportGstAccXls($request);

            $this->CompExportGstAccPdf($request);
    
            return response()->json([
                'message' => 'Both XLS and PDF export jobs have been submitted successfully. The links will be available in the table once processing is complete.',
            ]);
        }
}

