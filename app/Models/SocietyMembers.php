<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocietyMembers extends Model
{
    use HasFactory;

    protected $fillable = [
            'society_id',
            'member_id',
            'start_date',
            'end_date',
            'status',
            'other_info',
            'is_delete',
    ];
}
