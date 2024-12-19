<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Report extends Model
{
    use HasFactory;
    protected $table = 'report';

    protected $fillable = [
        'report_name',
        'report_type',
        'user_id',
        'status',
        'link',
    ];
    public static function createReport($report_name, $report_type, $user_id, $link)
    {
        return self::create([
            'report_name' => $report_name,
            'report_type' => $report_type,
            'user_id' => $user_id,
            'link' => $link,
            'status' => '1'
        ]);
    }
    public static function deleteFile($uid) {
        // Log::info('Delete');
        $recordtokeep = 5;
        $reportCount = self::where('user_id', $uid)->count();
        if($reportCount >  $recordtokeep) {
            $remainingReports = self::where('user_id', $uid)
            ->orderBy('created_at', 'desc')
            ->skip( $recordtokeep)
            ->take(50)
            ->get(['id', 'link']);
            foreach($remainingReports as $report) {
                $report->delete();
                unlink(storage_path("app/public/{$report->link}"));
            }
        }

    }

}
