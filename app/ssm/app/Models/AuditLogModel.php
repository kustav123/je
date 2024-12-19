<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLogModel extends Model
{
    use HasFactory;
    protected $table = 'audit';

    protected $fillable = ['userid', 'type', 'message', 'created_at'];

    public static function addAudit($userid, $type, $message)
    {
        // Create a new audit record
        return self::create([
            'userid' => $userid,
            'type' => $type,
            'message' => $message,
        ]);
    }

}
